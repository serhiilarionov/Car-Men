<?php namespace Modules\Auth\Entities;

use Eloquent as Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model implements Presentable
{

    use PresentableTrait;

    public $table = 'auth_device';

    public $fillable = [
        'user_id',
        'device_id',
        'push_token',
        'device_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'device_id' => 'string',
        'push_token' => 'string',
        'device_type' => 'string'
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
    public function authUser()
    {
        return $this->belongsTo('\Modules\Auth\Entities\User');
    }
}
