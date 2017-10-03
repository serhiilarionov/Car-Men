<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;

class AuthUserShowLog extends Model
{
    protected $fillable = [];
    
    public $timestamps = false;
    
    public $table = 'auth_user_show_log';
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'entity' => 'required',
        'entity_id' => 'required'
    ];

    public function company()
    {
        return $this->belongsTo('Modules\Catalog\Entities\Company', 'entity_id');
    }
}
