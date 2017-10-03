<?php namespace Modules\Auth\Entities;

use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission implements Presentable
{
    use PresentableTrait;
    
    public $fillable = [
        'name',
        'display_name',
        'description'
    ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'display_name' => 'string',
        'description' => 'string'
    ];
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function roles()
    {
        return $this->belongsToMany(\Modules\Auth\Entities\Role::class, 'auth_permission_auth_role');
    }
}
