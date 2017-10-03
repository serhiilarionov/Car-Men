<?php namespace Modules\Catalog\Entities;

use Eloquent as Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Category extends Model implements Presentable
{
    use PresentableTrait;
    
    public $table = 'catalog_category';
    
    public $timestamps = false;
    
    public $fillable = [
        'name',
        'active',
        'parent_id'
    ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'parent_id' => 'integer'
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
     * Scope a query to only include main categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }
    
    
    /**
     * Parent relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function children()
    {
        return $this->hasMany('Modules\Catalog\Entities\Category', 'parent_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany('Modules\Catalog\Entities\Company', 'catalog_category_catalog_company');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany('Modules\Catalog\Entities\Service');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cities()
    {
        return $this->belongsToMany('Modules\Catalog\Entities\City', 'catalog_category_catalog_city', 'category_id', 'city_id')->withPivot('count');
    }

}
