<?php

namespace App\Http\Controllers\Frontend;

use App\Branch;
use App\Page;
use App\Founder;
use App\Director;
use App\Event;
use App\Government;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Module;
use App\ModuleSection;
use App\SeasonalProject;

class PageController extends Controller
{
    /*******
     *
     * ------ ABOUT THE ASSOCIATION ------
     *
    */
    public function viewBrief()
    {
        $pageTitle  =   __('translation.brief');
        $brief      = Page::where('key', 'brief')->first();
        $founders   = Founder::query()->get();
        return view('frontend.about.brief', compact('pageTitle', 'brief', 'founders'));
    }

    public function boardOfDirectors()
    {
        $pageTitle  =   __('translation.board_of_directors');
        $board_of_directors = Page::where('key', 'board_of_directors')->first();
        $directors   = Director::query()->get();
        return view('frontend.about.board-of-directors', compact('pageTitle', 'board_of_directors', 'directors'));
    }

    public function viewSeasonalProjects()
    {
        $pageTitle  =   __('translation.seasonal_projects');
        $projects   = SeasonalProject::query()->active()->paginate(9);
        return view('frontend.about.seasonal-projects', compact('pageTitle', 'projects'));
    }

    public function viewSeasonalProjectDetails($slug)
    {
        $project = SeasonalProject::whereSlug($slug)->active()->first();
        if($project) {
            $pageTitle  =   __('translation.seasonal_projects') . ' » ' . $project->title;
            return view('frontend.about.seasonal-project-details', compact('pageTitle', 'project'));
        }
        return redirect()->route('frontend.home');
    }

    public function viewEvents()
    {
        $pageTitle  =   __('translation.events');
        $events     = Event::query()->active()->paginate(9);
        return view('frontend.about.events', compact('pageTitle', 'events'));
    }

    public function viewEventDetails($slug)
    {
        $event = Event::whereSlug($slug)->active()->first();
        if($event) {
            $pageTitle  =   __('translation.events') . ' » ' . $event->title;
            return view('frontend.about.event-details', compact('pageTitle', 'event'));
        }
        return redirect()->route('frontend.home');
    }

    public function viewServicesAlbir()
    {
        $pageTitle      =   __('translation.services_albir');
        $services_albir = Page::where('key', 'services_albir')->first();
        return view('frontend.about.services-albir', compact('pageTitle', 'services_albir'));
    }

    public function viewOrganizationalChart()
    {
        $pageTitle              =   __('translation.organizational_chart');
        $organizational_chart   = Page::where('key', 'organizational_chart')->first();
        return view('frontend.about.organizational-chart', compact('pageTitle', 'organizational_chart'));
    }

    public function viewStatistics()
    {
        $pageTitle  =   __('translation.statistics');
        $statistics = Page::where('key', 'statistics')->first();
        return view('frontend.about.statistics', compact('pageTitle', 'statistics'));
    }

    public function viewModulesSection($slug)
    {
        $section    = ModuleSection::whereSlug($slug)->active()->first();
        if ($section) {
            $pageTitle  =   $section->title;
            $modules    = Module::whereModuleSectionId($section->id)->active()->paginate(9);
            return view('frontend.pages.modules-section', compact('pageTitle', 'section', 'modules'));
        }
        return redirect()->route('frontend.home');
    }

    public function viewModules($section_slug, $module_slug)
    {
        $section    = ModuleSection::whereSlug($section_slug)->active()->first();
        $module     = Module::whereModuleSectionId($section->id)->active()->first();
        if ($section && $module) {
            $pageTitle  =   $section->title . ' » ' . $module->title;
            return view('frontend.pages.module-details', compact('pageTitle', 'section', 'module'));
        }
        return redirect()->route('frontend.home');
    }

    public function viewBranches()
    {
        $pageTitle  =   __('translation.branches');
        $branches   = Branch::query()->active()->get();
        return view('frontend.pages.branches', compact('pageTitle', 'branches'));
    }

    public function viewGovernanceMaterial()
    {
        $pageTitle      =   __('translation.governance_material');
        $governments    = Government::query()->active()->paginate(9);
        return view('frontend.about.governance-material', compact('pageTitle', 'governments'));
    }

    public function viewGovernanceMaterialDetails($slug)
    {
        $government = Government::whereSlug($slug)->active()->first();
        if($government) {
            $pageTitle  =   __('translation.gove') . ' » ' . $government->title;
            return view('frontend.about.governance-material-details', compact('pageTitle', 'government'));
        }
        return redirect()->route('frontend.home');
    }
    
    public function inauguration()
    {
        return view('frontend.inauguration');
    }
}
