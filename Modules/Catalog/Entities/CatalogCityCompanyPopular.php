<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;

class CatalogCityCompanyPopular extends Model
{
    protected $fillable = [];
    public $timestamps = false;
    public $table = 'catalog_city_company_popular';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('Modules\Catalog\Entities\Company', 'company_id');
    }

}
