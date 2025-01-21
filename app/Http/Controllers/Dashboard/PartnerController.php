<?php

namespace App\Http\Controllers\Dashboard;

use App\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\PartnerRequest;

class PartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_partners'])->only(['index', 'show']);
        $this->middleware(['permission:create_partners'])->only('create');
        $this->middleware(['permission:update_partners'])->only('edit');
        $this->middleware(['permission:delete_partners'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $partners = Partner::query();

        if ($keyword != null) {
            $partners = $partners->search($keyword);
        }

        $partners = $partners->orderBy($sort_by, $order_by);
        $partners = $partners->paginate($limit_by);
        return view('dashboard.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('dashboard.partners.create');
    }

    public function store(PartnerRequest $request)
    {
        $data   = $request->validated();
        // img
        $img            = $request->file('img');
        $filename       = 'IMG_' . time() . '_' . rand(1, 9999) . '_' . rand(1, 999999999) . '.' . $img->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/partners/' . $filename);
        Image::make($img->getRealPath())->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);
        $data['img']   = $filename;

        Partner::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.partners.index');
    }

    public function show($id)
    {
        $partner = Partner::whereId($id)->first();
        if($partner) {
            return view('dashboard.partners.show', compact('partner'));
        }
        return redirect()->route('dashboard.partners.index');
    }

    public function edit($id)
    {
        $partner = Partner::whereId($id)->first();
        if($partner) {
            return view('dashboard.partners.edit', compact('partner'));
        }
        return redirect()->route('dashboard.partners.index');
    }

    public function update(PartnerRequest $request, $id)
    {
        $partner = Partner::whereId($id)->first();
        if($partner) {
            $data   = $request->validated();
            // img
            if ($img = $request->file('img')) {
                Storage::disk('public')->delete('/partners/' . $partner->img);

                $filename       = 'IMG_' . time() . '_' . rand(1, 9999) . '_' . rand(1, 999999999) . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/partners/' . $filename);
                Image::make($img->getRealPath())->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img']   = $filename;
            }

            $partner->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.partners.index');
        }
        return redirect()->route('dashboard.partners.index');
    }

    public function destroy($id)
    {
        $partner = Partner::whereId($id)->first();
        if($partner) {
            Storage::disk('public')->delete('/partners/' . $partner->img);
            $partner->delete();

            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.partners.index');
        }
        return redirect()->route('dashboard.partners.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $partners = Partner::select('id', 'img')->whereIn('id', $ids)->get();
        if ($partners) {
            foreach ($partners as $partner) {
                Storage::disk('public')->delete('/partners/' . $partner->img);
                $partner->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.partners.index');
    }
}
