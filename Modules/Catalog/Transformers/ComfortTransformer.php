<?php namespace Modules\Catalog\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Catalog\Entities\Comfort;
use League\Fractal\Resource\Collection;

/**
 * Class ComfortTransformer
 * @package namespace Modules\Catalog\Transformers;
 */
class ComfortTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
      'companies',
    ];

    /**
     * Transform the Comfort entity
     * @param Comfort $model
     *
     * @return array
     */
    public function transform(Comfort $model)
    {
        return [
          'id' => (int)$model->id,
          'name' => $model->name,
          'image' => $model->image
        ];
    }

    /**
     * Include Companies
     * @param Comfort $model
     *
     * @return Collection
     */
    public function includeCompanies(Comfort $model)
    {
        $companies = $model->companies;

        return $this->collection($companies, new CompanyTransformer);
    }
}
