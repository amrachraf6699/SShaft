<?php

namespace App\Http\Controllers\Dashboard;

use App\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BranchRequest;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_branches'])->only(['index', 'show']);
        $this->middleware(['permission:create_branches'])->only('create');
        $this->middleware(['permission:update_branches'])->only('edit');
        $this->middleware(['permission:delete_branches'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $branches = Branch::query();

        if ($keyword != null) {
            $branches = $branches->search($keyword);
        }

        $branches = $branches->orderBy($sort_by, $order_by);
        $branches = $branches->paginate($limit_by);
        return view('dashboard.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('dashboard.branches.create');
    }

    public function store(BranchRequest $request)
    {
        $data = $request->validated();
        Branch::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.branches.index');
    }

    public function edit($id)
    {
        $branch = Branch::whereId($id)->first();
        if($branch) {
            return view('dashboard.branches.edit', compact('branch'));
        }
        return redirect()->route('dashboard.branches.index');
    }

    public function update(BranchRequest $request, $id)
    {
        $branch = Branch::whereId($id)->first();
        if($branch) {
            $data = $request->validated();
            $branch->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.branches.index');
        }
        return redirect()->route('dashboard.branches.index');
    }

    public function destroy($id)
    {
        $branch = Branch::whereId($id)->first();
        if($branch) {
            $branch->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.branches.index');
        }
        return redirect()->route('dashboard.branches.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $branches = Branch::select('id')->whereIn('id', $ids);
        if ($branches) {
            $branches->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.branches.index');
    }
}
