<?php

namespace App\Http\Controllers\Dashboard;

use App\EmploymentApplication;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmploymentApplicationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:read_employment_applications'])->only(['index']);
    //     $this->middleware(['permission:delete_employment_applications'])->only(['destroy', 'multiDelete']);
    // }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $applications = EmploymentApplication::query();

        if ($keyword != null) {
            $applications = $applications->search($keyword);
        }

        $applications = $applications->orderBy($sort_by, $order_by);
        $applications = $applications->paginate($limit_by);
        return view('dashboard.employment-applications.index', compact('applications'));
    }
}
