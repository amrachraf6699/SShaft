<?php

namespace App\Http\Controllers\Dashboard;

use App\PhotoSection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\PhotoSectionRequest;

class PhotoSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_photos'])->only(['index', 'show']);
        $this->middleware(['permission:create_photos'])->only('create');
        $this->middleware(['permission:update_photos'])->only('edit');
        $this->middleware(['permission:delete_photos'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $sections = PhotoSection::query();

        if ($keyword != null) {
            $sections = $sections->search($keyword);
        }

        $sections = $sections->orderBy($sort_by, $order_by);
        $sections = $sections->paginate($limit_by);
        return view('dashboard.photos.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('dashboard.photos.sections.create');
    }

    public function store(PhotoSectionRequest $request)
    {
        $data = $request->validated();
        // image
        $img    = $request->file('img');
        $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/photo_sections/' . $filename);
        Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);
        $data['img'] = $filename;

        PhotoSection::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.photo-sections.index');
    }

    public function edit($id)
    {
        $section = PhotoSection::whereId($id)->first();
        if($section) {
            return view('dashboard.photos.sections.edit', compact('section'));
        }
        return redirect()->route('dashboard.photo-sections.index');
    }

    public function update(PhotoSectionRequest $request, $id)
    {
        $section = PhotoSection::whereId($id)->first();
        if($section) {
            $data = $request->validated();
            // Section image
            if ($img  = $request->file('img')) {
                Storage::disk('public')->delete('/photo_sections/' . $section->img);
                $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/photo_sections/' . $filename);
                Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img'] = $filename;
            }

            $section->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.photo-sections.index');
        }
        return redirect()->route('dashboard.photo-sections.index');
    }

    public function destroy($id)
    {
        $section = PhotoSection::whereId($id)->first();
        if($section) {
            Storage::disk('public')->delete('/photo_sections/' . $section->img);
            $section->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.photo-sections.index');
        }
        return redirect()->route('dashboard.photo-sections.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $sections = PhotoSection::select('id', 'img')->whereIn('id', $ids)->get();
        if ($sections) {
            foreach ($sections as $section) {
                Storage::disk('public')->delete('/photo_sections/' . $section->img);
                $section->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.photo-sections.index');
    }
}
