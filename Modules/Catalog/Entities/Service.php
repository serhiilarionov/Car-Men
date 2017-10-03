<?php namespace Modules\Catalog\Entities;

use Eloquent as Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;


class Service extends Model implements Presentable
{
    
    use PresentableTrait;
    
    public $table = 'catalog_service';
    
    public $timestamps = false;
    
    public $fillable = [
        'name'
    ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    
    ];
    
    
}
