<?php namespace Modules\Catalog\Entities;

use Eloquent as Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class CompanyDetail extends Model implements Presentable
{
    use PresentableTrait;

    public $table = 'catalog_company_detail';

    public $primaryKey = 'company_id';

    public $fillable = [
        'phones',
        'email',
        'website',
        'work_time',
        'desc',
        'company_id',
        'payment'
    ];

    public $timestamps = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'phones' => 'string',
        'email' => 'string',
        'website' => 'string',
        'work_time' => 'string',
        'desc' => 'string',
        'company_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * Accessors and mutators
     */
    public function getPhonesAttribute($value)
    {

        return json_decode($value);
    }

    public function setPhonesAttribute($value)
    {

        $this->attributes['phones'] = json_encode($value);
    }

    public function getWorkTimeAttribute($value)
    {

        return json_decode($value);
    }

    public function setWorkTimeAttribute($value)
    {

        $this->attributes['work_time'] = json_encode($value);
    }
    
    public function getEmailAttribute($value)
    {
        return json_decode($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = json_encode($value);
    }

    public function getWebsiteAttribute($value)
    {
        return json_decode($value);
    }

    public function setWebsiteAttribute($value)
    {
        $this->attributes['website'] = json_encode($value);
    }

    public function getPaymentAttribute($value)
    {
        return json_decode($value);
    }

    public function setPaymentAttribute($value)
    {
        $this->attributes['payment'] = json_encode($value);
    }

}
