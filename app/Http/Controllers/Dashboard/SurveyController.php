<?php

namespace App\Http\Controllers\Dashboard;

use App\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SurveyRequest;

class SurveyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_surveys'])->only(['index', 'show']);
        $this->middleware(['permission:create_surveys'])->only('create');
        $this->middleware(['permission:update_surveys'])->only('edit');
        $this->middleware(['permission:delete_surveys'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $surveys = Survey::query();

        if ($keyword != null) {
            $surveys = $surveys->search($keyword);
        }

        $surveys = $surveys->orderBy($sort_by, $order_by);
        $surveys = $surveys->paginate($limit_by);
        return view('dashboard.surveys.index', compact('surveys'));
    }

    public function create()
    {
        return view('dashboard.surveys.create');
    }

    public function store(SurveyRequest $request)
    {
        $data = $request->validated();
        Survey::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.surveys.index');
    }

    public function edit($id)
    {
        $survey = Survey::whereId($id)->first();
        if($survey) {
            return view('dashboard.surveys.edit', compact('survey'));
        }
        return redirect()->route('dashboard.surveys.index');
    }

    public function update(SurveyRequest $request, $id)
    {
        $survey = Survey::whereId($id)->first();
        if($survey) {
            $data = $request->validated();
            $survey->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.surveys.index');
        }
        return redirect()->route('dashboard.surveys.index');
    }

    public function destroy($id)
    {
        $survey = Survey::whereId($id)->first();
        if($survey) {
            $survey->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.surveys.index');
        }
        return redirect()->route('dashboard.surveys.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $surveys = Survey::select('id')->whereIn('id', $ids);
        if ($surveys) {
            $surveys->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.surveys.index');
    }
}
