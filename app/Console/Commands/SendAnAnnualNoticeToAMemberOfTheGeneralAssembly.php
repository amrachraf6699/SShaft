<?php

namespace App\Console\Commands;

use App\GeneralAssemblyMember;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendAnAnnualNoticeToAMemberOfTheGeneralAssemblyMail;

class SendAnAnnualNoticeToAMemberOfTheGeneralAssembly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generalAssemblyMember:sendAnAnnualNotice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending an annual notification to the general assembly member automatically';

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
     * @return int
     */
    public function handle()
    {
        $general_assembly_members   = GeneralAssemblyMember::query()->select('id', 'email', 'first_name', 'last_name', 'username', 'status')->get();
        foreach($general_assembly_members as $member) {
            Mail::to($member->email)->send(new SendAnAnnualNoticeToAMemberOfTheGeneralAssemblyMail($member));
            sleep(10);
            // return $member->update(['status' => 'active']);
        }
    }
}
