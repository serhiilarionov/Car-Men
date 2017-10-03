<?php namespace Modules\Catalog\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Catalog\Entities\City;

/**
 * Class CityTransformer
 * @package namespace Modules\Catalog\Transformers;
 */
class CityTransformer extends TransformerAbstract
{
    /**
     * Transform the City entity
     * @param City $model
     *
     * @return array
     */
    public function transform(City $model)
    {
        return [
          'id' => (int)$model->id,
          'name' => $model->name,
          'point' => $model->point,
          'bound' => $model->bound,
          'active' => $model->active,
        ];
    }
}
