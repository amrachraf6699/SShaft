<?php

namespace App\Http\Controllers\Dashboard;

use App\ServiceSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\ServiceSectionRequest;

class ServiceSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_services'])->only(['index', 'show']);
        $this->middleware(['permission:create_services'])->only('create');
        $this->middleware(['permission:update_services'])->only('edit');
        $this->middleware(['permission:delete_services'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $sections = ServiceSection::query()->withCount('services');

        if ($keyword != null) {
            $sections = $sections->search($keyword);
        }

        $sections = $sections->orderBy($sort_by, $order_by);
        $sections = $sections->paginate($limit_by);
        return view('dashboard.services.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('dashboard.services.sections.create');
    }

    public function store(ServiceSectionRequest $request)
    {
        $data = $request->validated();
        
        
        
        // cover image
        $cover_img    = $request->file('cover');
        $cover_filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $cover_img->getClientOriginalExtension();
        $cover_img->storeAs('public/uploads/sections/', $cover_filename);
        
        //  image
        $image_img    = $request->file('image');
        $image_filename       = 'IMG_' . time() . '_' . rand(1, 9999) . '.' . $image_img->getClientOriginalExtension();
        $image_img->storeAs('public/uploads/sections/', $image_filename);
        
        
        $data['cover'] = $cover_filename;

        $data['image'] = $image_filename;
        
        ServiceSection::create($data);
        
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.service-sections.index');
    }

    public function edit($id)
    {
        $section = ServiceSection::whereId($id)->first();
        if($section) {
            return view('dashboard.services.sections.edit', compact('section'));
        }
        return redirect()->route('dashboard.service-sections.index');
    }

    public function update(ServiceSectionRequest $request, $id)
    {
        $section = ServiceSection::whereId($id)->first();
        if($section) {
            $data = $request->validated();
            // cover image
            if ($cover_img  = $request->file('cover')) {
                Storage::disk('public')->delete('/sections/' . $section->cover);
                
                $cover_filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $cover_img->getClientOriginalExtension();

                $cover_img->storeAs('public/uploads/sections/', $cover_filename);

                $data['cover'] = $cover_filename;
            }
            
            //  image
            if ($image_img  = $request->file('image')) {
                Storage::disk('public')->delete('/sections/' . $section->image);
                $image_filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $image_img->getClientOriginalExtension();

                $image_img->storeAs('public/uploads/sections/', $image_filename);
                $data['image'] = $image_filename;
            }
            $section->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.service-sections.index');
        }
        return redirect()->route('dashboard.service-sections.index');
    }

    public function destroy($id)
    {
        $section = ServiceSection::whereId($id)->first();
        if($section) {
            $section->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.service-sections.index');
        }
        return redirect()->route('dashboard.service-sections.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $sections = ServiceSection::select('id')->whereIn('id', $ids);
        if ($sections) {
            $sections->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.service-sections.index');
    }
}
