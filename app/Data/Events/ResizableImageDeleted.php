<?php

namespace Flashtag\Data\Events;

use Illuminate\Queue\SerializesModels;
use Flashtag\Data\Interfaces\HasResizableImages;

class ResizableImageDeleted extends Event
{
    use SerializesModels;

    public $entity;

    public $file;

    public $type;

    public function __construct(HasResizableImages $entity, $file, $type = 'image')
    {
        $this->entity = $entity;
        $this->file = $file;
        $this->type = $type;
    }
}
