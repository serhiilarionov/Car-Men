<?php

namespace Modules\Auth\Transformers;

use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use Modules\Auth\Entities\User;

/**
 * Class UserTransformer
 * @package namespace Modules\Auth\Transformers;
 */
class UserTransformer extends TransformerAbstract
{

	/**
	 * List of resources possible to include
	 *
	 * @var array
	 */
	protected $availableIncludes = [
		'roles',
	];
	
	/**
	 * Transform the \User entity
	 * @param User $model
	 *
	 * @return array
	 */
	public function transform(User $model)
	{
		return [
			'id' => (int)$model->id,
			'name' => $model->name,
			'email' => $model->email,
		];
	}

	/**
	 * Include Roles
	 * @param User $model
	 *
	 * @return Collection
	 */
	public function includeRoles(User $model)
	{
		$roles = $model->roles;

		return $this->collection($roles, new RoleTransformer);
	}

}
