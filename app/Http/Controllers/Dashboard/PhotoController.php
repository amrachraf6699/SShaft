<?php

namespace App\Http\Controllers\Dashboard;

use App\Photo;
use App\PhotoSection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\SendEmailsToUsers​;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\PhotoRequest;

class PhotoController extends Controller
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

        $photos = Photo::query()->with('photo_section:id,title');

        if ($keyword != null) {
            $photos = $photos->search($keyword);
        }

        $photos = $photos->orderBy($sort_by, $order_by);
        $photos = $photos->paginate($limit_by);
        return view('dashboard.photos.index', compact('photos'));
    }

    public function create()
    {
        $sections = PhotoSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
        return view('dashboard.photos.create', compact('sections'));
    }

    public function store(PhotoRequest $request)
    {
        $data = $request->validated();
        // image
        $img    = $request->file('img');
        $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/photos/' . $filename);
        Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);
        $data['img'] = $filename;

        $data = Photo::create($data);
        dispatch(new SendEmailsToUsers​($data));
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.photos.index');
    }

    public function edit($id)
    {
        $photo = Photo::whereId($id)->first();
        if($photo) {
            $sections = PhotoSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
            return view('dashboard.photos.edit', compact('photo', 'sections'));
        }
        return redirect()->route('dashboard.photos.index');
    }

    public function update(PhotoRequest $request, $id)
    {
        $photo = Photo::whereId($id)->first();
        if($photo) {
            $data = $request->validated();
            // photo image
            if ($img  = $request->file('img')) {
                Storage::disk('public')->delete('/photos/' . $photo->img);
                $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/photos/' . $filename);
                Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img'] = $filename;
            }

            $photo->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.photos.index');
        }
        return redirect()->route('dashboard.photos.index');
    }

    public function destroy($id)
    {
        $photo = Photo::whereId($id)->first();
        if($photo) {
            Storage::disk('public')->delete('/photos/' . $photo->img);
            $photo->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.photos.index');
        }
        return redirect()->route('dashboard.photos.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $photos = Photo::select('id', 'img')->whereIn('id', $ids)->get();
        if ($photos) {
            foreach ($photos as $photo) {
                Storage::disk('public')->delete('/photos/' . $photo->img);
                $photo->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.photos.index');
    }
}
