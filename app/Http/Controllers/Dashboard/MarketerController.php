<?php

namespace App\Http\Controllers\Dashboard;

use App\Service;
use App\Donation;
use App\Marketer;
use App\ServiceSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\MarketerRequest;

class MarketerController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:read_marketers'])->only(['index', 'show']);
    //     $this->middleware(['permission:create_marketers'])->only('create');
    //     $this->middleware(['permission:update_marketers'])->only('edit');
    //     $this->middleware(['permission:delete_marketers'])->only(['destroy', 'multiDelete']);
    // }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $marketers = Marketer::query()->with('donations');

        if ($keyword != null) {
            $marketers = $marketers->search($keyword);
        }

        $marketers = $marketers->orderBy($sort_by, $order_by);
        $marketers = $marketers->paginate($limit_by);

        return view('dashboard.marketers.index', compact('marketers'));
    }

    public function create()
    {
        $sections = ServiceSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
        return view('dashboard.marketers.create', compact('sections'));
    }

    public function store(MarketerRequest $request)
    {
        $data = $request->except('marketer_permissions');
        $marketer = Marketer::create($data);
        if (isset($request->marketer_permissions) && count($request->marketer_permissions) > 0) {
            $marketer->marketerPermissions()->sync($request->marketer_permissions);
        }
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.marketers.index');
    }

    public function show($id)
    {
        $marketer = Marketer::whereId($id)->first();
        if($marketer) {
            $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
            $service_id     = (isset(\request()->service_id) && \request()->service_id != '') ? \request()->service_id : null;
            $payment_ways   = (isset(\request()->payment_ways) && \request()->payment_ways != '') ? \request()->payment_ways : null;
            $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
            $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
            $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

            $donations = Donation::query()->whereMarketerId($marketer->id)
                                    ->withCount('services')->with('donor:id,membership_no');

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

            $services   = Service::orderBy('id', 'DESC')->pluck('title', 'id');
            $total      = Donation::query()->select('total_amount')->whereMarketerId($id)
                                ->marketer()->get()->sum('total_amount');
            $paid       = Donation::query()->paid()->select('total_amount')->whereMarketerId($id)
                                ->marketer()->get()->sum('total_amount');
            $unpaid     = Donation::query()->unpaid()->select('total_amount')->whereMarketerId($id)
                                ->marketer()->get()->sum('total_amount');
            return view('dashboard.marketers.show', compact('marketer', 'donations', 'services', 'total', 'paid', 'unpaid'));
        }
        return redirect()->route('dashboard.marketers.index');
    }

    public function edit($id)
    {
        $marketer = Marketer::whereId($id)->first();
        if($marketer) {
            $sections = ServiceSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
            return view('dashboard.marketers.edit', compact('marketer', 'sections'));
        }
        return redirect()->route('dashboard.marketers.index');
    }

    public function update(MarketerRequest $request, $id)
    {
        $marketer = Marketer::whereId($id)->first();
        if($marketer) {
            $data = $request->except('marketer_permissions');
            $marketer->update($data);
            $marketer->marketerPermissions()->sync($request->marketer_permissions);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.marketers.index');
        }
        return redirect()->route('dashboard.marketers.index');
    }

    public function destroy($id)
    {
        $marketer = Marketer::whereId($id)->first();
        if($marketer) {
            $marketer->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.marketers.index');
        }
        return redirect()->route('dashboard.marketers.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $marketers = Marketer::select('id')->whereIn('id', $ids);
        if ($marketers) {
            $marketers->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.marketers.index');
    }
}
