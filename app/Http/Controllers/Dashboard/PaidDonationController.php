<?php

namespace App\Http\Controllers\Dashboard;

use App\Service;
use App\Donation;
use App\Donor;
use App\DonationService;
use App\Branch;
use Illuminate\Http\Request;
use App\Exports\PaidDonationsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Dashboard\donationRequest;
use App\Traits\SmsTrait;

class PaidDonationController extends Controller
{
        use SmsTrait;

    public function __construct()
    {
        $this->middleware(['permission:read_donations'])->only(['index', 'show', 'export']);
        // $this->middleware(['permission:create_donations'])->only('create');
        $this->middleware(['permission:update_donations'])->only('edit');
        $this->middleware(['permission:delete_donations'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $branch_id     = (isset(\request()->branch_id) && \request()->branch_id != '') ? \request()->branch_id : null;
        $service_id     = (isset(\request()->service_id) && \request()->service_id != '') ? \request()->service_id : null;
        $payment_ways   = (isset(\request()->payment_ways) && \request()->payment_ways != '') ? \request()->payment_ways : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $donations = Donation::query()->paid()->withCount('services')->with(['donor:id,membership_no', 'services']);

        if ($keyword != null) {
            $donations = $donations->search($keyword);
        }

        if ($branch_id != null) {
            $donations = $donations->where('branch_id', $branch_id);
        }
        
        if ($service_id != null) {
            $donations = $donations->whereHas('services', function($q) use ($service_id) {
                $q->whereServiceId($service_id);
            });
        }

        if ($payment_ways != null) {
            $donations = $donations->wherePaymentWays($payment_ways);
        }

        $donations = $donations->orderBy($sort_by, $order_by);
        $donations = $donations->paginate($limit_by);

        $services   = Service::orderBy('id', 'DESC')->pluck('title', 'id');
        $branches   = Branch::orderBy('id', 'DESC')->pluck('name', 'id');
        return view('dashboard.paid-donations.index', compact('donations', 'services', 'branches'));
    }
    
    public function create(Request $request)
    {
        return view('dashboard.paid-donations.create');
    }
    
    public function store(Request $request)
    {
        $phone  = preg_replace("/^966/", "0", $request->phone);

        if (Donor::where('phone', '=', $phone)->exists()) {
            $donor = Donor::where('phone', '=', $phone)->first();
        } else {
            $donor              = new Donor();
            $donor->phone       = $phone;
            $donor->save();   
        }
        
        $service    = Service::orderBy('id', 'DESC')->whereId($request->service_id)
                                ->active()->with('service_section')->first();
                    
                    
        $donation                   = new Donation();
        $donation->donor_id         = $donor->id;
        $donation->total_amount     = $request->total_amount * $request->quantity;
        $donation->status           = 'paid';
        $donation->payment_ways     = 'credit_card';
        $donation->payment_brand    = $request->payment_brand;
        $donation->bank_transaction_id = $request->bank_transaction_id;
        $donation->branch_id        = $request->branch_id;
        $donation->response         = NULL;
        $donation->created_at       = $request->created_at;
        $donation->save();

        $donation_service               = new DonationService();
        $donation_service->service_id   = $service->id;
        $donation_service->donation_id  = $donation->id;
        $donation_service->quantity     = $request->quantity;
        $donation_service->amount       = $request->total_amount;
        $donation_service->save();
        
        if ($request->send_sms == 'yes') {
            $name = $donor->name;
            $service = DonationService::with('service')->where('donation_id', $donation->id)->first()->service->title;
            $price = $donation->total_amount;
            $invoice_number = $donation->donation_code;
            $invoice_url = env('APP_URL') . "/donation-invoice/$invoice_number/show";
            
            $message = "أ/ $name \n";
            $message .= "شكرًا لك لتبرعك بمبلغ $price ريال سعودي \n";
            $message .= "لغرض: $service \n";
            $message .= "رقم السند: $invoice_number \n";
            $message .= "لمشاهدة السند: $invoice_url \n\n";
            $message .= "تكافل لرعاية الأيتام";
            
            $this->sendSms($phone, $message);
        }
        
        session()->flash('success', __('dashboard.created_successfully'));
        return redirect()->route('dashboard.paid-donations.index');
    }

    public function edit($id)
    {
        $donation = Donation::whereId($id)->first();
        if($donation) {
            return view('dashboard.paid-donations.edit', compact('donation'));
        }
        return redirect()->route('dashboard.paid-donations.index');
    }
    
    

    public function update(Request $request, $id)
    {
        $donation = Donation::whereId($id)->first();
        if($donation) {
            $data = $request->validate([
                'status'    =>  'required|in:paid,unpaid',
            ]);

            // update "collected_value" in service
            $services = $donation->services()->get();

            if ($request->status === 'paid') {
                foreach ($services as $service) {
                    $service->update([
                        'collected_value'  => $service->collected_value + $service->pivot->amount,
                    ]);
                }
            } else {
                foreach ($services as $service) {
                    if ($service->collected_value < 0)
                        $service->update([
                            'collected_value'  => $service->collected_value - $service->pivot->amount,
                        ]);
                    else
                        $service->update([
                            'collected_value'  => null,
                        ]);
                }
            }
            
            if ($request->send_sms == 'yes') {
                $phone = $donation->donor->phone;

                $name = $donation->donor->name;
                $service = DonationService::with('service')->where('donation_id', $donation->id)->first()->service->title;
                $price = $donation->total_amount;
                $invoice_number = $donation->donation_code;
                $invoice_url = env('APP_URL') . "/donation-invoice/$invoice_number/show";
                
                $message = "أ/ $name \n";
                $message .= "شكرًا لك لتبرعك بمبلغ $price ريال سعودي \n";
                $message .= "لغرض: $service \n";
                $message .= "رقم السند: $invoice_number \n";
                $message .= "لمشاهدة السند: $invoice_url \n\n";
                $message .= "تكافل لرعاية الأيتام";
                
                $this->sendSms($phone, $message);
            }

            $donation->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.paid-donations.index');
        }
        return redirect()->route('dashboard.paid-donations.index');
    }

    public function destroy($id)
    {
        $donation = Donation::whereId($id)->first();
        if($donation) {
            $donation->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.paid-donations.index');
        }
        return redirect()->route('dashboard.paid-donations.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $donations = Donation::select('id')->whereIn('id', $ids);
        if ($donations) {
            $donations->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.paid-donations.index');
    }

    public function export()
    {
        $keyword = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $branchId = (isset(\request()->branch_id) && \request()->branch_id != '') ? \request()->branch_id : null;
        $serviceId = (isset(\request()->service_id) && \request()->service_id != '') ? \request()->service_id : null;
        $paymentWays = (isset(\request()->payment_ways) && \request()->payment_ways != '') ? \request()->payment_ways : null;
        $sortBy = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $orderBy = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        
        $export = new PaidDonationsExport($keyword, $branchId, $serviceId, $paymentWays, $sortBy, $orderBy);
        return Excel::download($export, __('translation.paid_donations') . ' ' . date('Y-m-d h-m-i') . '.xlsx');
    }
}
