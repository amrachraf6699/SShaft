<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use App\Mail\GeneralAssemblyMemberMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\GeneralAssemblyMemberCreated;

class NotifyGeneralAssemblyMemberCreated
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
     * @param  GeneralAssemblyMemberCreated  $event
     * @return void
     */
    public function handle(GeneralAssemblyMemberCreated $event)
    {
        // Mail::to($event->member['email'])->send(new GeneralAssemblyMemberMail($event->member));
        
        $data = $event->member;
        $data['message'] = "تم إنشاء حسابك بنجاح!";

        $setting = setting();
        
        Mail::send('emails.message-members', ['data' => $data, 'setting' => $setting], function($message) use ($data, $setting) {

            $message->to($data['email']);

            $message->subject($setting->name);

        });
    }
}
