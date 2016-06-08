<?php

namespace Flashtag\Admin\Services;

// intervention image facade
use Image;

abstract class Resizer
{
    public static function sizes()
    {
        // return some base set from config/settings
        return [];
    }

    public function doIt($file, $entity)
    {
        // decide on pathing
        $image = Image::make($file);

        foreach ($this->formatSizes() as $size => $dems) {
            $filename = $this->formatFilename($entity, $size, $file);
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
            if (! is_array($sizes)) {
                $sizes[$key] = ['width' => $size, 'height' => $size];
            } elseif () {
                $sizes[$key] = ['width' => $size[0], 'height' => $size[1]];
            } else {
                $sizes[$key] = $size;
            }
        }
    }

    protected static function getExtension($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    public static function formatFilename($entity, $size, $file = null)
    {
        $extension = static::getExtension($file ?: $entity->{static::$imageField});

        return "{static::$name}__{$entity->id}__{$entity->slug}__{$size}". $extension;
    }
}
