<?php

namespace Flashtag\Data\Listeners;

use Flashtag\Data\Services\Resizer;
use Flashtag\Data\Events\ResizableImageDeleted;

class ResizableImageSubscriber
{
    protected $resizer;

    public function __construct(Resizer $resizer)
    {
        $this->resizer = $resizer;
    }

    public function onCreate(ResizeableImageCreated $event)
    {
        $this->resizer->doIt($event->entity, $event->type);
    }

    public function onDelete(ResizableImageDeleted $event)
    {
        $file = basename($event->file);

        $names = $this->resizer->getImagesForEntity($event->entity, $event->type, $file);

        // spin through and remove those images
        foreach ($names[$event->type] as $filename) {
            // delete $filename
        }
    }

    public function subscribe($events)
    {
        $events->listen(
            ResizeableImageDeleted::class,
            self::class .'@onDelete'
        );

        $events->listen(
            ResizeableImageCreated::class,
            self::class .'@onCreate'
        );
    }
}
/*
@TODO:
need to decide where to put the path information
    config should work to remove hardcoded paths throughout models and resizer
 */
