<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\GeneralAssemblyMemberPaymentConfirm;
use App\Mail\NotifyGeneralAssemblyMemberPaymentConfirmMail;

class NotifyGeneralAssemblyMemberPaymentConfirm
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
     * @param  GeneralAssemblyMemberPaymentConfirm  $event
     * @return void
     */
    public function handle(GeneralAssemblyMemberPaymentConfirm $event)
    {
        // Mail::to($event->invoice['member_email'])->send(new NotifyGeneralAssemblyMemberPaymentConfirmMail($event->invoice));
        
        $data = $event->invoice;
        $data['message'] = "تم إنشاء الفاتورة!";

        $setting = setting();
        
        Mail::send('emails.notify-general-assembly-members-payment-confirm', ['data' => $data, 'setting' => $setting], function($message) use ($data, $setting) {

            $message->to($data['member_email']);

            $message->subject($setting->name);

        });
    }
}
