<?php

namespace Flashtag\Data\Interfaces;

interface HasResizableImages
{
    /**
     * Get the Image Fields used
     *
     * @return array List of field names that represent images
     */
    public function getImageFields();

    /**
     * The type of 'entity' these images belong to
     *
     * @return string A short name for the entity to distinguish its files
     */
    public function getImageType();
}
