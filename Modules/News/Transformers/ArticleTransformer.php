<?php

namespace Modules\News\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\News\Entities\Article;

/**
 * Class ArticlesTransformer
 * @package namespace Modules\News\Transformers;
 */
class ArticleTransformer extends TransformerAbstract
{

    protected static $articles = null;

    /**
     * Transform the Article entity
     * @param Article $model
     *
     * @return array
     */
    public function transform(Article $model)
    {
        $result = [
            'id' => (int)$model->id,
            'title' => $model->title,
            'text' => $model->text,
            'source_name' => $model->sources->name,
            'source_link' => $model->source_link,
            'image' => $model->image,
            'is_favorite' => false,
            'publication_date' => $model->publication_date,
            'views' => 0
        ];

        $views = $model->popular;
        if (!empty($views)){
            $result['views'] = $views->total;
        }

        if (!\Auth::check()) {
            return $result;
        }

        //get user favorite articles
        if (!self::$articles) {
            $user = \Auth::user();
            self::$articles = array_flip($user->articles->pluck('id')->toArray());
        }

        //add flag for favorite articles
        if (self::$articles && isset(self::$articles[$model->id])) {
            $result['is_favorite'] = true;
        }

        return $result;

    }
}
