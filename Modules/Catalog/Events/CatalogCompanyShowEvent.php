<?php

namespace Modules\Catalog\Events;

use App\Events\AbstractShowEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class CatalogCompanyShowEvent extends AbstractShowEvent
{
    use InteractsWithSockets, SerializesModels;
    
    /**
     * Create a new event instance.
     *
     * @param Model $entity
     */
    public function __construct(Model $entity)
    {
        $this->entity = $entity;
    }
}
