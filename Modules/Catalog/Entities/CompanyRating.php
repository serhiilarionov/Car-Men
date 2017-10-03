<?php namespace Modules\Catalog\Entities;

use Eloquent as Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyRating extends Model implements Presentable
{
    use SoftDeletes, PresentableTrait;

    public $table = 'catalog_company_rating';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'answer_date'
    ];

    public $fillable = [
        'company_id',
        'user_id',
        'display_name',
        'title',
        'text',
        'total_rating',
        'price_rel',
        'answer_name',
        'answer_text',
        'answer_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'user_id' => 'string',
        'display_name' => 'string',
        'title' => 'string',
        'text' => 'string',
        'total_rating' => 'float',
        'answer_name' => 'string',
        'answer_text' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function company()
    {
        return $this->belongsTo(\Modules\Catalog\Entities\Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function companyRatingCategories()
    {
        return $this->hasMany(\Modules\Catalog\Entities\CompanyRatingCategory::class);
    }
}
