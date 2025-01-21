<?php

namespace App\Console\Commands;

use App\Donation;
use App\Jobs\GetDonationsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GetDonations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:donations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get donations';

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
        $donations = Storage::disk('public_import')->get('/oldDataAlbir/invoices_paid.json');
        $donations = json_decode($donations, true);

        foreach(array_chunk($donations['data'], 500) as $data){
            dispatch(new GetDonationsJob($data));
        }
    }
}
