<?php

namespace App\Http\Controllers\Dashboard;

use App\Service;
use App\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VerificationDonationsExport;
use App\Http\Requests\Dashboard\DonationRequest;

class VerificationDonationController extends Controller
{
     public function __construct()
    {
        $this->middleware(['permission:read_donations'])->only(['index', 'show', 'export']);
        $this->middleware(['permission:create_donations'])->only('create');
        $this->middleware(['permission:update_donations'])->only('edit');
        $this->middleware(['permission:delete_donations'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $service_id     = (isset(\request()->service_id) && \request()->service_id != '') ? \request()->service_id : null;
        $payment_ways   = (isset(\request()->payment_ways) && \request()->payment_ways != '') ? \request()->payment_ways : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $donations = Donation::query()->verification()->withCount('services')->with(['donor:id,membership_no', 'services']);

        if ($keyword != null) {
            $donations = $donations->search($keyword);
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

        $services = Service::orderBy('id', 'DESC')->pluck('title', 'id');
        return view('dashboard.verification-donations.index', compact('donations', 'services'));
    }

    public function edit($id)
    {
        $donation = Donation::whereId($id)->first();
        if($donation) {
            return view('dashboard.verification-donations.edit', compact('donation'));
        }
        return redirect()->route('dashboard.verification-donations.index');
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


            $donation->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.verification-donations.index');
        }
        return redirect()->route('dashboard.verification-donations.index');
    }

    public function destroy($id)
    {
        $donation = Donation::whereId($id)->first();
        if($donation) {
            $donation->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.verification-donations.index');
        }
        return redirect()->route('dashboard.verification-donations.index');
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
        return redirect()->route('dashboard.verification-donations.index');
    }

    public function export()
    {
        return Excel::download(new VerificationDonationsExport, __('translation.verification_donations') . ' ' . date('Y-m-d h-m-i') . '.xlsx');
    }
}
