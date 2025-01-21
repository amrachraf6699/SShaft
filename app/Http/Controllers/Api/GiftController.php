<?php

namespace App\Http\Controllers\Api;

use App\Gift;
use App\User;
use App\Order;
use App\Donation;
use App\GiftCard;
use App\GiftCategory;
use App\Traits\SmsTrait;
use Illuminate\Http\Request;
use CobraProjects\Arabic\Arabic;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Resources\DonationResource;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewDonationForAdminNotify;

class GiftController extends Controller
{
    use SmsTrait;

    /**
     * Order Now
     */
    public function orderNow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_amount'      =>  'required|numeric',
            'sender_name'       =>  'required|string|min:3',
            'sender_phone'      =>  ['required','numeric', 'regex:/^((05))[0-9]{8}$/'],
            'recipient_name'    =>  'required|string|min:3',
            'recipient_phone'   =>  ['required','numeric', 'regex:/^((05))[0-9]{8}$/', 'different:sender_phone'],
            'recipient_email'   =>  'required|email|max:255',
            'gift_category_id'  =>  'required|exists:gift_categories,id|integer',
            'gift_card_id'      =>  'required|exists:gift_cards,id|integer',
            'payment_brand'     =>  'required|in:credit_card,VISA MASTER,APPLEPAY,MADA',
        ]);

        if ($validator->fails()) {
            return response()->api(null, 200, true, $validator->errors()->first());
        }

        $data = [
            'donor_id'          =>  auth()->user()->id,
            'total_amount'      =>  $request->total_amount,
            'sender_name'       =>  $request->sender_name,
            'sender_phone'      =>  $request->sender_phone,
            'recipient_name'    =>  $request->recipient_name,
            'recipient_phone'   =>  $request->recipient_phone,
            'recipient_email'   =>  $request->recipient_email,
            'gift_category_id'  =>  $request->gift_category_id,
            'gift_card_id'      =>  $request->gift_card_id,
            'payment_ways'      =>  'credit_card',
        ];

        try {
            DB::beginTransaction();
                $gift = Gift::create($data);

                $order = new Order();
                $order->gift_id         = $gift->id;
                $order->donor_id        = auth()->user()->id;
                $order->order_type      = 'gift';
                $order->payment_brand   = $request->payment_brand;
                $order->payment_ways    = 'credit_card';
                $order->total_amount    = $gift->total_amount;
                $order->save();

                $response = [
                    'order_id'                  =>  $order->id,
                    'donor_id'                  =>  $order->donor_id,
                    'total_amount'              =>  $order->total_amount,
                    'sender_name'               =>  $gift->sender_name,
                    'sender_phone'              =>  $gift->sender_phone,
                    'recipient_name'            =>  $gift->recipient_name,
                    'recipient_phone'           =>  $gift->recipient_phone,
                    'recipient_email'           =>  $gift->recipient_email,
                    'gift_category_id'          =>  $gift->gift_category_id,
                    'gift_card_id'              =>  $gift->gift_card_id,
                    'payment_ways'              =>  $order->payment_ways,
                    'payment_brand'             =>  $order->payment_brand,
                    'merchant_transaction_id'   =>  $order->merchant_transaction_id,
                ];
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return response()->api($response, 200, false, __('api.Successful operation'));
    }

    /**
     * Gift Completed
     */
    public function giftCompleted($order_id)
    {
        $order   = Order::whereId($order_id)->first();
        $_gift   = Gift::whereId($order->gift_id)->first();

        if ($order && $_gift) {
            $data = [
                'donor_id'          =>  auth()->user()->id,
                'total_amount'      =>  $_gift->total_amount,
                'sender_name'       =>  $_gift->sender_name,
                'sender_phone'      =>  $_gift->sender_phone,
                'recipient_name'    =>  $_gift->recipient_name,
                'recipient_phone'   =>  $_gift->recipient_phone,
                'recipient_email'   =>  $_gift->recipient_email,
                'gift_category_id'  =>  $_gift->gift_category_id,
                'gift_card_id'      =>  $_gift->gift_card_id,
                'payment_ways'      =>  'credit_card',
            ];

            try {
                DB::beginTransaction();
                    $gift = Gift::create($data);

                    $donation = new Donation();
                    $donation->gift_id              = $gift->id;
                    $donation->donor_id             = auth()->user()->id;
                    $donation->donation_type        = 'gift';
                    $donation->bank_transaction_id  = $order->merchant_transaction_id;
                    $donation->payment_brand        = $order->payment_brand;
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

                    $order->delete();
                    $_gift->delete();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            return response()->api(new DonationResource($donation), 200, false, __('api.Successful operation'));
        }
        return response()->api(null, 200, true, __('api.not found data'));
    }

    /**
     * Get Gift Categories
     */
    public function getGiftCategories()
    {
        $categories = GiftCategory::query()->active()->orderBy('id', 'DESC')->select('title', 'id')->get();
        if ($categories->count() > 0) {
            return response()->api($categories, 200, false, __('api.Successful operation'));
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * Get Gift Cards Of Category
     */
    public function getGiftCardsOfCategory($id)
    {
        $category = GiftCategory::whereId($id)->active()->first();
        if ($category) {
            $cards = GiftCard::whereGiftCategoryId($id)->orderBy('id', 'DESC')->select('file_name', 'id', 'gift_category_id')->get();
            if ($cards->count() > 0) {
                return response()->api($cards, 200, false, __('api.Successful operation'));
            }
            return response()->api(null, 200, false, __('api.not found data'));
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }
}
