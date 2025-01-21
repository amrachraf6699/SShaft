<?php

namespace App\Jobs;

use App\Donor;
use Illuminate\Bus\Queueable;
use App\GeneralAssemblyMember;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\SendNotificationEmailsToUsers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailsToUsers​ implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $donors                     = Donor::query()->select('id', 'email', 'name', 'username', 'receive_emails')->active()->receiveEmails()->get();
        $general_assembly_members   = GeneralAssemblyMember::query()->select('id', 'email', 'first_name', 'last_name', 'username', 'receive_emails')->active()->receiveEmails()->get();
        $members                    = $donors->merge($general_assembly_members);

        foreach($members as $member) {
            Mail::to($member->email)->send(new SendNotificationEmailsToUsers($this->data, $member));
            sleep(10);
        }
    }
}
