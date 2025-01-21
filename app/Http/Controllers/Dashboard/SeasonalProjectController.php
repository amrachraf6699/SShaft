<?php

namespace App\Http\Controllers\Dashboard;

use App\SeasonalProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\SeasonalProjectRequest;

class SeasonalProjectController extends Controller
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

        $projects = SeasonalProject::query();

        if ($keyword != null) {
            $projects = $projects->search($keyword);
        }

        $projects = $projects->orderBy($sort_by, $order_by);
        $projects = $projects->paginate($limit_by);
        return view('dashboard.seasonal-projects.index', compact('projects'));
    }

    public function create()
    {
        return view('dashboard.seasonal-projects.create');
    }

    public function store(SeasonalProjectRequest $request)
    {
        $data = $request->validated();
        // image
        $img    = $request->file('img');
        $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/seasonal_projects/' . $filename);
        Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);
        $data['img'] = $filename;

        SeasonalProject::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.seasonal-projects.index');
    }

    public function edit($id)
    {
        $project = SeasonalProject::whereId($id)->first();
        if($project) {
            return view('dashboard.seasonal-projects.edit', compact('project'));
        }
        return redirect()->route('dashboard.seasonal-projects.index');
    }

    public function update(SeasonalProjectRequest $request, $id)
    {
        $project = SeasonalProject::whereId($id)->first();
        if($project) {
            $data = $request->validated();
            // project image
            if ($img  = $request->file('img')) {
                Storage::disk('public')->delete('/seasonal_projects/' . $project->img);
                $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/seasonal_projects/' . $filename);
                Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img'] = $filename;
            }

            $project->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.seasonal-projects.index');
        }
        return redirect()->route('dashboard.seasonal-projects.index');
    }

    public function destroy($id)
    {
        $project = SeasonalProject::whereId($id)->first();
        if($project) {
            Storage::disk('public')->delete('/seasonal_projects/' . $project->img);
            $project->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.seasonal-projects.index');
        }
        return redirect()->route('dashboard.seasonal-projects.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $projects = SeasonalProject::select('id', 'img')->whereIn('id', $ids)->get();
        if ($projects) {
            foreach ($projects as $project) {
                Storage::disk('public')->delete('/seasonal_projects/' . $project->img);
                $project->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.seasonal-projects.index');
    }
}
