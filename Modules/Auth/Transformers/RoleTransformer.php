<?php

namespace Modules\Auth\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Auth\Entities\Role;

/**
 * Class RoleTransformer
 * @package namespace Modules\Auth\Transformers;
 */
class RoleTransformer extends TransformerAbstract
{
	
	/**
	 * Transform the Role entity
	 * @param Role $model
	 *
	 * @return array
	 */
	public function transform(Role $model)
	{
		return [
			'id' => (int)$model->id,
			'name' => $model->name,
			'display_name' => $model->display_name,
            'description' => $model->description,
		];
	}
}
