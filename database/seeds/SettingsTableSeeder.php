<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'name'              =>  "جمعية البر بجدة",
            'address'           =>  "طريق الملك فهد،، العليا، الرياض 11321",
            'link_map_address'  =>  '
                <iframe class="revealOnScroll zoomIn img-responsive center-block" data-animation="zoomIn" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14838.82258740178!2d39.1317162!3d21.59741!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xe58e5116516e7c90!2z2KzZhdi52YrYqSDYp9mE2KjYsSDYqNis2K_YqSDYp9mE2YLYs9mFINin2YTYsdis2KfZhNmK!5e0!3m2!1sar!2seg!4v1555512028563!5m2!1sar!2seg" width="100%" height="450" frameborder="0" style="border:0;width: 100%;height: 300px;" allowfullscreen></iframe>
            ',
            'description'       =>  "هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولده",
            'keywords'          =>  "هذا|النص|هو|مثال|لنص|يمكن|أن|يستبدل|في|نفس|المساحة،|لقد|تم|توليد|هذا|النص|من|مولد|النص|العربى،|حيث|يمكنك|أن|تولد|مثل|هذا|النص|أو|العديد|من|النصوص|الأخرى|إضافة|إلى|زيادة|عدد|الحروف|التى|يولده",
            'email'             =>  "support@albir.com",
            'phone'             =>  "966500000000",
        ]);
    }
}
