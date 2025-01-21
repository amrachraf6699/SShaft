<?php

namespace App\Jobs;

use App\Donor;
use App\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetDonorsJob implements ShouldQueue
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
        // if(isset($this->invoicesData) && isset($this->usersData)) {
        //     foreach($this->invoicesData as $invoice) {
        //         $donation = Donation::where('id', '=', $invoice['id'])->first();
        //         if ($donation === null) {
    
        //             foreach($this->usersData as $user) {
        //                 if ($user['id'] == $invoice['uid']) {
        //                     $donorPhone = Donor::where('phone', '=', $user['mobile'])->first();
        //                     if ($donorPhone === null) {
        //                         Donor::create([
        //                             'id'        => $user['id'],
        //                             'phone'     => $user['mobile'],
        //                             'name'      => $user['name'],
        //                             'email'     => $user['email'],
        //                             'gender'    => $user['sex'],
        //                         ]);
        //                     }
        //                 }
        //             }
                    
        //         }
        //     }
        // }

        if(isset($this->data)) {
            foreach($this->data as $d) {
                if ($d['membershipId'] == 3 && $d['mobile'] != "") {
                    $donorPhone = Donor::where('phone', '=', $d['mobile'])->first();
                    if ($donorPhone === null) {
                        Donor::create([
                            'id'        => $d['id'],
                            'phone'     => $d['mobile'],
                            'name'      => $d['username'],
                            'email'     => Donor::where('email', '=', $d['email'])->exists() ? null : $d['email'],
                            'gender'    => $d['sex'],
                        ]);
                    }
                }
            }
        }
    }
}
