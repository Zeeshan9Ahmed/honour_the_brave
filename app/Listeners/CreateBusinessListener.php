<?php

namespace App\Listeners;

use App\Events\CreateBusinessEvent;
use App\Models\User;
use App\Services\Notifications\CreateDBNotification;
use App\Services\Notifications\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateBusinessListener
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
     * @param  \App\Events\CreateBusinessEvent  $event
     * @return void
     */
    public function handle(CreateBusinessEvent $event)
    {
        $users = User::whereNotNull('device_token')->where(['notification_toggle' => true])->whereIn('role',['fire_fighters','armed_forces'])->get(['id','device_token']);
        if ($users->count() > 0){
            $data = '';
            foreach($users as $user){
                $data = [
                    'to_user_id'        =>  $user->id,
                    'from_user_id'      =>  auth()->id(),
                    'notification_type' =>  "NEW_BUSINESS",
                    
                    'title' =>   $event->message,
                ];
                $data['redirection_id'] =  auth()->id() ;
                $data['description'] =  $event->message;
                $save_notification = app(CreateDBNotification::class)->execute($data);
            }
            $tokens = $users->pluck('device_token')->toArray();
            $send_push = app(PushNotificationService::class)->execute($data,$tokens);
        }   
    }
}
