<?php

namespace App\Http\Controllers\Dashboard;

use App\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AccountRequest;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_accounts'])->only(['index', 'show']);
        $this->middleware(['permission:create_accounts'])->only('create');
        $this->middleware(['permission:update_accounts'])->only('edit');
        $this->middleware(['permission:delete_accounts'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $accounts = Account::query();

        if ($keyword != null) {
            $accounts = $accounts->search($keyword);
        }

        $accounts = $accounts->orderBy($sort_by, $order_by);
        $accounts = $accounts->paginate($limit_by);
        return view('dashboard.accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('dashboard.accounts.create');
    }

    public function store(AccountRequest $request)
    {
        $data = $request->validated();
        Account::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.accounts.index');
    }

    public function edit($id)
    {
        $account = Account::whereId($id)->first();
        if($account) {
            return view('dashboard.accounts.edit', compact('account'));
        }
        return redirect()->route('dashboard.accounts.index');
    }

    public function update(AccountRequest $request, $id)
    {
        $account = Account::whereId($id)->first();
        if($account) {
            $data = $request->validated();
            $account->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.accounts.index');
        }
        return redirect()->route('dashboard.accounts.index');
    }

    public function destroy($id)
    {
        $account = Account::whereId($id)->first();
        if($account) {
            $account->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.accounts.index');
        }
        return redirect()->route('dashboard.accounts.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $accounts = Account::select('id')->whereIn('id', $ids);
        if ($accounts) {
            $accounts->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.accounts.index');
    }
}
