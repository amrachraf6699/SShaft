<?php

namespace App\Http\Controllers\Dashboard;

use App\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\ModuleRequest;
use App\ModuleSection;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_modules'])->only(['index', 'show']);
        $this->middleware(['permission:create_modules'])->only('create');
        $this->middleware(['permission:update_modules'])->only('edit');
        $this->middleware(['permission:delete_modules'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $modules = Module::query();

        if ($keyword != null) {
            $modules = $modules->search($keyword);
        }

        $modules = $modules->orderBy($sort_by, $order_by);
        $modules = $modules->paginate($limit_by);
        return view('dashboard.modules.index', compact('modules'));
    }

    public function create()
    {
        $sections = ModuleSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
        return view('dashboard.modules.create', compact('sections'));
    }

    public function store(ModuleRequest $request)
    {
        $data = $request->validated();
        // FILE
        if ($file  = $request->file('file')) {
            $filename = time() . $file->hashName();
            $file->storeAs('/modules/', $filename, 'public');
            $data['file'] = $filename;
        }
        Module::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.modules.index');
    }

    public function edit($id)
    {
        $module = Module::whereId($id)->first();
        if($module) {
            $sections = ModuleSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
            return view('dashboard.modules.edit', compact('module', 'sections'));
        }
        return redirect()->route('dashboard.modules.index');
    }

    public function update(ModuleRequest $request, $id)
    {
        $module = Module::whereId($id)->first();
        if($module) {
            $data = $request->validated();
            // FILE
            if ($file  = $request->file('file')) {
                Storage::disk('public')->delete('/modules/' . $module->file);
                $filename = time() . $file->hashName();
                $file->storeAs('/modules/', $filename, 'public');
                $data['file'] = $filename;
            }
            $module->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.modules.index');
        }
        return redirect()->route('dashboard.modules.index');
    }

    public function destroy($id)
    {
        $module = Module::whereId($id)->first();
        if($module) {
            $module->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.modules.index');
        }
        return redirect()->route('dashboard.modules.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $modules = Module::select('id', 'img')->whereIn('id', $ids)->get();
        if ($modules) {
            foreach ($modules as $module) {
                $module->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.modules.index');
    }
}
