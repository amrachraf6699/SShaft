<?php

namespace App\Http\Controllers\Frontend;

use App\Blog;
use App\Page;
use App\User;
use App\Donor;
use App\Event;
use App\Photo;
use App\Review;
use App\Slider;
use App\Partner;
use App\Service;
use App\Setting;
use App\Donation;
use App\Beneficiary;
use App\ServiceSection;
use App\DonationService;
use App\Traits\SmsTrait;
use Illuminate\Http\Request;
use App\GeneralAssemblyMember;
use App\Http\Controllers\Controller;
use App\Notifications\NewDonationForAdminNotify;

class HomeController extends Controller
{
    use SmsTrait;
    /**
     * **
     * index page
     * **
     */
    public function index()
    {
        $section_id_on_the_home_page = setting()->section_id_on_the_home_page;
        // $s = 3;
        // session()->flash('sessionSuccessReview', 'تمت العملية بنجاح، جعله الله عملاً خالصاً في ميزان حسناتكم!');
        // session()->flash('sessionSuccessReviewServiceId', $s);
         // Sliders
        $sliders                    = Slider::query()->active()->get();
        // brief
        $brief                      = Page::where('key', 'brief')->first();
        
        // $quick_services             = Service::query()
        //                                 ->select(['id', 'title', 'slug', 'img', 'basic_service_value', 'quick_donation', 'status', 'number_of_accepted_services'])
        //                                 ->quick_donation()->active()->inRandomOrder()->limit(4)->get();
        
        if ($section_id_on_the_home_page && ServiceSection::whereId($section_id_on_the_home_page)->active()->exists()) {
            // quick services
            $quick_services             = Service::query()
                                            ->select(['id', 'service_section_id', 'title', 'slug', 'img', 'basic_service_value', 'quick_donation', 'status', 'number_of_accepted_services'])
                                            ->with('service_section:id,slug,title')
                                            ->whereHas('service_section', function($q) {
                                                $q->active();
                                            })->whereServiceSectionId($section_id_on_the_home_page)
                                            ->wherePriceValue('fixed')->active()->inRandomOrder()->limit(4)->get();
                                            // multiple value services
            $multiple_value_services    = Service::query()->with('service_section:id,title,slug,status')
                                            ->whereHas('service_section', function($q) {
                                                $q->active();
                                            })->whereServiceSectionId($section_id_on_the_home_page)
                                            ->quick_donation()->active()->inRandomOrder()->limit(6)->get();
        } else {
            // quick services
            $quick_services             = Service::query()
                                            ->select(['id', 'service_section_id', 'title', 'slug', 'img', 'basic_service_value', 'quick_donation', 'status', 'number_of_accepted_services'])
                                            ->with('service_section:id,slug,title')
                                            ->whereHas('service_section', function($q) {
                                                $q->active();
                                            })->wherePriceValue('fixed')->active()->inRandomOrder()->limit(4)->get();
            // multiple value services
            $multiple_value_services    = Service::query()->with('service_section:id,title,slug,status')
                                            ->whereHas('service_section', function($q) {
                                                $q->active();
                                            })->quick_donation()->active()->inRandomOrder()->limit(6)->get();
        }
        
        // beneficiaries
        $beneficiaries                  = Beneficiary::query()->with('service_section:id,title,slug,status')
                                                    ->whereHas('service_section', function($q) {
                                                        $q->active();
                                                    })->show()->active()->inRandomOrder()->limit(6)->get();

        // photos
        $photos                     = Photo::orderBy('id', 'DESC')->active()->with('photo_section:id,slug,title,status')
                                            ->whereHas('photo_section', function($q){
                                                $q->whereStatus('active');
                                            })->limit(25)->get();
        // events
        $events                     = Event::query()->active()->orderBy('id', 'DESC')->limit(4)->get();
        // news
        $news                       = Blog::orderBy('id', 'DESC')->with('blog_section:id,slug,title,status')
                                            ->whereHas('blog_section', function($q){
                                                $q->whereStatus('active');
                                            })->active()->with('blog_section')->limit(10)->get();
        // partners
        $partners                   = Partner::query()->active()->orderBy('id', 'DESC')->get();

       // PAYMENT PROVIDER
        if(request('id') && request('resourcePath')) {
            $res            = session()->get(request('session_name'));

            if (isset($res['serviceId'])) {
                $phone          = $res['phoneNumber'];
                $serviceId      = $res['serviceId'];
                $payment_status = $this->getPaymentStatus(request('id'), request('resourcePath'));
                // return $payment_status;
                $result_code    = $payment_status['result']['code'];

                if (($result_code == '000.100.110' || $result_code == '000.000.000' || $result_code == '000.300.000') && isset($payment_status['merchantTransactionId']) && !empty($payment_status['merchantTransactionId'])) { // success payment id >> transaction bank id
                    $showSuccessPaymentMessage = true;
                    // save transaction in donation table with transaction id  = $payment_status['id]
                    if (Donor::where('phone', '=', $phone)->exists()) {
                        $donor = Donor::where('phone', '=', $phone)->first();

                        $data = [
                            'donor_id'              => auth('donor')->user()->id ?? $donor->id,
                            'total_amount'          => $payment_status['amount'],
                            'bank_transaction_id'   => $payment_status['merchantTransactionId'],
                            'payment_brand'         => $payment_status['paymentBrand'],
                            'status'                => 'paid',
                            'payment_ways'          => 'credit_card',
                        ];

                        $donation = Donation::create($data);

                        $donation_service               = new DonationService();
                        $donation_service->service_id   = $serviceId;
                        $donation_service->donation_id  = $donation->id;
                        $donation_service->quantity     = $res['quantity'];
                        $donation_service->amount       = $donation->total_amount;
                        $donation_service->save();

                        // update "collected_value" in service
                        $services = $donation->services()->get();
                        foreach ($services as $service) {
                            $service->update([
                                'collected_value'  => $service->collected_value + $service->pivot->amount,
                            ]);
                        }

                        // Send sms
                        $route = route('donation-invoice.show', $donation->donation_code);
                        $review_link = route('frontend.reviews.index', $donation->donation_code);
                        $this->sendSms($donor->phone, __('messages.donation_completion_msg', ['invoice_link' => $route, 'review_link' => $review_link]));

                        User::each(function($admin, $key) use ($donation) {
                            $admin->notify(new NewDonationForAdminNotify($donation));
                        });

                        session()->flash('sessionSuccess', 'تمت العملية بنجاح، جعله الله عملاً خالصاً في ميزان حسناتكم!');
                        return redirect()->route('frontend.reviews.index', $donation->donation_code);
                    }

                    $donor              = new Donor();
                    $donor->phone       = $phone;
                    $donor->save();

                    $data = [
                        'donor_id'              => $donor->id,
                        'total_amount'          => $payment_status['amount'],
                        'bank_transaction_id'   => $payment_status['merchantTransactionId'],
                        'payment_brand'         => $payment_status['paymentBrand'],
                        'status'                => 'paid',
                        'payment_ways'          => 'credit_card',
                    ];

                    $donation = Donation::create($data);

                    $donation_service               = new DonationService();
                    $donation_service->service_id   = $serviceId;
                    $donation_service->donation_id  = $donation->id;
                    $donation_service->quantity     = $res['quantity'];
                    $donation_service->amount       = $donation->total_amount;
                    $donation_service->save();

                    // update "collected_value" in service
                    $services = $donation->services()->get();
                    foreach ($services as $service) {
                        $service->update([
                            'collected_value'  => $service->collected_value + $service->pivot->amount,
                        ]);
                    }

                    // Send sms
                    $route = route('donation-invoice.show', $donation->donation_code);
                    $review_link = route('frontend.reviews.index', $donation->donation_code);
                    $this->sendSms($donor->phone, __('messages.donation_completion_msg', ['invoice_link' => $route, 'review_link' => $review_link]));

                    User::each(function($admin, $key) use ($donation) {
                        $admin->notify(new NewDonationForAdminNotify($donation));
                    });

                    session()->flash('sessionSuccess', 'تمت العملية بنجاح، جعله الله عملاً خالصاً في ميزان حسناتكم!');
                    return redirect()->route('frontend.reviews.index', $donation->donation_code);

                } else {
                    $showFailPaymentMessage = true;
                    session()->flash('sessionError', 'فشلت عملية الدفع، الرجاء التحقق وإعادة المحاولة!');
                    return redirect()->route('frontend.home');
                }
            } else {
                $phone          = $res['phoneNumber'];
                $beneficiaryId  = $res['beneficiaryId'];
                $beneficiary    = Beneficiary::orderBy('id', 'DESC')->whereId($beneficiaryId)->show()->active()->with('service_section')->first();
                $payment_status = $this->getPaymentStatus(request('id'), request('resourcePath'));
                $result_code    = $payment_status['result']['code'];

                if (($result_code == '000.100.110' || $result_code == '000.000.000' || $result_code == '000.300.000') && isset($payment_status['merchantTransactionId']) && !empty($payment_status['merchantTransactionId'])) { // success payment id >> transaction bank id
                    $showSuccessPaymentMessage = true;
                    // save transaction in donation table with transaction id  = $payment_status['id]
                    if (Donor::where('phone', '=', $phone)->exists()) {
                        $donor = Donor::where('phone', '=', $phone)->first();

                        $data = [
                            'beneficiary_id'        => $beneficiary->id,
                            'donation_type'         => 'beneficiary',
                            'donor_id'              => auth('donor')->user()->id ?? $donor->id,
                            'total_amount'          => $payment_status['amount'],
                            'bank_transaction_id'   => $payment_status['merchantTransactionId'],
                            'payment_brand'         => $payment_status['paymentBrand'],
                            'status'                => 'paid',
                            'payment_ways'          => 'credit_card',
                        ];

                        $donation = Donation::create($data);

                        // update "collected_value" in beneficiary
                        $beneficiary->update([
                            'collected_value'  => $beneficiary->collected_value + $donation->total_amount,
                        ]);

                        // Send sms
                        $route = route('donation-invoice.show', $donation->donation_code);
                        $review_link = route('frontend.reviews.index', $donation->donation_code);
                        $this->sendSms($donor->phone, __('messages.donation_completion_msg', ['invoice_link' => $route, 'review_link' => $review_link]));

                        User::each(function($admin, $key) use ($donation) {
                            $admin->notify(new NewDonationForAdminNotify($donation));
                        });

                        session()->flash('sessionSuccess', 'تمت العملية بنجاح، جعله الله عملاً خالصاً في ميزان حسناتكم!');
                        return redirect()->route('frontend.reviews.index', $donation->donation_code);
                    }

                    $donor              = new Donor();
                    $donor->phone       = $phone;
                    $donor->save();

                    $data = [
                        'beneficiary_id'        => $beneficiary->id,
                        'donation_type'         => 'beneficiary',
                        'donor_id'              => $donor->id,
                        'total_amount'          => $payment_status['amount'],
                        'bank_transaction_id'   => $payment_status['merchantTransactionId'],
                        'payment_brand'         => $payment_status['paymentBrand'],
                        'status'                => 'paid',
                        'payment_ways'          => 'credit_card',
                    ];

                    $donation = Donation::create($data);

                    // update "collected_value" in service
                    $beneficiary->update([
                        'collected_value'  => $beneficiary->collected_value + $donation->total_amount,
                    ]);

                    // Send sms
                    $route = route('donation-invoice.show', $donation->donation_code);
                    $review_link = route('frontend.reviews.index', $donation->donation_code);
                    $this->sendSms($donor->phone, __('messages.donation_completion_msg', ['invoice_link' => $route, 'review_link' => $review_link]));

                    User::each(function($admin, $key) use ($donation) {
                        $admin->notify(new NewDonationForAdminNotify($donation));
                    });

                    session()->flash('sessionSuccess', 'تمت العملية بنجاح، جعله الله عملاً خالصاً في ميزان حسناتكم!');
                    return redirect()->route('frontend.reviews.index', $donation->donation_code);

                } else {
                    $showFailPaymentMessage = true;
                    session()->flash('sessionError', 'فشلت عملية الدفع، الرجاء التحقق وإعادة المحاولة!');
                    return redirect()->route('frontend.home');
                }
            }

        }

        return view('welcome');
        // return view('frontend.home', compact(
        //                                 'sliders', 'brief', 'quick_services', 'multiple_value_services',
        //                                 'photos', 'events', 'news', 'partners', 'beneficiaries'
        //                             ));
    }

