<?php namespace Modules\News\Entities;

use Eloquent as Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Article extends Model implements Presentable
{

    use PresentableTrait;

    public $table = 'news_articles';
    
    public $fillable = [
      'title',
      'text',
      'source_id',
      'source_link',
      'image',
      'publication_date',
      'tags',
      'verified',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'text' => 'text',
        'source_id' => 'integer',
        'source_link' => 'string',
        'image' => 'string',
        'verified' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function sources()
    {
        return $this->belongsTo('Modules\News\Entities\Source', 'source_id');
    }

    public function popular()
    {
        return $this->hasOne('Modules\News\Entities\ArticlePopular', 'article_id');
    }

    public function users()
    {
        return $this->belongsToMany('Modules\Auth\Entities\User', 'auth_users_news_articles_favorites');
    }

    public function scopeActive($query)
    {
        return $query->where('verified', true);
    }
}
