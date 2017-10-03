<?php namespace App\Events;


use Illuminate\Database\Eloquent\Model;

abstract class AbstractShowEvent
{
    /** @var  Model $entity */
    protected $entity;
    
    /**
     * Get entity
     *
     * @return Model
     */
    public function getEntity()
    {
        return $this->entity;
    }
}