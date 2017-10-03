<?php namespace Modules\Catalog\Entities;

use Eloquent as Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comfort extends Model implements Presentable
{
    use SoftDeletes;
    use PresentableTrait;
    
    public $table = 'catalog_comfort';
    
    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'name',
        'image'
    ];
    
    public $timestamps = false;
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'image' => 'string'
    ];
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany('Modules\Catalog\Entities\Company', 'catalog_comfort_catalog_company');
    }
}
