<?php namespace Modules\Catalog\Entities;

use Eloquent as Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class City extends Model implements Presentable
{
    use PresentableTrait;
    
    public $table = 'catalog_city';
    
    public $fillable = [
        'name',
        'point',
        'bound',
        'active'
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
        'point' => 'string',
        'bound' => 'string'
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
     * Accessors and mutators
     * @param string $value
     * @return string
     */
    public function setPointAttribute($value)
    {
        $this->attributes['point'] = $value['lng'] . ' ' . $value['lat'];
    }

    /**
     * @param string $value
     * @return static
     */
    public function getPointAttribute($value)
    {
        list($lng, $lat) = explode(' ', trim($value));

        return [
          'lat' => $lat,
          'lng' => $lng
        ];
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function companies()
    {
        return $this->hasMany('Modules\Catalog\Entities\Company', 'city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('Modules\Catalog\Entities\Category', 'catalog_category_catalog_city', 'city_id', 'category_id')->withPivot('count');
    }

}
