<?php namespace Modules\Auth\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;

/**
 * Modules\Auth\Entities\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @method static \Illuminate\Database\Query\Builder|\Modules\Auth\Entities\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Auth\Entities\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Auth\Entities\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Auth\Entities\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Auth\Entities\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Auth\Entities\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Auth\Entities\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements Presentable, AuthenticatableUserContract
{
    use Notifiable, PresentableTrait, EntrustUserTrait;

    public $table = 'auth_users';
    
    public $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:auth_users,name',
        'email' => 'required|email|unique:auth_users,email',
        'password' => 'required'
    ];

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Eloquent model method
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'user' => [
                'id' => $this->id,
                'email' => $this->email,
             ]
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function roles()
    {
        return $this->belongsToMany('Modules\Auth\Entities\Role', 'auth_role_auth_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites()
    {
        return $this->belongsToMany('Modules\Catalog\Entities\Company', 'auth_users_catalog_company');
    }

    public function articles()
    {
        return $this->belongsToMany('Modules\News\Entities\Article', 'auth_users_news_articles_favorites');
    }
    
}
