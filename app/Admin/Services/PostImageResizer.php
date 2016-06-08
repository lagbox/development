<?php

namespace Flashtag\Admin\Services;

class PostImageResizer extends Resizer
{
    protected $path = 'images/media/';

    protected static $name = 'post';

    protected static $imageField = 'image';

    public static function sizes()
    {
        // pull from config ... or settings
        return [
            'lg' => 600,
            'md' => 400,
            'sm' => 200,
            'xs' => 80,
        ];
        // larger to smaller order
    }

    /*
        static to allow us to use this in other places
     */
    // public static function formatFilename($post, $size, $file = null)
    // {
    //     $extension = static::getExtension($file ?: $post->image);

    //     return "post__{$post->id}__{$post->slug}__{$size}". $extension;
    // }
}

/*
static calls so we can get these image names later when needed

PostImageResizer::formatFilename($post, 'sm', $post->image);

maybe a helper function

    getImageName($entity, $size, [$file]) {
        $a = [
            'Flashtag\Data\Post' => PostImageResizer,
            'Flashtag\Data\Category' => CategoryImageResizer,
        ];

        return $a[get_class($entity)]::formatFilename($entity, $size, $file);
    }

or

    // and remove the need for static

    return app($a[get_class($entity)])->formatFilename($entity, $size, $file);
 */
