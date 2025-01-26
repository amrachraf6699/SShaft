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

    public function updateAdvancedSettings($branch_id , Request $request)
    {
        $setting = Branch::find($branch_id);
        if ($setting) {
            // Ensure boolean values are handled explicitly
            $data = $request->all();
            $data['is_refresh'] = $request->boolean('is_refresh', false) ? 1 : 0;
            $data['pinned_mode'] = $request->boolean('pinned_mode', false) ? 1 : 0;
            $data['quick_donations'] = $request->boolean('quick_donations', false) ? 1 : 0;
            $data['nearpay']['enableReceiptUi'] = $request->boolean('nearpay.enableReceiptUi', false) ? 1 : 0;
            // Validate the rest of the request data
            $validated = $request->validate([
                'refresh_time' => 'required|integer|min:0',
                'nearpay.finishTimeout' => 'required|integer|min:0',
                'nearpay.authType' => 'required|string',
                'nearpay.authValue' => 'required|string',
                'nearpay.env' => 'required|string',
            ]);

            // Format and merge nearpay data
            $validated['nearpay'] = json_encode([
                'enableReceiptUi' => $data['nearpay']['enableReceiptUi'],
                'finishTimeout' => $validated['nearpay']['finishTimeout'],
                'authType' => $validated['nearpay']['authType'],
                'authValue' => $validated['nearpay']['authValue'],
                'env' => $validated['nearpay']['env'],
            ]);

            // Include boolean values explicitly
            $validated['is_refresh'] = $data['is_refresh'];
            $validated['pinned_mode'] = $data['pinned_mode'];
            $validated['quick_donations'] = $data['quick_donations'];

            // Update the settings
            $setting->update($validated);

            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.branches.index');
        }

        return redirect()->back()->withErrors(__('dashboard.error_updating'));
    }
}
