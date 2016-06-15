<?php

namespace Flashtag\Data\Listeners;

use Flashtag\Data\Resizable;
use Flashtag\Data\Services\Resizer;

class ResizableImageSubscriber
{
    protected $resizer;

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
        foreach (array_keys(Resizer::sizes()) as $size) {
            $file = $model->{$size};

            $config = config('sites.uploads.images');

            if ($config['default'] == 'path') {
                //
            } else {
                $storage = Storage::disk($config['storage']['disk']);
                //
            }
            // if file exists
            //    delete file
        }
    }

    public function subscribe($events)
    {
        $events->listen(
            'eloquent.deleting: Resizable',
            self::class .'@onDelete'
        );

        $events->listen(
            'eloquent.created: Resizable',
            self::class .'@onCreate'
        );
    }
}
/*
@TODO:
need to decide where to put the path information
    config should work to remove hardcoded paths throughout models and resizer
 */
