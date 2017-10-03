<?php namespace Modules\Auth\Entities;

use Eloquent as Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class PushLog extends Model implements Presentable
{
    use PresentableTrait;

    public $table = 'auth_push_notification_log';
    
    public $fillable = [
        'push_name',
        'message_id',
        'device_id',
        'send_status',
        'read_status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'push_name' => 'string',
        'message_id' => 'string',
        'device_id' => 'string',
        'send_status' => 'string',
        'read_status' => 'string',
        'created_at' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
