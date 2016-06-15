<?php

namespace Flashtag\Data\Interfaces;

interface HasResizableImages
{
    /**
     * Get the Image Fields used
     *
     * @return array List of field names that represent images
     */
    public function getResizableImageFields();

    /**
     * The type of 'entity' these images belong to
     *
     * @return string A short name for the entity to distinguish its files
     */
    public function getResizableImageType();

    /**
     * The image sizes we want to resize to, and their dimensions.
     * @return array
     */
    public function getResizableImageSizes();

    public function getResizableBySize($field, $size);
}


/*
 *    public function getImageNameFormatters($name = null)
    {
        $formats = [
            'image' => function ($entity) {
                return "post-{$entity->id}__{$entity->slug}";
            },
            'cover_image' => function ($entity) {
                return "post-{$entity->id}__cover__{$entity->slug}";
            }
        ];

        return $name ? $formats[$name] : $formats;
    }

    // implement HasResizableImages

    public function getReziableImageFields()
    {
        return ['image'];
    }

    public function getResizableImageType()
    {
        return 'post';
    }

    public function getResizableBySize($field, $size)
    {
        if ($this->$field->relationLoaded('sizes')) {
            return $this->$field->sizes->where('size', $size)->first();
        } else {
            return $this->$field->sizes()->where('size', $size)->first();
        }
    }

    public function getResizableImageSizes()
    {
        return []; // use the defaults
    }
*/
