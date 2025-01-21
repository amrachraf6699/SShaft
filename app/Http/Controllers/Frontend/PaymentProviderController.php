<?php

namespace App\Http\Controllers\frontend;

use App\Marketer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\GiftCreditCardRequest;
use App\Http\Requests\Frontend\PaymentProviderRequest;
use App\Http\Requests\Frontend\MembersChoosePaymentMethodRequest;
use App\Http\Requests\Frontend\BeneficiaryPaymentProviderRequest;

class PaymentProviderController extends Controller
{
    public function getCheckout(Request $request)
    {
        $donationData = [
            'total_amount'  => $request->total_amount,
            'donationId'    => $request->donationId,
            'donation_code' => $request->donation_code,
            'payment_brand' => $request->payment_brand,
        ];

        $session_name = 'pay_' . bin2hex(openssl_random_pseudo_bytes(8)) . date('Ymdhmi');
        $request->session()->put($session_name, $donationData);

        if ($request->payment_brand == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($request->payment_brand == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url    = config('payment_information.hyperpay.master_link');
        $data   = "entityId=" . $entity_id .
                    "&amount=" . $request->total_amount .
                    "&currency=SAR" .
                    "&merchantTransactionId=" . $session_name .
                    "&paymentType=DB" .
                    "&customer.email=" .
                    "&billing.street1= street one" .
                    "&billing.city= ryadh" .
                    "&billing.state=ryadh" .
                    "&billing.country=SA" .
                    "&billing.postcode=00000";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    config('payment_information.hyperpay.authorization')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // res
        $res            = json_decode($responseData, true);
        $donation_code  = $request->donation_code;
        $payment_brand  = $request->payment_brand;
        $route          = route('frontend.donations.credit-card.view', [$donation_code, $payment_brand]);

        $view   = view('frontend.ajax.payment-form-service', compact('res', 'route', 'payment_brand', 'session_name'))
                    ->renderSections();
        return response()->json([
            'status'    =>  true,
            'content'   =>  $view['main']
        ]);
    }

    public function getServiceCheckout(PaymentProviderRequest $request)
    {
        $donationData = $request->validated();
        $session_name = 'pay_' . bin2hex(openssl_random_pseudo_bytes(8)) . date('Ymdhmi');
        $request->session()->put($session_name, $donationData);

        if ($request->payment_brand == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($request->payment_brand == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url    = config('payment_information.hyperpay.master_link');
        $data   = "entityId=" . $entity_id .
                    "&amount=" . $request->total_amount .
                    "&currency=SAR" .
                    "&merchantTransactionId=" . $session_name .
                    "&paymentType=DB" .
                    "&customer.email=" .
                    "&billing.street1= street one" .
                    "&billing.city= ryadh" .
                    "&billing.state=ryadh" .
                    "&billing.country=SA" .
                    "&billing.postcode=00000";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    config('payment_information.hyperpay.authorization')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // res
        $res                    = json_decode($responseData, true);
        $service_slug           = $request->serviceSlug;
        $service_section_slug   = $request->serviceSectionSlug;
        $payment_brand          = $request->payment_brand;
        $route                  = route('frontend.services-sections.service.show', [$service_section_slug, $service_slug]);

        $view   = view('frontend.ajax.payment-form-service', compact('res', 'route', 'session_name', 'payment_brand'))
                    ->renderSections();
        return response()->json([
            'status'    =>  true,
            'content'   =>  $view['main']
        ]);
    }

    public function getAllServicesServiceCheckout(PaymentProviderRequest $request)
    {
        $donationData = $request->validated();
        $session_name = 'pay_' . bin2hex(openssl_random_pseudo_bytes(8)) . date('Ymdhmi');
        $request->session()->put($session_name, $donationData);

        if ($request->payment_brand == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($request->payment_brand == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url    = config('payment_information.hyperpay.master_link');
        $data   = "entityId=" . $entity_id .
                    "&amount=" . $request->total_amount .
                    "&currency=SAR" .
                    "&merchantTransactionId=" . $session_name .
                    "&paymentType=DB" .
                    "&customer.email=" .
                    "&billing.street1= street one" .
                    "&billing.city= ryadh" .
                    "&billing.state=ryadh" .
                    "&billing.country=SA" .
                    "&billing.postcode=00000";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    config('payment_information.hyperpay.authorization')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // res
        $res                    = json_decode($responseData, true);
        $service_section_slug   = $request->serviceSectionSlug;
        $payment_brand          = $request->payment_brand;
        $route                  = route('frontend.services-sections', $service_section_slug);

        $view   = view('frontend.ajax.payment-form-service', compact('res', 'route', 'session_name', 'payment_brand'))
                    ->renderSections();
        return response()->json([
            'status'    =>  true,
            'content'   =>  $view['main']
        ]);
    }

    public function getIndexServicesCheckout(PaymentProviderRequest $request)
    {
        $donationData = $request->validated();
        $session_name = 'pay_' . bin2hex(openssl_random_pseudo_bytes(8)) . date('Ymdhmi');
        $request->session()->put($session_name, $donationData);

        if ($request->payment_brand == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($request->payment_brand == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url    = config('payment_information.hyperpay.master_link');
        $data   = "entityId=" . $entity_id .
                    "&amount=" . $request->total_amount .
                    "&currency=SAR" .
                    "&merchantTransactionId=" . $session_name .
                    "&paymentType=DB" .
                    "&customer.email=" .
                    "&billing.street1= street one" .
                    "&billing.city= ryadh" .
                    "&billing.state=ryadh" .
                    "&billing.country=SA" .
                    "&billing.postcode=00000";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    config('payment_information.hyperpay.authorization')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // res
        $res                    = json_decode($responseData, true);
        $payment_brand          = $request->payment_brand;
        $route                  = route('frontend.home');

        $view   = view('frontend.ajax.payment-form-service', compact('res', 'route', 'payment_brand', 'session_name'))
                    ->renderSections();
        return response()->json([
            'status'    =>  true,
            'content'   =>  $view['main']
        ]);
    }

    public function quickDonationSideBarCheckout(PaymentProviderRequest $request)
    {
        $donationData = $request->validated();
        $session_name = 'pay_' . bin2hex(openssl_random_pseudo_bytes(8)) . date('Ymdhmi');
        $request->session()->put($session_name, $donationData);

        if ($request->payment_brand == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($request->payment_brand == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url    = config('payment_information.hyperpay.master_link');
        $data   = "entityId=" . $entity_id .
                    "&amount=" . $request->total_amount .
                    "&currency=SAR" .
                    "&merchantTransactionId=" . $session_name .
                    "&paymentType=DB" .
                    "&customer.email=" .
                    "&billing.street1= street one" .
                    "&billing.city= ryadh" .
                    "&billing.state=ryadh" .
                    "&billing.country=SA" .
                    "&billing.postcode=00000";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    config('payment_information.hyperpay.authorization')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // res
        $res                    = json_decode($responseData, true);
        $payment_brand          = $request->payment_brand;
        $route                  = route('frontend.home');

        $view   = view('frontend.ajax.payment-form-service', compact('res', 'route', 'payment_brand', 'session_name'))
                    ->renderSections();
        return response()->json([
            'status'    =>  true,
            'content'   =>  $view['main']
        ]);
    }

    public function addGiftCheckout(GiftCreditCardRequest $request)
    {
        $giftData       = $request->validated();
        $session_name   = 'pay_' . bin2hex(openssl_random_pseudo_bytes(8)) . date('Ymdhmi');
        $request->session()->put($session_name, $giftData);

        if ($request->payment_brand == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($request->payment_brand == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url    = config('payment_information.hyperpay.master_link');
        $data   = "entityId=" . $entity_id .
                    "&amount=" . $request->total_amount .
                    "&currency=SAR" .
                    "&merchantTransactionId=" . $session_name .
                    "&paymentType=DB" .
                    "&customer.email=" .
                    "&billing.street1= street one" .
                    "&billing.city= ryadh" .
                    "&billing.state=ryadh" .
                    "&billing.country=SA" .
                    "&billing.postcode=00000";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    config('payment_information.hyperpay.authorization')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // res
        $res                = json_decode($responseData, true);
        $payment_brand      = $request->payment_brand;
        $route              = route('frontend.add-a-gift');

        $view   = view('frontend.ajax.payment-form-service', compact('res', 'route', 'payment_brand', 'session_name'))
                    ->renderSections();
        return response()->json([
            'status'    =>  true,
            'content'   =>  $view['main']
        ]);
    }
    
    public function membersChoosePaymentMethodCheckout(MembersChoosePaymentMethodRequest $request)
    {
        $data           = $request->validated();
        $session_name   = 'pay_' . bin2hex(openssl_random_pseudo_bytes(8)) . date('Ymdhmi');
        $request->session()->put($session_name, $data);

        if ($request->payment_brand == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($request->payment_brand == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url    = config('payment_information.hyperpay.master_link');
        $data   = "entityId=" . $entity_id .
                    "&amount=" . $request->total_amount .
                    "&currency=SAR" .
                    "&merchantTransactionId=" . $session_name .
                    "&paymentType=DB" .
                    "&customer.email=" .
                    "&billing.street1= street one" .
                    "&billing.city= ryadh" .
                    "&billing.state=ryadh" .
                    "&billing.country=SA" .
                    "&billing.postcode=00000";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    config('payment_information.hyperpay.authorization')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // res
        $res                = json_decode($responseData, true);
        $payment_brand      = $request->payment_brand;
        $route              = route('frontend.pay-general-assembly-members.choose-payment-method.view', [$request->member_uuid, $request->invoice_no]);

        $view   = view('frontend.ajax.payment-form-service', compact('res', 'route', 'payment_brand', 'session_name'))
                    ->renderSections();
        return response()->json([
            'status'    =>  true,
            'content'   =>  $view['main']
        ]);
    }
    
    public function getMarketersServiceCheckout(PaymentProviderRequest $request, $username)
    {
        $marketer   = Marketer::whereUsername($username)->active()->first();
        if ($marketer) {
            $donationData = $request->validated();
            $session_name = 'pay_' . bin2hex(openssl_random_pseudo_bytes(8)) . date('Ymdhmi');
            $request->session()->put($session_name, $donationData);

            if ($request->payment_brand == 'MADA') {
                $entity_id = config('payment_information.hyperpay.entityIdMADA');
            } elseif ($request->payment_brand == 'APPLEPAY') {
                $entity_id = config('payment_information.hyperpay.entityIdApplePay');
            } else {
                $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
            }

            $url    = config('payment_information.hyperpay.master_link');
            $data   = "entityId=" . $entity_id .
                        "&amount=" . $request->total_amount .
                        "&currency=SAR" .
                        "&merchantTransactionId=" . $session_name .
                        "&paymentType=DB" .
                        "&customer.email=" .
                        "&billing.street1= street one" .
                        "&billing.city= ryadh" .
                        "&billing.state=ryadh" .
                        "&billing.country=SA" .
                        "&billing.postcode=00000";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        config('payment_information.hyperpay.authorization')));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);

            // res
            $res                    = json_decode($responseData, true);
            $payment_brand          = $request->payment_brand;
            $route                  = route('frontend.marketers.index', $marketer->username);

            $view   = view('frontend.ajax.payment-form-service', compact('res', 'route', 'session_name', 'payment_brand'))
                        ->renderSections();
            return response()->json([
                'status'    =>  true,
                'content'   =>  $view['main']
            ]);
        }
        return abort(404);
    }
    
    /**** */
    public function getAllBeneficiariesCheckout(BeneficiaryPaymentProviderRequest $request)
    {
        $donationData = $request->validated();
        $session_name = 'pay_' . bin2hex(openssl_random_pseudo_bytes(8)) . date('Ymdhmi');
        $request->session()->put($session_name, $donationData);

        if ($request->payment_brand == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($request->payment_brand == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url    = config('payment_information.hyperpay.master_link');
        $data   = "entityId=" . $entity_id .
                    "&amount=" . $request->total_amount .
                    "&currency=SAR" .
                    "&merchantTransactionId=" . $session_name .
                    "&paymentType=DB" .
                    "&customer.email=" .
                    "&billing.street1= street one" .
                    "&billing.city= ryadh" .
                    "&billing.state=ryadh" .
                    "&billing.country=SA" .
                    "&billing.postcode=00000";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    config('payment_information.hyperpay.authorization')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // res
        $res                        = json_decode($responseData, true);
        $beneficiary_section_slug   = $request->beneficiarySectionSlug;
        $payment_brand              = $request->payment_brand;
        $route                      = route('frontend.beneficiaries-requests.section.show', $beneficiary_section_slug);

        $view   = view('frontend.ajax.payment-form-service', compact('res', 'route', 'session_name', 'payment_brand'))
                    ->renderSections();
        return response()->json([
            'status'    =>  true,
            'content'   =>  $view['main']
        ]);
    }

    public function getIndexBeneficiariesCheckout(BeneficiaryPaymentProviderRequest $request)
    {
        $donationData = $request->validated();
        $session_name = 'pay_' . bin2hex(openssl_random_pseudo_bytes(8)) . date('Ymdhmi');
        $request->session()->put($session_name, $donationData);

        if ($request->payment_brand == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($request->payment_brand == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url    = config('payment_information.hyperpay.master_link');
        $data   = "entityId=" . $entity_id .
                    "&amount=" . $request->total_amount .
                    "&currency=SAR" .
                    "&merchantTransactionId=" . $session_name .
                    "&paymentType=DB" .
                    "&customer.email=" .
                    "&billing.street1= street one" .
                    "&billing.city= ryadh" .
                    "&billing.state=ryadh" .
                    "&billing.country=SA" .
                    "&billing.postcode=00000";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    config('payment_information.hyperpay.authorization')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // res
        $res                    = json_decode($responseData, true);
        $payment_brand          = $request->payment_brand;
        $route                  = route('frontend.home');

        $view   = view('frontend.ajax.payment-form-service', compact('res', 'route', 'payment_brand', 'session_name'))
                    ->renderSections();
        return response()->json([
            'status'    =>  true,
            'content'   =>  $view['main']
        ]);
    }
}
