<?php

namespace Modules\Auth\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Auth\Entities\Permission;

/**
 * Class PermissionTransformer
 * @package namespace Modules\Auth\Transformers;
 */
class PermissionTransformer extends TransformerAbstract
{
	
	/**
	 * Transform the Permission entity
	 * @param Permission $model
	 *
	 * @return array
	 */
	public function transform(Permission $model)
	{
		return [
			'id' => (int)$model->id,
			'name' => $model->name,
			'display_name' => $model->display_name,
            'description' => $model->description,
		];
	}
}
