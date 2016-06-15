<?php

namespace Flashtag\Data\Services;

// intervention image facade
use Image;
use Flashtag\Data\Resizable;

class Resizer
{
    protected $path = 'images/media/';

    protected $type;

    public static $sizes = [
        'lg' => 600,
        'md' => 400,
        'sm' => 200,
        'xs' => 80,
    ];

    public function __construct($path = null)
    {
        if ($path) {
            $this->setPath($path);
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public static function sizes($sizes = null)
    {
        return $sizes ? static::$sizes = $sizes : static::$sizes;
    }

    public function doIt(Resizable $entity)
    {
        $file = $entity->original;

        $file = config('site.uploads.images.path') .'/'. $file;

        $image = Image::make($file);

        foreach ($this->formatSizes() as $size => $dems) {
            $filename = $this->formatFilename($entity, $size);
            $this->resize($image, $dems);
            $this->save($image, $filename);
            $entity->{$size} = $filename;
        }

        $entity->save();
    }

    protected function resize($img, $dems)
    {
        // check if there is a need to resize based on dimensions passed
        if ($img->height() < $dems['height'] && $img->width() < $dems['width']) {
            return false;
        }
        // resize to dimensions
        //  respecting aspectRatio and never upsizing
        $img->resize($dems['width'], $dems['height'], function ($con) {
            $con->aspectRatio();
            $con->upsize();
        });

        return true;
    }

    protected function save($img, $name, $path = null)
    {
        $path = $path ?: $this->path;

        //public_path('images/media');
        if (config('site.uploads.images.default') == 'path') {
            $img->save(config('site.uploads.images.path'). '/'. $name);
        } else {
            $path = config('site.uploads.images.storage.path');
            $disk = config('site.uploads.images.storage.disk');
            Storage::disk($disk)->put($path. '/'. $name, $img->stream());
        }
    }

    protected function formatSizes()
    {
        /*
        allow for multiple formats
            'lg' => 800
        or
            'lg' => [800, 600]
        or
            'lg' => ['width' => ..., 'height' => ...]
         */
        foreach (static::sizes() as $key => $size) {
            if (! is_array($size)) {
                $f[$key] = ['width' => $size, 'height' => $size];
            } elseif (! isset($size['width'])) {
                $f[$key] = ['width' => $size[0], 'height' => $size[1]];
            } else {
                $f[$key] = $size;
            }
        }

        return $f;
    }

    protected function formatFileName($entity, $size)
    {
        $extension = pathinfo($entity->original, PATHINFO_EXTENSION);
        $filename = pathinfo($entity->original, PATHINFO_FILENAME);

        return "$filename__{$size}.{$extension}";
    }
}
