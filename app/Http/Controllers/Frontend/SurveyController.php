<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function viewSurvey()
    {
        $pageTitle  = __('translation.surveys');
        $surveys    = Survey::query()->orderBy('id', 'DESC')->active()->paginate(9);
        return view('frontend.pages.survey', compact('pageTitle', 'surveys'));
    }

    public function incrementVote(Request $request, $survey)
    {
        $survey = Survey::orderBy('id', 'DESC')->whereId($survey)->active()->first();
        if($survey) {
            $data = $request->validate([
                'vote_status'    =>  'required|in:very_satisfied,somewhat_satisfied,neutral,not_satisfied,angry',
            ]);

            if ($data['vote_status'] === 'very_satisfied')
            {
                $survey->update([$survey->very_satisfied = $survey->very_satisfied + 1]);
            }
            elseif($data['vote_status'] === 'somewhat_satisfied')
            {
                $survey->update([$survey->somewhat_satisfied = $survey->somewhat_satisfied + 1]);
            }
            elseif($data['vote_status'] === 'neutral')
            {
                $survey->update([$survey->neutral = $survey->neutral + 1]);
            }
            elseif($data['vote_status'] === 'not_satisfied')
            {
                $survey->update([$survey->not_satisfied = $survey->not_satisfied + 1]);
            }
            elseif($data['vote_status'] === 'angry')
            {
                $survey->update([$survey->angry = $survey->angry + 1]);
            }

            session()->flash('sessionSuccess', 'تم التصويت بنجاح، نشكر وقتكم الثمين');
            return redirect()->back();
        }
        return redirect()->back();
    }
}
