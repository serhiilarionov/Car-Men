<?php

namespace Modules\Auth\Repositories;

use Modules\Auth\Entities\PushLog;
use InfyOm\Generator\Common\BaseRepository;

class PushLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'push_name',
        'message_id',
        'device_id',
        'send_status',
        'read_status'
    ];

    protected $skipPresenter = true;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PushLog::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Auth\\Presenters\\PushLogPresenter";
    }

    public function updateByMessageId($data, $messageId)
    {
        $pushLog = PushLog::where('message_id', $messageId);
        $updatedPushLog = $pushLog->update($data);
        if (!empty($updatedPushLog)){
            return 'success';
        }
        return 'error';
    }

}
