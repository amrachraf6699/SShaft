<?php

namespace App\Http\Controllers\Dashboard;

use App\Donor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DonorRequest;
use Illuminate\Support\Str;

class DonorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_donors'])->only(['index', 'show']);
        $this->middleware(['permission:create_donors'])->only('create');
        $this->middleware(['permission:update_donors'])->only('edit');
        $this->middleware(['permission:delete_donors'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $status         = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $donors = Donor::query();

        if ($keyword != null) {
            $donors = $donors->search($keyword);
        }

        if ($status != null) {
            $donors = $donors->whereStatus($status);
        }

        $donors = $donors->orderBy($sort_by, $order_by);
        $donors = $donors->paginate($limit_by);
        return view('dashboard.donors.index', compact('donors'));
    }

    public function edit($id)
    {
        $donor = Donor::whereId($id)->first();
        if($donor) {
            return view('dashboard.donors.edit', compact('donor'));
        }
        return redirect()->route('dashboard.donors.index');
    }

    public function update(DonorRequest $request, $id)
    {
        $donor = Donor::whereId($id)->first();
        if ($donor) {
            $donor->status = $donor->status == 'active' ? 'inactive' : 'active';
            $donor->name = $request->name;
            $donor->email = $request->email;
            $donor->phone = $request->phone;
            $donor->save();
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.donors.index');
    }

    public function destroy($id)
    {
        $donor = Donor::whereId($id)->first();
        if($donor) {
            $donor->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.donors.index');
        }
        return redirect()->route('dashboard.donors.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $donors = Donor::select('id')->whereIn('id', $ids);
        if ($donors) {
            $donors->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.donors.index');
    }
    
    public function bulkEdit()
    {
        $phones = Donor::select('phone')->where('phone', 'like', '966%')->get();
        foreach ($phones as $mobile) {
            $phone = str_replace('+', '', Str::ascii(strval(str_replace(' ','',$mobile->phone))));
            $phone =  Str::replaceFirst('966','',$phone);
            $phone =  Str::replaceFirst('005','',$phone);
            
            if(Str::startsWith($phone, '05') && strlen($phone) > 8)
            {
                $phone =  Str::replaceFirst('05','',$phone);
            }
            elseif(Str::startsWith($phone, '0') && strlen($phone) > 8)
            {
                $phone =  Str::replaceFirst('0','',$phone);
            }
            elseif(Str::startsWith($phone, '05') && strlen($phone) == 10)
            {
                $phone =  Str::replaceFirst('05','',$phone);
            }
            elseif(Str::startsWith($phone, '5') && strlen($phone) == 9)
            {
                $phone =  Str::replaceFirst('5','',$phone);
            }

            if(strlen($phone) == 8)
            {
                $phone = '05'.$phone;
                Donor::where('phone', $mobile->phone)
                ->update(['phone' => $phone,'old_phone' => $mobile->phone]);
            }
            
        }
    }
}
