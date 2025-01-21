<?php

namespace App\Http\Controllers\Dashboard;

use App\Video;
use App\VideoSection;
use Illuminate\Http\Request;
use App\Jobs\SendEmailsToUsers​;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\VideoRequest;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_videos'])->only(['index', 'show']);
        $this->middleware(['permission:create_videos'])->only('create');
        $this->middleware(['permission:update_videos'])->only('edit');
        $this->middleware(['permission:delete_videos'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $videos = Video::query()->with('video_section:id,title');

        if ($keyword != null) {
            $videos = $videos->search($keyword);
        }

        $videos = $videos->orderBy($sort_by, $order_by);
        $videos = $videos->paginate($limit_by);
        return view('dashboard.videos.index', compact('videos'));
    }

    public function create()
    {
        $sections = VideoSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
        return view('dashboard.videos.create', compact('sections'));
    }

    public function store(VideoRequest $request)
    {
        $data = $request->validated();
        $data = Video::create($data);
        dispatch(new SendEmailsToUsers​($data));
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.videos.index');
    }

    public function edit($id)
    {
        $video = Video::whereId($id)->first();
        if($video) {
            $sections = VideoSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
            return view('dashboard.videos.edit', compact('video', 'sections'));
        }
        return redirect()->route('dashboard.videos.index');
    }

    public function update(VideoRequest $request, $id)
    {
        $video = Video::whereId($id)->first();
        if($video) {
            $data = $request->validated();
            $video->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.videos.index');
        }
        return redirect()->route('dashboard.videos.index');
    }

    public function destroy($id)
    {
        $video = Video::whereId($id)->first();
        if($video) {
            $video->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.videos.index');
        }
        return redirect()->route('dashboard.videos.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $videos = Video::select('id')->whereIn('id', $ids);
        if ($videos) {
            $videos->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.videos.index');
    }
}
