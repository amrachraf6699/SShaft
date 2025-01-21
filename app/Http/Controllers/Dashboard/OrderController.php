<?php

namespace App\Http\Controllers\Dashboard;

use App\Service;
use App\Order;
use Illuminate\Http\Request;
use App\Exports\PaidDonationsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Dashboard\donationRequest;

class OrderController extends Controller
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
        $donor_id     = (isset(\request()->donor_id) && \request()->donor_id != '') ? \request()->donor_id : null;
        $payment_ways   = (isset(\request()->payment_ways) && \request()->payment_ways != '') ? \request()->payment_ways : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $donations = Order::query()->with(['donor', 'services']);

        if ($keyword != null) {
            $donations = $donations->search($keyword);
        }

        if ($donor_id != null) {
            $donations = $donations->whereHas('services', function($q) use ($donor_id) {
                $q->where('donor_id', $donor_id);
            });
        }

        if ($payment_ways != null) {
            $donations = $donations->wherePaymentWays($payment_ways);
        }

        $donations = $donations->orderBy($sort_by, $order_by);
        $donations = $donations->paginate($limit_by);

        $services = Service::orderBy('id', 'DESC')->pluck('title', 'id');
        return view('dashboard.orders.index', compact('donations', 'services'));
    }
    
}