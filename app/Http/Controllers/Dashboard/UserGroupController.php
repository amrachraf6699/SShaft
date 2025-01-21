<?php

namespace App\Http\Controllers\Dashboard;

use App\Role;
use App\UserGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RoleRequest;
use App\Http\Requests\Dashboard\UserGroupRequest;

class UserGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only(['index', 'show']);
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        // $groups = Role::query();

        $groups = Role::whereNotIn('name', ['super_admin', 'admin'])->withCount(['users']);

        if ($keyword != null) {
            $groups = $groups->search($keyword);
        }

        $groups = $groups->orderBy($sort_by, $order_by);
        $groups = $groups->paginate($limit_by);
        return view('dashboard.groups.index', compact('groups'));
    }

    public function create()
    {
        return view('dashboard.groups.create');
    }

    public function store(RoleRequest $request)
    {
        // Role::create($data);
        $role = Role::create($request->only(['name']));
        $role->attachPermissions($request->permissions);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.user-groups.index');
    }

    public function edit($id)
    {
        $group = Role::whereId($id)->first();
        if($group) {
            return view('dashboard.groups.edit', compact('group'));
        }
        return redirect()->route('dashboard.user-groups.index');
    }

    public function update(RoleRequest $request, $id)
    {
        $group = Role::whereId($id)->first();
        if($group) {
            $request->validated();
            $group->update($request->only(['name']));
            $group->syncPermissions($request->permissions);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.user-groups.index');
        }
        return redirect()->route('dashboard.user-groups.index');
    }

    public function destroy($id)
    {
        $group = Role::whereId($id)->first();
        if($group) {
            $group->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.user-groups.index');
        }
        return redirect()->route('dashboard.user-groups.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $groups = Role::select('id')->whereIn('id', $ids);
        if ($groups) {
            $groups->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.user-groups.index');
    }
}
