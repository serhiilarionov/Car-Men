<?php

namespace Modules\News\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Modules\News\Entities\Article;
use Modules\Auth\Entities\User;
use InfyOm\Generator\Common\BaseRepository;
use Modules\News\Entities\ArticlePopular;
use Modules\News\Transformers\ArticleTransformer;

class ArticleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
      'title',
      'text',
      'source_id',
      'source_link',
      'image',
      'publication_date',
      //'tags',
      'verified',
    ];

    protected $skipPresenter = true;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Article::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\News\\Presenters\\ArticlePresenter";
    }

    public function active($id)
    {
        $article = Article::where('id', $id)->active()->first();
        if (empty($article)){
            return [];
        }
        return $this->parserResult($article);
    }
    
}
