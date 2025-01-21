<?php

use App\Service;
use App\Setting;
use App\Donation;
use App\ModuleSection;
use App\ServiceSection;
use App\DonationService;
use App\GeneralAssemblyMember;

// Active item navbar (website)
if (!function_exists('is_active'))
{
    function is_active(string $routeName)
    {
        return null !== request()->segment(1) && request()->segment(1) == $routeName ? 'active' : '';
    }
}

if (!function_exists('is_active_nav'))
{
    function is_active_nav(string $routeName)
    {
        return null !== request()->segment(1) && request()->segment(1) == $routeName ? 'current' : '';
    }
}

// Settings
if (!function_exists('setting'))
{
    function setting()
    {
        return Setting::orderBy('id', 'DESC')->first();
    }
}

// Get Youtub ID
if (!function_exists('get_youtube_id'))
{
    function get_youtube_id($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return isset($match[1]) ? $match[1] : null;
    }
}

// Get sections (website)
if (!function_exists('gitServiceSections'))
{
    function gitServiceSections()
    {
        return ServiceSection::query()
                        ->select('id', 'slug', 'title', 'status')
                        ->orderBy('id', 'DESC')->active()->get();
    }
}

// Get modules (website)
if (!function_exists('gitModules'))
{
    function gitModules()
    {
        return ModuleSection::query()
                        ->select('id', 'slug', 'title', 'status')
                        ->orderBy('id', 'DESC')->active()->get();
    }
}

// quick donation side bar (website)
if (!function_exists('quickDonationSideBar'))
{
    function quickDonationSideBar()
    {
        return Service::query()->with('service_section:id,title,slug,status')
                        ->whereHas('service_section', function($q) {
                            $q->active();
                        })
                        ->where('price_value', '!=', 'fixed')
                        ->where('price_value', '!=', 'percent')
                        ->quick_donation()->active()->inRandomOrder()->limit(2)->get();
    }
}

// Verified General Assembly Member
if (!function_exists('verifiedGeneralAssemblyMember'))
{
    function verifiedGeneralAssemblyMember($phone)
    {
        $member = GeneralAssemblyMember::wherePhone($phone)->active()->first();
        if ($member) {
            return $member;
        }
    }
}

// Total Donations Received From Marketer
if (!function_exists('totalDonationsReceived'))
{
    function totalDonationsReceived($id)
    {
        return Donation::query()->select('total_amount')->whereMarketerId($id)
                            ->marketer()->get()->sum('total_amount');
    }
}

// Get donations services (title)
if (!function_exists('donations_title_services'))
{
    function donations_title_services($id)
    {
        $services   = DonationService::where('donation_id', $id)->with('service')->get();
        $ser_list   = [];

        for ($i = 0; $i < count($services); $i++) {
            if (count($services) > 1) {
                $ser_list[$i] = $services[$i]->service->title . '(' . $services[$i]->amount . ')';
            } else {
                $ser_list[$i] = $services[$i]->service->title;
            }
        }
        $titles = implode(' - ', $ser_list);
        return $titles;
    }
}