    /**
     * **
     * quick-donation-slider
     * **
     */
    public function quickDonationSlider(Request $request)
    {
        $phone  = preg_replace("/^966/", "0", $request->phone);
        $data = $request->validate([
            'service_id'    => 'required|exists:services,id|integer',
            'total_amount'  => 'required|numeric|gt:0',
            'phone'         => ['required', 'regex:/^((9665)|(05))[0-9]{8}$/'],
            'payment_ways'  => 'required|in:bank_transfer,credit_card,VISA MASTER,MADA',
        ]);
        $data['payment_ways'] = $request->payment_ways === 'bank_transfer' ? 'bank_transfer' : 'credit_card';

        if (Donor::where('phone', '=', $phone)->exists()) {
            $donor = Donor::where('phone', '=', $phone)->first();

            $donation                   = new Donation();
            $donation->donor_id         = auth('donor')->user()->id ?? $donor->id;
            $donation->donation_type    = 'quick';
            $donation->payment_ways     = $data['payment_ways'];
            $donation->total_amount     = $data['total_amount'];
            $donation->save();

            $donation_service               = new DonationService();
            $donation_service->service_id   = $request->service_id;
            $donation_service->donation_id  = $donation->id;
            $donation_service->quantity     = 1;
            $donation_service->amount       = $donation->total_amount;
            $donation_service->save();

            if ($donation->payment_ways == 'bank_transfer') {
                return redirect()->route('frontend.donations.bank-transfer.view', $donation->donation_code);
            } elseif ($donation->payment_ways == 'credit_card')
                return redirect()->route('frontend.donations.credit-card.view', [$donation->donation_code, $request->payment_ways]);
            else {
                return redirect()->route('frontend.home');
            }
        }

        $donor              = new Donor();
        $donor->phone       = $phone;
        $donor->save();

        $donation                   = new Donation();
        $donation->donor_id         = $donor->id;
        $donation->donation_type    = 'quick';
        $donation->payment_ways     = $data['payment_ways'];
        $donation->total_amount     = $data['total_amount'];
        $donation->save();

        $donation_service               = new DonationService();
        $donation_service->service_id   = $request->service_id;
        $donation_service->donation_id  = $donation->id;
        $donation_service->quantity     = 1;
        $donation_service->amount       = $donation->total_amount;
        $donation_service->save();

        if ($donation->payment_ways == 'bank_transfer') {
            return redirect()->route('frontend.donations.bank-transfer.view', $donation->donation_code);
        } elseif ($donation->payment_ways == 'credit_card')
            return redirect()->route('frontend.donations.credit-card.view', [$donation->donation_code, $request->payment_ways]);
        else {
            return redirect()->route('frontend.home');
        }
    }

