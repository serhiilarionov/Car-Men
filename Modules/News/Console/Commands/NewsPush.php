<?php

namespace Modules\News\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use FCM;
use Modules\Auth\Entities\Device;
use Modules\Auth\Entities\PushLog;

class NewsPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsPush:popular';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // period popular articles for news (days)
        $period = 7;
        $pushName = 'Popular news';
        
        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(60*20);
        $optionBuiler->setPriority('high');
        
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['days' => $period]);
        $dataBuilder->addData(['title' => 'title']);
        $dataBuilder->addData(['text' => 'text']);

        $option = $optionBuiler->build();


        $tokens = Device::pluck('push_token')->toArray();

        foreach ($tokens as $token){
            $messageId = hash('md5', Carbon::now() . $pushName);
            $dataBuilder->addData(['messageId' => $messageId]);
            $data = $dataBuilder->build();
            $downstreamResponse = FCM::sendTo($token, $option, null, $data);
            $success = $downstreamResponse->numberSuccess();
            if ($success){
                $pushLog = new PushLog();
                $pushLog->push_name = $pushName;
                $pushLog->message_id = $messageId;
                $deviceId = Device::where('push_token', $token)->pluck('device_id')->first();
                $pushLog->device_id = $deviceId;
                $pushLog->send_status = 'sent';
                $pushLog->read_status = 'wait';
                $pushLog->created_at = Carbon::now();
                $pushLog->save();
            }
        }
    }
}
