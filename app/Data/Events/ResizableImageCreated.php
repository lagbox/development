<?php

namespace Flashtag\Data\Events;

use Illuminate\Queue\SerializesModels;
use Flashtag\Data\Interfaces\HasResizableImages;

class ResizableImageCreated extends Event
{
    use SerializesModels;

    public $entity;

    public $type;

    public function __construct(HasResizableImages $entity, $type = 'image')
    {
        $this->entity = $entity;
        $this->type = $type;
    }
}
