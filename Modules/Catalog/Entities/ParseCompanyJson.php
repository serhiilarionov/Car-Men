<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;

class ParseCompanyJson extends Model
{
    public $table = 'parse_company_json_data';

    protected $fillable = ['parse_status'];

    public $timestamps = false;

}
