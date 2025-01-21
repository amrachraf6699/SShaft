<?php

namespace App\Http\Controllers\Dashboard;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\EventRequest;

class EventController extends Controller
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

        $events = Event::query();

        if ($keyword != null) {
            $events = $events->search($keyword);
        }

        $events = $events->orderBy($sort_by, $order_by);
        $events = $events->paginate($limit_by);
        return view('dashboard.events.index', compact('events'));
    }

    public function create()
    {
        return view('dashboard.events.create');
    }

    public function store(EventRequest $request)
    {
        $data = $request->validated();
        // image
        $img    = $request->file('img');
        $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/events/' . $filename);
        Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);
        $data['img'] = $filename;

        Event::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.events.index');
    }

    public function edit($id)
    {
        $event = Event::whereId($id)->first();
        if($event) {
            return view('dashboard.events.edit', compact('event'));
        }
        return redirect()->route('dashboard.events.index');
    }

    public function update(EventRequest $request, $id)
    {
        $event = Event::whereId($id)->first();
        if($event) {
            $data = $request->validated();
            // event image
            if ($img  = $request->file('img')) {
                Storage::disk('public')->delete('/events/' . $event->img);
                $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/events/' . $filename);
                Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img'] = $filename;
            }

            $event->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.events.index');
        }
        return redirect()->route('dashboard.events.index');
    }

    public function destroy($id)
    {
        $event = Event::whereId($id)->first();
        if($event) {
            Storage::disk('public')->delete('/events/' . $event->img);
            $event->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.events.index');
        }
        return redirect()->route('dashboard.events.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $events = Event::select('id', 'img')->whereIn('id', $ids)->get();
        if ($events) {
            foreach ($events as $event) {
                Storage::disk('public')->delete('/events/' . $event->img);
                $event->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.events.index');
    }
}
