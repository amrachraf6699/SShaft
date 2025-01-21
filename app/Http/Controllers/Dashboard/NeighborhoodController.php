<?php

namespace App\Http\Controllers\Dashboard;

use App\Neighborhood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\NeighborhoodRequest;

class NeighborhoodController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_neighborhoods'])->only(['index', 'show']);
        $this->middleware(['permission:create_neighborhoods'])->only('create');
        $this->middleware(['permission:update_neighborhoods'])->only('edit');
        $this->middleware(['permission:delete_neighborhoods'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $neighborhoods = Neighborhood::query();

        if ($keyword != null) {
            $neighborhoods = $neighborhoods->search($keyword);
        }

        $neighborhoods = $neighborhoods->orderBy($sort_by, $order_by);
        $neighborhoods = $neighborhoods->paginate($limit_by);
        return view('dashboard.neighborhoods.index', compact('neighborhoods'));
    }

    public function create()
    {
        return view('dashboard.neighborhoods.create');
    }

    public function store(NeighborhoodRequest $request)
    {
        $data = $request->validated();
        Neighborhood::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.neighborhoods.index');
    }

    public function edit($id)
    {
        $neighborhood = Neighborhood::whereId($id)->first();
        if($neighborhood) {
            return view('dashboard.neighborhoods.edit', compact('neighborhood'));
        }
        return redirect()->route('dashboard.neighborhoods.index');
    }

    public function update(NeighborhoodRequest $request, $id)
    {
        $neighborhood = Neighborhood::whereId($id)->first();
        if($neighborhood) {
            $data = $request->validated();
            $neighborhood->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.neighborhoods.index');
        }
        return redirect()->route('dashboard.neighborhoods.index');
    }

    public function destroy($id)
    {
        $neighborhood = Neighborhood::whereId($id)->first();
        if($neighborhood) {
            $neighborhood->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.neighborhoods.index');
        }
        return redirect()->route('dashboard.neighborhoods.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $neighborhoods = Neighborhood::select('id')->whereIn('id', $ids);
        if ($neighborhoods) {
            $neighborhoods->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.neighborhoods.index');
    }
}
