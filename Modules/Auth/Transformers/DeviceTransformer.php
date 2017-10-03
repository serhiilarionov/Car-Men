<?php

namespace Modules\Auth\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Auth\Entities\Device;

/**
 * Class DeviceTransformer
 * @package namespace Modules\Auth\Transformers;
 */
class DeviceTransformer extends TransformerAbstract
{

    /**
     * Transform the \Device entity
     * @param \Device $model
     *
     * @return array
     */
    public function transform(Device $model)
    {
        return [
            'id' => (int)$model->id,
            'device_id' => $model->device_id,
            'push_token' => $model->push_token,
            'user_id' => $model->user_id,
            'device_type' => $model->device_type
        ];
    }
}
