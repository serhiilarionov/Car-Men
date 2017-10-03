<?php namespace Modules\Catalog\Entities;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Phaza\LaravelPostgis\Geometries\Point;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model implements Presentable
{
    use SoftDeletes;

    use PresentableTrait;

    public $table = 'catalog_company';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'city_id',
        'address',
        'point',
        'short_desc',
        'picture',
        'rating',
        'price_rel'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'city_id' => 'integer',
        'address' => 'string',
        'point' => 'string',
        'short_desc' => 'string',
        'picture' => 'string',
        'rating' => 'float',
        'price_rel' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'city_id' => 'required',
        'categories' => 'required'
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
     * @param $value
     * @return mixed
     */
    public function getPictureAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * @param $value
     */
    public function setPictureAttribute($value)
    {
        $this->attributes['picture'] = json_encode($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function city()
    {
        return $this->belongsTo('Modules\Catalog\Entities\City', 'catalog_city');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('Modules\Catalog\Entities\Category', 'catalog_category_catalog_company');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comforts()
    {
        return $this->belongsToMany('Modules\Catalog\Entities\Comfort', 'catalog_comfort_catalog_company');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detail()
    {
        return $this->hasOne('Modules\Catalog\Entities\CompanyDetail', 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services()
    {
        return $this->belongsToMany('Modules\Catalog\Entities\Service', 'catalog_company_catalog_service');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany('Modules\Catalog\Entities\CompanyRating');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratingByUser()
    {
        $user = \Auth::user();
        return $this->hasMany('Modules\Catalog\Entities\CompanyRating')->where('user_id', "=", $user['id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('Modules\Auth\Entities\User', 'auth_users_catalog_company');
    }

    public function categoryServices($services, $categoryId)
    {
        $servicesIds = $services->pluck('id')->toArray();
        
        $services = Service::whereIn('id', $servicesIds)->where('category_id', $categoryId)->get();
        
        return $services;
    }

}
