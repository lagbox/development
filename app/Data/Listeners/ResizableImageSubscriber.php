<?php

namespace Flashtag\Data\Listeners;

use Flashtag\Data\Resizable;
use Flashtag\Data\Services\Resizer;

class ResizableImageSubscriber
{
    /**
     * \Flashtag\Data\Services\Resizer
     */
    protected $resizer;

    /**
     * @param  \Flashtag\Data\Services\Resizer $resizer
     * @return void
     */
    public function __construct(Resizer $resizer)
    {
        $this->resizer = $resizer;
    }

    public function onCreate(Resizable $model)
    {
        $this->resizer->doIt($model);
    }

    public function onDelete(Resizable $model)
    {
        $defaults = config('sites.images.storage');

        $storage = Storage::disk($defaults['disk']);

        $path = $defaults['path'];

        foreach (array_keys($this->resizer->sizes()) as $size) {
            $file = $model->{$size};

            $img = $path .'/'. $file;

            if ($storage->has($img)) {
                $storage->delete($img);
            }
        }
    }

    public function subscribe($events)
    {
        $events->listen(
            'eloquent.deleting: '. Resizable::class,
            self::class .'@onDelete'
        );

        $events->listen(
            'eloquent.created: '. Resizable::class,
            self::class .'@onCreate'
        );
    }
}
