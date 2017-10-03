<?php namespace Modules\News\Entities;

use Eloquent as Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class ArticlePopular extends Model implements Presentable
{

    use PresentableTrait;

    public $table = 'news_articles_popular';
    public $timestamps = false;
    
    public $fillable = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function article(){
        return $this->hasOne('Modules\News\Entities\Article', 'id');
    }

}
