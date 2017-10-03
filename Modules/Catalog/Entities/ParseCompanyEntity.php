<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;

class ParseCompanyEntity extends Model
{
    public $table = 'parse_company';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'rating',
        'city_id',
        'address',
        'phone',
        'website',
        'fuel',
        'description',
        'services',
        'data_url',
        'image',
        'logo',
        'washing_type',
        'location_description',
        'car_brand',
        'category_id',
        'work_hour',
        'status',
    ];
    
}
