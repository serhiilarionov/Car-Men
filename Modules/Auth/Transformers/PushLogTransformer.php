<?php

namespace Modules\Auth\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Auth\Entities\PushLog;

/**
 * Class PushLogTransformer
 * @package namespace Modules\Auth\Transformers;
 */
class PushLogTransformer extends TransformerAbstract
{

    /**
     * Transform the \PushLog entity
     * @param \PushLog $model
     *
     * @return array
     */
    public function transform(PushLog $model)
    {
        return [
            'id'         => (int) $model->id,
            'push_name' => $model->push_name,
            'message_id' => $model->message_id,
            'device_id' => $model->device_id,
            'send_status' => $model->send_status,
            'read_status' => $model->read_status,
            'created_at' => $model->created_at,
        ];
    }
}
