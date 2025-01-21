<?php

namespace App\Http\Controllers\Frontend;

use App\Gift;
use App\User;
use App\Donation;
use App\GiftCard;
use App\GiftCategory;
use Illuminate\Http\Request;
use CobraProjects\Arabic\Arabic;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\GiftBankTransferRequest;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Notifications\NewDonationForAdminNotify;
use App\Traits\SmsTrait;

class GiftController extends Controller
{
    use SmsTrait;

    // view add a gift
    public function addAGift()
    {
        if (Auth::guard('donor')->check() && Auth::guard('donor'))
        {
            $pageTitle  = __('translation.gift');
            $categories = GiftCategory::query()->active()->orderBy('id', 'DESC')->get();

            // PAYMENT PROVIDER
            if(request('id') && request('resourcePath')) {
                $res            = session()->get(request('session_name'));
                $payment_status = $this->getPaymentStatus(request('id'), request('resourcePath'));
                $result_code    = $payment_status['result']['code'];

                if (($result_code == '000.100.110' || $result_code == '000.000.000' || $result_code == '000.300.000') && isset($payment_status['merchantTransactionId']) && !empty($payment_status['merchantTransactionId'])) { // success payment id >> transaction bank id
                    $showSuccessPaymentMessage = true;
                    // save transaction in gift table with transaction id  = $payment_status['id]
                    $data = [
                        'donor_id'          =>  auth('donor')->user()->id,
                        'total_amount'      =>  $payment_status['amount'],
                        'sender_name'       =>  $res['sender_name'],
                        'sender_phone'      =>  $res['sender_phone'],
                        'recipient_name'    =>  $res['recipient_name'],
                        'recipient_phone'   =>  $res['recipient_phone'],
                        'recipient_email'   =>  $res['recipient_email'],
                        'gift_category_id'  =>  $res['gift_category_id'],
                        'gift_card_id'      =>  $res['gift_card_id'],
                        'payment_ways'      =>  'credit_card',
                    ];

                    try {
                        DB::beginTransaction();
                            $gift = Gift::create($data);

                            $donation = new Donation();
                            $donation->gift_id              = $gift->id;
                            $donation->donor_id             = auth('donor')->user()->id;
                            $donation->donation_type        = 'gift';
                            $donation->bank_transaction_id  = $payment_status['id'];
                            $donation->bank_transaction_id  = $payment_status['merchantTransactionId'];
                            $donation->payment_brand        = $payment_status['paymentBrand'];
                            $donation->status               = 'paid';
                            $donation->payment_ways         = 'credit_card';
                            $donation->total_amount         = $gift->total_amount;
                            $donation->save();

                            // --- write text on image --- //
                            $card = GiftCard::whereId($gift->gift_card_id)->first();

                            $Arabic         = new Arabic('Glyphs');
                            $sender_name    = $Arabic->utf8Glyphs($gift->sender_name);
                            $recipient_name = $Arabic->utf8Glyphs($gift->recipient_name);

                            $file_data = file_get_contents($card->card_path, false, stream_context_create([
                                'ssl' => [
                                    'verify_peer'      => false,
                                    'verify_peer_name' => false,
                                ],
                            ]));

                            $extension  = pathinfo($card->card_path, PATHINFO_EXTENSION);
                            $filename   = 'GIFT' . substr($gift->gift_code, 6) . rand(99, 999999999) . date('Ymdhmi') . '.' . $extension;
                            $path       = storage_path('app/public/uploads/gift_cards_to_donors/' . $filename);

                            Image::make($file_data)->resize(800, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->text($sender_name, 100, 430, function ($font) {
                                $font->file(public_path('frontend_files/assets/certificate_albir/fonts/AlSharkTitle-Light.otf'));
                                $font->size(40);
                                $font->color('#000');
                            })->text($recipient_name, 440, 700, function ($font) {
                                $font->file(public_path('frontend_files/assets/certificate_albir/fonts/AlSharkTitle-Light.otf'));
                                $font->size(40);
                                $font->color('#fbbe4a');
                            })->save($path, 100);
                            // --- write text on image --- //

                            $gift->update(['gift_card_name' => $filename]);

                            if ($donation->status === 'paid') {
                                // Send sms to sender
                                $this->giftConfirmationSms($gift->sender_phone, __('translation.gift_confirmation_sms_sender',
                                        ['recipient_name' => $gift->recipient_name, 'card_path' => $gift->gift_card_path])
                                    );
                                // Send sms to recipient
                                $this->giftConfirmationSms($gift->recipient_phone, __('translation.gift_confirmation_sms_recipient',
                                        ['recipient_name' => $gift->recipient_name, 'sender_name' => $gift->sender_name, 'card_path' => $gift->gift_card_path])
                                    );
                            }

                            User::each(function($admin, $key) use ($donation) {
                                $admin->notify(new NewDonationForAdminNotify($donation));
                            });

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        throw $e;
                    }
                    session()->flash('sessionSuccess', 'تمت العملية بنجاح، جعله الله عملاً خالصاً في ميزان حسناتكم!');
                    return redirect()->route('frontend.reviews.index', $donation->donation_code);
                } else {
                    $showFailPaymentMessage = true;
                    session()->flash('sessionError', 'فشلت عملية الدفع، الرجاء التحقق وإعادة المحاولة!');
                    return redirect()->route('frontend.add-a-gift');
                }
            }

            return view('frontend.pages.add-a-gift', compact('pageTitle', 'categories'));
        }
        return redirect()->route('frontend.home');
    }

    /**
     *
     * store a gift => [Bank Transfer]
     *
     */
    public function storeAGift(GiftBankTransferRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
                $gift = Gift::create($data);

                $donation = new Donation();
                $donation->gift_id          = $gift->id;
                $donation->donor_id         = auth('donor')->user()->id;
                $donation->donation_type    = 'gift';
                $donation->status           = 'unpaid';
                $donation->payment_ways     = $gift->payment_ways;
                $donation->total_amount     = $gift->total_amount;
                $donation->save();

                // --- write text on image --- //
                $card = GiftCard::whereId($gift->gift_card_id)->first();

                $Arabic         = new Arabic('Glyphs');
                $sender_name    = $Arabic->utf8Glyphs($gift->sender_name);
                $recipient_name = $Arabic->utf8Glyphs($gift->recipient_name);

                $file_data = file_get_contents($card->card_path, false, stream_context_create([
                    'ssl' => [
                        'verify_peer'      => false,
                        'verify_peer_name' => false,
                    ],
                ]));

                $extension  = pathinfo($card->card_path, PATHINFO_EXTENSION);
                $filename   = 'GIFT' . substr($gift->gift_code, 6) . rand(99, 999999999) . date('Ymdhmi') . '.' . $extension;
                $path       = storage_path('app/public/uploads/gift_cards_to_donors/' . $filename);

                Image::make($file_data)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->text($sender_name, 100, 430, function ($font) {
                    $font->file(public_path('frontend_files/assets/certificate_albir/fonts/AlSharkTitle-Light.otf'));
                    $font->size(40);
                    $font->color('#000');
                })->text($recipient_name, 440, 700, function ($font) {
                    $font->file(public_path('frontend_files/assets/certificate_albir/fonts/AlSharkTitle-Light.otf'));
                    $font->size(40);
                    $font->color('#fbbe4a');
                })->save($path, 100);
                // --- write text on image --- //

                $gift->update(['gift_card_name' => $filename]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if ($donation->payment_ways == 'bank_transfer') {
            return redirect()->route('frontend.donations.bank-transfer.view', $donation->donation_code);
        }
        return redirect()->route('frontend.home');
    }

    public function getGiftCards($id)
    {
        $cards = GiftCard::whereGiftCategoryId($id)->orderBy('id', 'DESC')->pluck('file_name', 'id');
        return json_encode($cards);
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
