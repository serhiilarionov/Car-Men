<?php

namespace Modules\Catalog\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Catalog\Entities\Service;

/**
 * Class ServiceTransformer
 * @package namespace Modules\Catalog\Transformers;
 */
class ServiceTransformer extends TransformerAbstract
{
    
    /**
     * Transform the \Service entity
     * @param \Service $model
     *
     * @return array
     */
    public function transform(Service $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'category_id' => $model->category_id,
        ];
    }
}
