<?php

namespace App\Http\Controllers\Dashboard;

use App\ModuleSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\ModuleSectionRequest;

class ModuleSectionController extends Controller
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

        $sections = ModuleSection::query();

        if ($keyword != null) {
            $sections = $sections->search($keyword);
        }

        $sections = $sections->orderBy($sort_by, $order_by);
        $sections = $sections->paginate($limit_by);
        return view('dashboard.modules.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('dashboard.modules.sections.create');
    }

    public function store(ModuleSectionRequest $request)
    {
        $data = $request->validated();
        // image
        // $img    = $request->file('img');
        // $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
        // $path           = storage_path('app/public/uploads/modules/' . $filename);
        // Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
        //     $constraint->aspectRatio();
        // })->save($path, 100);
        // $data['img'] = $filename;

        ModuleSection::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.module-sections.index');
    }

    public function edit($id)
    {
        $section = ModuleSection::whereId($id)->first();
        if($section) {
            return view('dashboard.modules.sections.edit', compact('section'));
        }
        return redirect()->route('dashboard.module-sections.index');
    }

    public function update(ModuleSectionRequest $request, $id)
    {
        $section = ModuleSection::whereId($id)->first();
        if($section) {
            $data = $request->validated();
            // Section image
            // if ($img  = $request->file('img')) {
            //     Storage::disk('public')->delete('/modules/' . $section->img);
            //     $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
            //     $path           = storage_path('app/public/uploads/modules/' . $filename);
            //     Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
            //         $constraint->aspectRatio();
            //     })->save($path, 100);
            //     $data['img'] = $filename;
            // }

            $section->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.module-sections.index');
        }
        return redirect()->route('dashboard.module-sections.index');
    }

    public function destroy($id)
    {
        $section = ModuleSection::whereId($id)->first();
        if($section) {
            // Storage::disk('public')->delete('/modules/' . $section->img);
            $section->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.module-sections.index');
        }
        return redirect()->route('dashboard.module-sections.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $sections = ModuleSection::select('id', 'img')->whereIn('id', $ids)->get();
        if ($sections) {
            foreach ($sections as $section) {
                // Storage::disk('public')->delete('/modules/' . $section->img);
                $section->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.module-sections.index');
    }
}
