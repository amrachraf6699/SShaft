<?php

namespace App\Http\Controllers\Dashboard;

use App\LiftCenter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class LiftCenterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_lift_centers'])->only(['index', 'show']);
        $this->middleware(['permission:create_lift_centers'])->only('create');
        $this->middleware(['permission:delete_lift_centers'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $lift_centers = LiftCenter::query();

        $lift_centers = $lift_centers->orderBy($sort_by, $order_by);
        $lift_centers = $lift_centers->paginate($limit_by);
        return view('dashboard.lift-centers.index', compact('lift_centers'));
    }

    public function create()
    {
        return view('dashboard.lift-centers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file'  =>  'required|mimes:jpg,jpeg,png|max:20000',
        ]);

        $uuid = Str::uuid()->toString();
        $data['id']   = $uuid;

        // File
        $image          = $request->file('file');
        $filename       = $uuid . time() . '.' . $image->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/lift_centers/' . $filename);
        Image::make($image->getRealPath())->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);
        $data['file']   = $filename;

        LiftCenter::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.lift-centers.index');
    }

    public function openFile($file_name)
    {
        $exists = Storage::disk('public')->exists('lift_centers/' . $file_name);
        if ($exists) {
            $files = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix('lift_centers/' . $file_name);
            return response()->file($files);
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        $file = LiftCenter::whereId($id)->first();
        if ($file) {
            Storage::disk('public')->delete('/lift_centers/' . $file->file);
            $file->delete();

            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.lift-centers.index');
        }
        return redirect()->route('dashboard.lift-centers.index');
    }

    public function multiDelete(Request $request)
    {
        $ids   = explode(',', $request->ids);
        $files = LiftCenter::select('id', 'file')->whereIn('id', $ids)->get();
        if ($files) {
            foreach ($files as $file) {
                Storage::disk('public')->delete('/lift_centers/' . $file->file);
                $file->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.lift-centers.index');
    }
}