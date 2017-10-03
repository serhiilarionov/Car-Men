<?php

namespace Modules\News\Events;

use App\Events\AbstractShowEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\InteractsWithSockets;



class NewsViewEvent extends AbstractShowEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * NewsView constructor.
     * @param Model $entity
     */
    public function __construct(Model $entity)
    {
        $this->entity = $entity;
    }
}
