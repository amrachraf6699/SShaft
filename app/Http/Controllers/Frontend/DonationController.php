<?php

namespace App\Http\Controllers\Frontend;

use App\Cart;
use App\User;
use App\Account;
use App\Service;
use App\Donation;
use App\DonationService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewDonationForAdminNotify;

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:donor')->except(['viewBankTransfer', 'storeBankTransfer']);
    }

    public function index()
    {
        $donor = auth('donor')->user();
        if ($donor) {
            $donations   = Donation::whereDonorId($donor->id)
                                ->paid()
                                ->withCount('services')
                                ->orderBy('id', 'DESC')->paginate(6);
                                // return $donations;

            $totalDonations = auth('donor')->user()->donations()->paid()->withCount('services')->get();
            $pageTitle      = __('translation.my_donations');
            return view('frontend.profile.donations', compact('donations', 'pageTitle', 'totalDonations'));
        }
        return redirect()->route('frontend.home');
    }

    public function store(Request $request)
    {
        $donor = auth('donor')->user();
        if ($donor) {
            $request->validate([
                'service'       =>  'required|array',
                'payment_ways'  => 'required|in:bank_transfer,credit_card,VISA MASTER,MADA',
            ]);

            $this->attach_donation($request, $donor);
            Cart::where('donor_id', $donor->id)->delete();

            $donation = Donation::orderBy('id', 'DESC')->whereDonorId($donor->id)->first();
            $donation->update(['payment_ways' => $request->payment_ways === 'bank_transfer' ? 'bank_transfer' : 'credit_card']);

            if ($donation->payment_ways == 'bank_transfer') {
                return redirect()->route('frontend.donations.bank-transfer.view', $donation->donation_code);
            } elseif ($donation->payment_ways == 'credit_card')
                return redirect()->route('frontend.donations.credit-card.view', [$donation->donation_code, $request->payment_ways]);
            else {
                return redirect()->route('frontend.home');
            }

            session()->flash('sessionSuccess', 'تمت العملية بنجاح!');
            return redirect()->route('frontend.donations.index');
        }
        return redirect()->route('frontend.home');
    }

    private function attach_donation($request, $donor)
    {
        $donation = $donor->donations()->create([]);

        $donation->services()->attach($request->service);

        $total_amount = 0;
        foreach ($request->service as $id => $quantity) {
            $cart = Cart::whereServiceIdAndDonorId($id, auth('donor')->user()->id)->first();
            $total_amount += $cart->amount * $quantity['quantity'];

            $service = Service::FindOrFail($id);

            // $cart->service()->update([
            //     'collected_value'  => $service->collected_value + $cart->amount * $quantity['quantity'],
            // ]);

            $service->donations()->whereDonationId($donation->id)->update([
                'amount'  =>  $cart->amount * $quantity['quantity'],
            ]);
        }


        $donation->update([
            'total_amount'  => $total_amount,
        ]);
    }

    public function donateNowStore(Request $request, $service)
    {
        if(Auth::guard('donor')->check() && Auth::guard('donor'))
        {
            $service    = Service::whereId($service)->active()->first();
            if($service) {
                // validate
                $request->validate(['quantity'  => 'required|numeric', 'amount' => 'required|numeric', 'total' => 'required|numeric']);

                // insert data
                $donation                   = new Donation();
                $donation->donor_id         = auth('donor')->user()->id;
                $donation->total_amount     = $request->total;
                $donation->payment_ways     = $request->payment_ways == 'bank_transfer' ? 'bank_transfer' : 'credit_card';
                // $donation->payment_brand    = $request->payment_ways == 'bank_transfer' ? null : $request->payment_ways;
                $donation->save();

                $donation_service               = new DonationService();
                $donation_service->service_id   = $service->id;
                $donation_service->donation_id  = $donation->id;
                $donation_service->quantity     = $request->quantity;
                $donation_service->amount       = $request->amount * $request->quantity;
                $donation_service->save();

                // $service->update([
                //     'collected_value'  => $service->collected_value + $request->amount * $request->quantity,
                // ]);

                if ($donation->payment_ways == 'bank_transfer') {
                    return redirect()->route('frontend.donations.bank-transfer.view', $donation->donation_code);
                } elseif ($donation->payment_ways == 'credit_card')
                return redirect()->route('frontend.donations.credit-card.view', [$donation->donation_code, $request->payment_ways]);
                else {
                    return redirect()->route('frontend.home');
                }
            }
            return redirect()->route('frontend.home');
        } else {
            session()->flash('sessionAuthError');
            return redirect()->back();
        }
    }

    /***
     *
     * BANK TRANSFER
     */
    public function viewBankTransfer($donation_code)
    {
        $donation = Donation::where('donation_code', '=', $donation_code)->first();
        if($donation) {
            $pageTitle      = __('translation.bank_transfer');
            $accounts = Account::query()->orderBy('id', 'DESC')->active()->get();
            return view('frontend.donations.bank-transfer', compact('donation', 'pageTitle', 'accounts'));
        }
        return redirect()->route('frontend.home');
    }

    public function storeBankTransfer(Request $request, $donation_code)
    {
        $donation = Donation::where('donation_code', '=', $donation_code)->first();
        if($donation) {
            // validate
            $data = $request->validate([
                'bank_name'     => 'required|exists:accounts,bank_name|string',
                'attachments'   => 'required|mimes:jpg,jpeg,png|max:20000'
            ],[],[
                'bank_name'     => trans('translation.bank_name'),
                'attachments'   => trans('translation.transfer_receipt'),
            ]);

            $data['payment_ways'] = 'bank_transfer';

            // transfer receipt
            $attachment     = $request->file('attachments');
            $filename       = 'IMG_' . Str::slug($donation_code, '_') . '_' . time() . '.' . $attachment->getClientOriginalExtension();
            $path           = storage_path('app/public/uploads/transfer_receipts/' . $filename);
            Image::make($attachment->getRealPath())->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $data['attachments'] = $filename;

            $donation->update($data);

            User::each(function($admin, $key) use ($donation) {
                $admin->notify(new NewDonationForAdminNotify($donation));
            });

            session()->flash('sessionSuccess', 'تمت العملية بنجاح، سيتم مراجعة طلبكم والتواصل معكم في أقرب وقت ممكن!');
            return redirect()->route('frontend.reviews.index', $donation->donation_code);
        }
        return redirect()->route('frontend.home');
    }
}
