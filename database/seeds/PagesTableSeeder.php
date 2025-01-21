<?php

use App\Membership;
use App\Page;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::create(['key' => 'brief', 'value'  => '', ]);
        Page::create(['key' => 'board_of_directors', 'value'  => '', ]);
        Page::create(['key' => 'services_albir', 'value'  => '', ]);
        Page::create(['key' => 'organizational_chart', 'value'  => '', ]);
        Page::create(['key' => 'statistics', 'value'  => '', ]);

        Membership::create(['key' => 'general_assembly_members']);
        Membership::create(['key' => 'donor_membership']);
        Membership::create(['key' => 'volunteer_membership']);
        Membership::create(['key' => 'beneficiaries_membership']);
    }
}
