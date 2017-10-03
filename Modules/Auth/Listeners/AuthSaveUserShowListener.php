<?php

namespace Modules\Auth\Listeners;

use App\Events\AbstractShowEvent;
use Carbon\Carbon;
use Modules\Auth\Entities\AuthUserShowLog;

class AuthSaveUserShowListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Handle the event.
     *
     * @param  AbstractShowEvent $event
     * @return void
     */
    public function handle(AbstractShowEvent $event)
    {
        $user = auth()->user();

        if (is_object($user)) {
            $userId = $user->id;
        } else {
            $userId = null;
        }
        
        $entity = $event->getEntity();
        
        $entityClass = get_class($entity);
        
        $authUserShowLog = new AuthUserShowLog();
        $authUserShowLog->entity = $entityClass;
        $authUserShowLog->entity_id = $entity->id;
        $authUserShowLog->created_at = Carbon::now();
        $authUserShowLog->user_id = $userId;
        $authUserShowLog->save();
    }
}
