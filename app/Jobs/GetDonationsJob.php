<?php

namespace App\Jobs;

use App\Donor;
use App\Service;
use App\Donation;
use App\DonationService;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetDonationsJob implements ShouldQueue
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
        if(isset($this->data)) {
            foreach($this->data as $_data) {

                if ($_data['moyasarStatus'] === 'paid') {
                    $days                   = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28'];
                    $months                 = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10'];
                    // $years                  = ['2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021'];
                    $years                  = ['2019', '2020', '2021'];
                    $date                   = Arr::random($years) . "-" . Arr::random($months) . "-" . Arr::random($days) . " 01:01:01";

                    $donation = Donation::where('id', '=', $_data['id'])->first();
                    if ($donation === null) {
                        Donation::create([
                            'id'                    => $_data['id'],
                            'donor_id'              => Donor::where('id', '=', $_data['uid'])->exists() ? $_data['uid'] : null ,
                            'total_amount'          => $_data['serviceTotalCost'],
                            'donation_type'         => 'service',
                            'status'                => $_data['moyasarStatus'] === 'paid' ? $_data['moyasarStatus'] : 'unpaid',
                            'bank_transaction_id'   => $_data['paymentId'] ?? null,
                            'payment_brand'         => $_data['paymentWayCode'] === 'mdy' ? 'MDA' : null,
                            'payment_ways'          => $_data['paymentWayCode'] === 'creditcard' || 'mdy' ? 'credit_card' : 'bank_transfer',
                            'created_at'            => $date,
                            'updated_at'            => $date,
                        ]);

                        DonationService::create([
                            'service_id'   => Service::where('id', '=', $_data['serviceId'])->exists() ? $_data['serviceId'] : 49,
                            'donation_id'  => $_data['id'],
                            'quantity'     => 1,
                            'amount'       => $_data['serviceTotalCost'],
                            'created_at'   => $date,
                            'updated_at'   => $date,
                        ]);
                    }
                }

            }
        }

        // $t = '1633564161';
        // $d = Carbon::parse($t)->format('Y-m-d H:i:s');
        // return $d;
    }
}
