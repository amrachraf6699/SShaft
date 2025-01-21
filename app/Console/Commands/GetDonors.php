<?php

namespace App\Console\Commands;

use App\Donor;
use App\Jobs\GetDonorsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GetDonors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:donors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get donors';

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
        $users = Storage::disk('public_import')->get('/oldDataAlbir/users.json');
        $users = json_decode($users, true);

        foreach(array_chunk($users['data'], 500) as $data){
            dispatch(new GetDonorsJob($data));
        }

        // $invoices = Storage::disk('public_import')->get('/oldDataAlbir/invoices_paid.json');
        // $invoices = json_decode($invoices, true);

        // foreach(array_chunk($invoices['data'], 500) as $invoicesData){
        //     dispatch(new GetDonorsJob($invoicesData));
        // }
        

        // $donors = Storage::disk('public_import')->get('/oldDataAlbir/users_donors__num1.json');
        // $donors = json_decode($donors, true);

        // foreach(array_chunk($donors['data'], 500) as $data){
        //     dispatch(new GetDonorsJob($data));
        // }

        // if(isset($donors['data'])) {
        // }

        // if(isset($donors)) {
        //     foreach($donors['data'] as $d) {
        //         if ($d['mobile'] != "") {
        //             $donorPhone = Donor::where('phone', '=', $d['mobile'])->first();
        //             // $donorEmail = Donor::where('email', '=', $d['email'])->first();
        //             if ($donorPhone === null) {
        //                 Donor::create([
        //                     // 'id'        => $d['id'],
        //                     'phone'     => $d['mobile'] ? $d['mobile'] : $d['id'],
        //                     'name'      => $d['name'],
        //                     'email'     => $d['email'] ? $d['email'] : $d['id'],
        //                     'gender'    => $d['sex'],
        //                 ]);
        //             }
        //         }
        //     }
        //     return 'Success';
        // }
        // return 'Fail';
    }
}
