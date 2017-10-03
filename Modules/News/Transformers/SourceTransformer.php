<?php

namespace Modules\News\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\News\Entities\Source;

/**
 * Class ArticlesTransformer
 * @package namespace Modules\News\Transformers;
 */
class SourceTransformer extends TransformerAbstract
{

    protected static $sources = null;

    /**
     * Transform the Article entity
     * @param Source $model
     *
     * @return array
     */
    public function transform(Source $model)
    {
        $result = [
            'id' => (int)$model->id,
            'name' => $model->name
        ];

        return $result;

    }
}