    /**
     * **
     * maintenance page
     * **
     */
    public function maintenance()
    {
        if (setting()->status === 'close')
        {
            $maintenance = Setting::select(['id', 'status', 'message_maintenance'])->orderBy('id', 'DESC')->first();
            return view('frontend.maintenance', compact( 'maintenance'));
        }
        return redirect()->back();
    }

    /**
     * **
     * Unsubscribe Newsletter
     * **
    */
    public function unsubscribeNewsletter($email, $username)
    {
        $donor                      = Donor::whereEmailAndUsername($email, $username)->first();
        $general_assembly_member    = GeneralAssemblyMember::whereEmailAndUsername($email, $username)->first();

        if($donor)
        {
            $donor->update(['receive_emails' => 'no']);
            return view('emails.unsubscribe');
        }
        elseif ($general_assembly_member)
        {
            $general_assembly_member->update(['receive_emails' => 'no']);
            return view('emails.unsubscribe');

        }
        return redirect()->route('frontend.home');
    }

    /**
     * **
     * Send Review
     * **
    */
    public function sendReview(Request $request, $donation_code)
    {
        $donation = Donation::whereDonationCode($donation_code)->first();
        if ($donation) {
            $request->validate([
                'your_rating'   =>  'required|numeric|in:1,2,3,4,5',
                'your_comment'  =>  'required|string|min:10',
            ], [], [
                'your_rating'   =>  trans('translation.rating'),
                'your_comment'  =>  trans('translation.review'),
            ]);

            $data['rating']         =  $request->your_rating;
            $data['review']         =  $request->your_comment;
            $data['donation_id']    =  $donation->id;

            Review::create($data);
            session()->flash('sessionSuccess', 'تم التقييم بنجاح، شكراً لدعمكم!');
            return redirect()->route('frontend.home');
        }
        return abort(404);
    }

    public function viewReview($donation_code)
    {
        $donation = Donation::whereDonationCode($donation_code)->first();
        if ($donation) {
            return view('frontend.pages.reviews', compact('donation'));
        }
        return abort(404);
    }


    // getPaymentStatus
    private function getPaymentStatus($id, $resourcePath)
    {
        $res  = session()->get(request('session_name'));
        if ($res['payment_brand'] == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($res['payment_brand'] == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url = config('payment_information.hyperpay.get_status_link');
        $url .= $resourcePath;
        $url .= "?entityId=" . $entity_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        config('payment_information.hyperpay.authorization')));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }
}
