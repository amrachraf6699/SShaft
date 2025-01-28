<?php

namespace App\Http\Controllers\Dashboard;

use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\SliderRequest;
use App\Service;

class SliderController extends Controller
{
    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $sliders = Slider::query();

        if ($keyword != null) {
            $sliders = $sliders->search($keyword);
        }

        $sliders = $sliders->orderBy($sort_by, $order_by);
        $sliders = $sliders->paginate($limit_by);
        return view('dashboard.sliders.index', compact('sliders'));
    }

    public function create()
    {
        $services = Service::orderBy('id', 'DESC')->active()->pluck('title', 'id');
        return view('dashboard.sliders.create', compact('services'));
    }

    public function store(SliderRequest $request)
    {
        $data   = $request->validated();

        $img            = $request->file('img');
        $filename       = 'IMG_S_' . time() . '_' . rand(1, 9999) . '.' . $img->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/sliders/' . $filename);


        $filename_prefix = $img->getClientOriginalExtension() === 'mp4' ? 'VID_S_' : 'IMG_S_';
        $filename = $filename_prefix . time() . '_' . rand(1, 9999) . '.' . $img->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/sliders/' . $filename);

        if ($img->getClientOriginalExtension() === 'mp4') {
            $img->move(storage_path('app/public/uploads/sliders/'), $filename);
        } else {
            Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
        }

        $data['img']   = $filename;

        Slider::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.sliders.index');
    }

    public function show($id)
    {
        $slider = Slider::whereId($id)->first();
        if($slider) {
            return view('dashboard.sliders.show', compact('slider'));
        }
        return redirect()->route('dashboard.sliders.index');
    }

    public function edit($id)
    {
        $slider = Slider::whereId($id)->first();
        if($slider) {
            $services = Service::orderBy('id', 'DESC')->active()->pluck('title', 'id');
            return view('dashboard.sliders.edit', compact('slider', 'services'));
        }
        return redirect()->route('dashboard.sliders.index');
    }

    public function update(SliderRequest $request, $id)
    {
        $slider = Slider::whereId($id)->first();
        if($slider) {
            $data   = $request->validated();

            if ($img = $request->file('img')) {
                Storage::disk('public')->delete('/sliders/' . $slider->img);

                $filename_prefix = $img->getClientOriginalExtension() === 'mp4' ? 'VID_S_' : 'IMG_S_';
                $filename = $filename_prefix . time() . '_' . rand(1, 9999) . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/sliders/' . $filename);

                if ($img->getClientOriginalExtension() === 'mp4') {
                    $img->move(storage_path('app/public/uploads/sliders/'), $filename);
                } else {
                    Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);
                }
                $data['img']   = $filename;

            }

            $slider->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.sliders.index');
        }
        return redirect()->route('dashboard.sliders.index');
    }

    public function destroy($id)
    {
        $slider = Slider::whereId($id)->first();
        if($slider) {
            Storage::disk('public')->delete('/sliders/' . $slider->img);
            $slider->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.sliders.index');
        }
        return redirect()->route('dashboard.sliders.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $sliders = Slider::select('id', 'img')->whereIn('id', $ids)->get();
        if ($sliders) {
            foreach ($sliders as $slider) {
                Storage::disk('public')->delete('/sliders/' . $slider->img);
                $slider->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.sliders.index');
    }
}
