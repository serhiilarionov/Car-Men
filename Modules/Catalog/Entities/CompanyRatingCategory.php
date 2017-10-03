<?php namespace Modules\Catalog\Entities;

use Eloquent as Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class CompanyRatingCategory extends Model implements Presentable
{
    use PresentableTrait;

    public $table = 'catalog_company_rating_category';

    public $fillable = [
        'company_rating_id',
        'category_id',
        'rating'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_rating_id' => 'integer',
        'category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
//        'company_rating_id' => 'required',
        'category_id' => 'required',
        'rating' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function companyRating()
    {
        return $this->belongsTo(\Modules\Catalog\Entities\CompanyRating::class);
    }
}
