<?php

namespace App\Http\Controllers\Dashboard;

use App\Service;
use App\ServiceSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\ServiceRequest;

class ServiceController extends Controller
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

        $services = Service::query()->with('service_section:id,title');

        if ($keyword != null) {
            $services = $services->search($keyword);
        }

        $services = $services->orderBy($sort_by, $order_by);
        $services = $services->paginate($limit_by);
        return view('dashboard.services.index', compact('services'));
    }

    public function create()
    {
        $sections = ServiceSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
        return view('dashboard.services.create', compact('sections'));
    }

    public function store(ServiceRequest $request)
    {
        $data = $request->validated();


        // cover image
        $cover_img    = $request->file('cover');
        $cover_filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $cover_img->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/services/' . $cover_filename);
        Image::make($cover_img->getRealPath())->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);


        // image
        $img    = $request->file('img');
        $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/services/' . $filename);
        Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);

        // app icon
        $app_icon       = $request->file('app_icon');
        $iconName       = 'ICON_' . time() . '_' . rand(1, 999999) . '.' . $app_icon->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/services/' . $iconName);
        Image::make($app_icon->getRealPath())->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);

        $data['cover']        = $cover_filename;
        $data['img']        = $filename;
        $data['app_icon']   = $iconName;

        Service::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.services.index');
    }

    public function show($id)
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $section = ServiceSection::whereId($id)->first();

        if($section) {
            $services = Service::query()->whereServiceSectionId($id)->with('service_section:id,title');

            if ($keyword != null) {
                $services = $services->search($keyword);
            }

            $services = $services->orderBy($sort_by, $order_by);
            $services = $services->paginate($limit_by);
            return view('dashboard.services.index', compact('services'));
        }
        return redirect()->route('dashboard.services.index');
    }

    public function edit($id)
    {
        $service = Service::whereId($id)->first();
        if($service) {
            $sections = ServiceSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
            return view('dashboard.services.edit', compact('service', 'sections'));
        }
        return redirect()->route('dashboard.services.index');
    }

    public function update(ServiceRequest $request, $id)
    {
        $service = Service::whereId($id)->first();
        if($service) {
            $data = $request->validated();
            // cover image
            if ($cover_img  = $request->file('cover')) {
                Storage::disk('public')->delete('/services/' . $service->cover);
                $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $cover_img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/services/' . $filename);
                Image::make($cover_img->getRealPath())->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['cover'] = $filename;
            }

            // service image
            if ($img  = $request->file('img')) {
                Storage::disk('public')->delete('/services/' . $service->img);
                $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/services/' . $filename);
                Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img'] = $filename;
            }

            // app icon
            if ($app_icon  = $request->file('app_icon')) {
                Storage::disk('public')->delete('/services/' . $service->app_icon);
                $iconName       = 'ICON_' . time() . '_' . rand(1, 999999) . '.' . $app_icon->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/services/' . $iconName);
                Image::make($app_icon->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['app_icon'] = $iconName;
            }

            $service->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.services.index');
        }
        return redirect()->route('dashboard.services.index');
    }

    public function destroy($id)
    {
        $service = Service::whereId($id)->first();
        if($service) {
            Storage::disk('public')->delete('/services/' . $service->img);
            Storage::disk('public')->delete('/services/' . $service->app_icon);
            $service->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.services.index');
        }
        return redirect()->route('dashboard.services.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $services = Service::select('id', 'img')->whereIn('id', $ids)->get();
        if ($services) {
            foreach ($services as $service) {
                Storage::disk('public')->delete('/services/' . $service->img);
                Storage::disk('public')->delete('/services/' . $service->app_icon);
                $service->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.services.index');
    }
}
