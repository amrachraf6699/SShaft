<?php

namespace App\Http\Controllers\Frontend;

use App\EmploymentApplication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\EmploymentApplicationRequest;

class EmploymentApplicationController extends Controller
{
    public function index()
    {
        $pageTitle  =   __('translation.employment_application');
        return view('frontend.pages.employment-application', compact('pageTitle'));
    }

    public function store(EmploymentApplicationRequest $request)
    {
        $data = $request->validated();
        // FILE
        if ($file  = $request->file('cv')) {
            $filename = time() . $file->hashName();
            $file->storeAs('/employment_applications/', $filename, 'public');
            $data['cv'] = $filename;
        }
        EmploymentApplication::create($data);
        session()->flash('sessionSuccess', 'تم إرسال طلبك بنجاح، وسيتم التواصل معكم في أقرب وقت ممكن!');
        return redirect()->route('frontend.employment-application.index');
    }
}
