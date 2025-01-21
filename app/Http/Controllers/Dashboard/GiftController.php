<?php

namespace App\Http\Controllers\Dashboard;

use App\Gift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\GiftRequest;

class GiftController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_gifts'])->only(['index', 'show']);
        $this->middleware(['permission:create_gifts'])->only('create');
        $this->middleware(['permission:update_gifts'])->only('edit');
        $this->middleware(['permission:delete_gifts'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $status         = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $gifts = Gift::query();

        if ($keyword != null) {
            $gifts = $gifts->search($keyword);
        }

        if ($status != null) {
            $gifts = $gifts->whereStatus($status);
        }

        $gifts = $gifts->orderBy($sort_by, $order_by);
        $gifts = $gifts->paginate($limit_by);
        return view('dashboard.gifts.index', compact('gifts'));
    }

    public function edit($id)
    {
        $gift = Gift::whereId($id)->first();
        if($gift) {
            return view('dashboard.gifts.edit', compact('gift'));
        }
        return redirect()->route('dashboard.gifts.index');
    }

    public function update(GiftRequest $request, $id)
    {
        $gift = Gift::whereId($id)->first();
        if ($gift) {
            $gift->status = $gift->status == 'active' ? 'inactive' : 'active';
            $gift->save();
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.gifts.index');
    }

    public function destroy($id)
    {
        $gift = Gift::whereId($id)->first();
        if($gift) {
            $gift->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.gifts.index');
        }
        return redirect()->route('dashboard.gifts.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $gifts = Gift::select('id')->whereIn('id', $ids);
        if ($gifts) {
            $gifts->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.gifts.index');
    }
}
