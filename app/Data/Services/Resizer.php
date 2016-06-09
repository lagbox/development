<?php

namespace Flashtag\Data\Services;

// intervention image facade
use Image;
use Flashtag\Data\Interfaces\HasResizableImages;

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

    public function doIt(HasResizableImages $entity, $field)
    {
        $file = $entity->$field;

        // decide on pathing
        $image = Image::make($file);

        foreach ($this->formatSizes() as $size => $dems) {
            $filename = $this->formatFilename($entity, $size, $field);
            $this->resize($image, $dems);
            $this->save($image, $filename);
        }
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

        Storage::disk('public')->put($path. $name, $img->stream());
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

    public function formatFilename(HasResizableImages $entity, $size, $imageField, $file = null)
    {
        $extension = $this->getExtension($file ?: $entity->$imageField);

        return "{$entity->getImageType()}__{$entity->id}__{$entity->slug}__{$size}". $extension;
    }


    protected function getExtension($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    public function getImagesForEntity(HasResizableImages $entity, $field = null, $file = null)
    {
        $sizes = array_keys($resizer->sizes());

        $fields = $field ? (array) $field : $entity->getImageFields();

        foreach ($fields as $f) {
            foreach ($sizes as $size) {
                $names[$f][] = $resizer->formatFilename($entity, $size, $f, $file);
            }
        }

        return $names;
    }
}


function getImagesForEntity(HasResizableImages $entity, $field = null)
{
    return app(Resizer::class)->getImagesForEntity($entity, $field);
}
