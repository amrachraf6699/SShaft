<?php

namespace App\Http\Controllers\Dashboard;

use App\Government;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\GovernmentRequest;

class GovernmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_get_to_know_us'])->only(['index', 'show']);
        $this->middleware(['permission:create_get_to_know_us'])->only('create');
        $this->middleware(['permission:update_get_to_know_us'])->only('edit');
        $this->middleware(['permission:delete_get_to_know_us'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $governments = Government::query();

        if ($keyword != null) {
            $governments = $governments->search($keyword);
        }

        $governments = $governments->orderBy($sort_by, $order_by);
        $governments = $governments->paginate($limit_by);
        return view('dashboard.governance-material.index', compact('governments'));
    }

    public function create()
    {
        return view('dashboard.governance-material.create');
    }

    public function store(GovernmentRequest $request)
    {
        $data = $request->validated();
        // FILE
        if ($file  = $request->file('file')) {
            $filename = time() . $file->hashName();
            $file->storeAs('/governments/', $filename, 'public');
            $data['file'] = $filename;
        }
        Government::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.governance-material.index');
    }

    public function edit($id)
    {
        $government = Government::whereId($id)->first();
        if($government) {
            return view('dashboard.governance-material.edit', compact('government'));
        }
        return redirect()->route('dashboard.governance-material.index');
    }

    public function update(GovernmentRequest $request, $id)
    {
        $government = Government::whereId($id)->first();
        if($government) {
            $data = $request->validated();
            // FILE
            if ($file  = $request->file('file')) {
                Storage::disk('public')->delete('/governments/' . $government->file);
                $filename = time() . $file->hashName();
                $file->storeAs('/governments/', $filename, 'public');
                $data['file'] = $filename;
            }
            $government->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.governance-material.index');
        }
        return redirect()->route('dashboard.governance-material.index');
    }

    public function destroy($id)
    {
        $government = Government::whereId($id)->first();
        if($government) {
            Storage::disk('public')->delete('/governments/' . $government->file);
            $government->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.governance-material.index');
        }
        return redirect()->route('dashboard.governance-material.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $governments = Government::select('id')->whereIn('id', $ids)->get();
        if ($governments) {
            foreach ($governments as $government) {
                Storage::disk('public')->delete('/governments/' . $government->file);
                $government->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.governance-material.index');
    }
}
