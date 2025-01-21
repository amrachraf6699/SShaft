<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\Donor;
use App\Donation;
use App\Beneficiary;
use App\Neighborhood;
use App\ServiceSection;
use App\Traits\SmsTrait;
use App\BeneficiaryFamily;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Notifications\NewDonationForAdminNotify;
use App\Http\Requests\Frontend\BeneficiaryRequest;

class BeneficiaryController extends Controller
{
    use SmsTrait;
    
    public function index()
    {
        $pageTitle          =   __('translation.beneficiaries_requests');
        $verification_code  =   mt_rand(1010, 10000);
        $neighborhoods      = Neighborhood::orderBy('id', 'DESC')->active()->pluck('name', 'id');
        return view('frontend.beneficiaries-requests.index', compact('pageTitle', 'verification_code', 'neighborhoods'));
    }

    public function store(BeneficiaryRequest $request)
    {
        $request->validated();
        $data = $request->except('verification_code', 'code');

        // ident_img
        $ident_img  = $request->file('ident_img');
        $filename   = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $ident_img->getClientOriginalExtension();
        $path       = storage_path('app/public/uploads/beneficiaries_requests/' . $filename);
        Image::make($ident_img->getRealPath())->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);
        $data['ident_img'] = $filename;

        Beneficiary::create($data);
        session()->flash('sessionSuccess', 'تم إرسال طلبك بنجاح، وسيتم التواصل معكم في أقرب وقت ممكن!');
        return redirect()->back();
    }
    
    /**************************************************** */
    // viewBeneficiaries
    public function viewBeneficiaries($slug)
    {
        $section    = ServiceSection::select(['id', 'slug', 'title', 'status'])->whereSlug($slug)->first();
        if($section && $section->status == 'active') {
            $pageTitle      = __('translation.beneficiaries_requests') . ' » ' . $section->title;
            $beneficiaries  = Beneficiary::query()
                                ->with('service_section:id,slug,title')
                                ->whereServiceSectionId($section->id)->orderBy('id', 'DESC')
                                ->active()->show()->paginate(6);

            // PAYMENT PROVIDER
            if(request('id') && request('resourcePath')) {
                $res            = session()->get(request('session_name'));
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
                    return redirect()->route('frontend.beneficiaries-requests.section.show', $section->slug);
                }
            }
            return view('frontend.beneficiaries-requests.beneficiaries', compact('section', 'beneficiaries', 'pageTitle'));
        }
        return redirect()->back();
    }

    // viewBeneficiariesDetails
    public function viewBeneficiariesDetails($section_slug, $slug)
    {
        $beneficiary    = Beneficiary::orderBy('id', 'DESC')->whereSlug($slug)->show()->active()->with('service_section')->first();
        if($beneficiary && $beneficiary->service_section->status == 'active') {
            // PAYMENT PROVIDER
            if(request('id') && request('resourcePath')) {
                $res            = session()->get(request('session_name'));
                $phone          = $res['phoneNumber'];
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

                } else {
                    $showFailPaymentMessage = true;
                    session()->flash('sessionError', 'فشلت عملية الدفع، الرجاء التحقق وإعادة المحاولة!');
                    return redirect()->route('frontend.beneficiaries-requests.details', [$beneficiary->service_section->slug, $beneficiary->slug]);
                }
            }

            $pageTitle  = __('translation.beneficiaries_requests') . ' » ' . $beneficiary->service_section->title . ' » ' . $beneficiary->title;
            return view('frontend.beneficiaries-requests.beneficiary-details', compact('beneficiary', 'pageTitle'));
        }
        return redirect()->route('frontend.home');
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
