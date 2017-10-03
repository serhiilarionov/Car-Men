<?php namespace Modules\Auth\Tests\Traits;

use Faker\Factory as Faker;
use Modules\Auth\Entities\PushLog;
use Modules\Auth\Repositories\PushLogRepository;

trait MakePushLogTrait
{
    /**
     * Create fake instance of PushLog and save it in database
     *
     * @param array $pushLogFields
     * @return PushLog
     */
    public function makePushLog($pushLogFields = [])
    {
        /** @var PushLogRepository $pushLogRepo */
        $pushLogRepo = \App::make(PushLogRepository::class);
        $theme = $this->fakePushLogData($pushLogFields);
        return $pushLogRepo->create($theme);
    }

    /**
     * Get fake instance of PushLog
     *
     * @param array $pushLogFields
     * @return PushLog
     */
    public function fakePushLog($pushLogFields = [])
    {
        return new PushLog($this->fakePushLogData($pushLogFields));
    }

    /**
     * Get fake data of PushLog
     *
     * @param array $pushLogFields
     * @return array
     */
    public function fakePushLogData($pushLogFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'push_name' => $fake->word,
            'message_id' => $fake->word,
            'device_id' => \Modules\Auth\Entities\Device::first()->device_id,//$fake->word,
            'send_status' => $fake->word,
            'read_status' => $fake->word,
           //'created_at' => $fake->date('Y-m-d H:i:s'),
           // 'updated_at' => $fake->date('Y-m-d H:i:s')
        ], $pushLogFields);
    }
}
