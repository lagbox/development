<?php

namespace Flashtag\Admin\Services;

class CategoryImageResizer extends Resizer
{
    protected $path = 'images/media/';

    protected static $name = 'category';

    protected static $imageField = 'cover_image';

    public function sizes()
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

    // public function formatFilename($category, $size, $file)
    // {
    //     $extension = static::getExtension($file ?: $category->cover_image);

    //     return "category__{$category->id}__{$category->slug}__{$size}". $extension;
    // }
}
