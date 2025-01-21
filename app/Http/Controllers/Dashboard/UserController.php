<?php

namespace App\Http\Controllers\Dashboard;

use App\Role;
use App\User;
use App\UserGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;

class UserController extends Controller
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
        $user_status    = (isset(\request()->user_status) && \request()->user_status != '') ? \request()->user_status : null;
        $user_group_id  = (isset(\request()->user_group_id) && \request()->user_group_id != '') ? \request()->user_group_id : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $self  =   auth()->user()->id;
        $users = auth()->user()->hasRole('super_admin')
                    ? User::query()->whereRoleIs('admin')
                    : User::query()->whereRoleIs('admin')->where('id', '!=', $self);

        if ($keyword != null) {
            $users = $users->search($keyword);
        }

        if ($user_status != null) {
            $users = $users->whereUserStatus($user_status);
        }

        $users = $users->orderBy($sort_by, $order_by);
        $users = $users->paginate($limit_by);

        $groups = UserGroup::orderBy('id', 'DESC')->withCount('users')->get();
        return view('dashboard.users.index', compact('users', 'groups'));
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', ['super_admin', 'admin'])->get();
        return view('dashboard.users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data = $request->except(['password']);
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);

        $user->attachRoles(['admin', $request->role_id]);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }

    public function show($id)
    {
        $user   = auth()->user()->hasRole('super_admin')
                ? User::with('permissions')->whereId($id)->first()
                : User::with('permissions')->whereRoleIs('admin')->whereId($id)->first();
        if ($user) {
            return view('dashboard.users.show', compact('user'));
        }
        return redirect()->route('dashboard.users.index');
    }

    public function edit($id)
    {
        $user   = auth()->user()->hasRole('super_admin')
                ? User::with('permissions')->whereId($id)->first()
                : User::with('permissions')->whereRoleIs('admin')->whereId($id)->first();
        if ($user) {
            $roles = Role::whereNotIn('name', ['super_admin', 'admin'])->get();
            return view('dashboard.users.edit', compact('user', 'roles'));
        }
        return redirect()->route('dashboard.users.index');
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::whereId($id)->first();
        if ($user) {
            $data = $request->validated();
            $data = $request->except(['password']);
            if (trim($request->password) != '') {
                $data['password'] = bcrypt($request->password);
            }
            $user->update($data);
            $user->syncRoles(['admin', $request->role_id]);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.users.index');
        }
        return redirect()->route('dashboard.users.index');
    }

    public function destroy($id)
    {
        $user = User::whereId($id)->first();
        if ($user) {
            $user->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.users.index');
        }
        return redirect()->route('dashboard.users.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $users = User::select('id')->whereIn('id', $ids);
        if ($users) {
            $users->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.users.index');
        }
        return redirect()->route('dashboard.users.index');
    }

    public function changeStatus($id)
    {
        $user = User::whereId($id)->first();
        if ($user) {
            $user->user_status = $user->user_status == 'active' ? 'inactive' : 'active';
            $user->save();
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.users.index');
    }
}
