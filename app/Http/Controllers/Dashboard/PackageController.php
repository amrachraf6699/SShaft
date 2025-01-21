<?php

namespace App\Http\Controllers\Dashboard;

use App\GeneralAssemblyMember;
use App\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PackageRequest;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_general_assembly_members'])->only(['index', 'show']);
        $this->middleware(['permission:create_general_assembly_members'])->only('create');
        $this->middleware(['permission:update_general_assembly_members'])->only('edit');
        $this->middleware(['permission:delete_general_assembly_members'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $packages = Package::query();

        if ($keyword != null) {
            $packages = $packages->search($keyword);
        }

        $packages = $packages->orderBy($sort_by, $order_by);
        $packages = $packages->paginate($limit_by);
        return view('dashboard.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('dashboard.packages.create');
    }

    public function store(PackageRequest $request)
    {
        $data = $request->validated();

        Package::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.packages.index');
    }

    public function show($id)
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $package = Package::whereId($id)->first();

        if($package) {
            $members = GeneralAssemblyMember::query()->wherePackageId($id)->with('package:id,title');

            if ($keyword != null) {
                $members = $members->search($keyword);
            }

            $members = $members->orderBy($sort_by, $order_by);
            $members = $members->paginate($limit_by);
            return view('dashboard.general-assembly-members.index', compact('members'));
        }
        return redirect()->route('dashboard.general-assembly-members.index');
    }

    public function edit($id)
    {
        $package = Package::whereId($id)->first();
        if($package) {
            return view('dashboard.packages.edit', compact('package'));
        }
        return redirect()->route('dashboard.packages.index');
    }

    public function update(PackageRequest $request, $id)
    {
        $package = Package::whereId($id)->first();
        if($package) {
            $data = $request->validated();

            $package->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.packages.index');
        }
        return redirect()->route('dashboard.packages.index');
    }

    public function destroy($id)
    {
        $package = Package::whereId($id)->first();
        if($package) {
            $package->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.packages.index');
        }
        return redirect()->route('dashboard.packages.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $packages = Package::select('id')->whereIn('id', $ids);
        if ($packages) {
            $packages->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.packages.index');
    }
}
