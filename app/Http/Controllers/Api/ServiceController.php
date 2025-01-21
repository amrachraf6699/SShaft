<?php

namespace App\Http\Controllers\Api;

use App\Service;
use App\Beneficiary;
use App\ServiceSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\BeneficiaryResource;

class ServiceController extends Controller
{
    public function servicesSections()
    {
        $sections = ServiceSection::query()->whereNull('parent_id')->orderBy('id', 'ASC')->active()->get();
        if ($sections->count() > 0) {
            return response()->api(SectionResource::collection($sections), 200);
            // $result = ServiceSection::with('services')->get();
            // return response()->json($result);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    public function servicesOfSection($section)
    {
        $section    = ServiceSection::whereId($section)->first();
        if ($section && $section->status == 'active') {
            if (request()->collection == 'pagination') {
                $services   = Service::query()->with('service_section')->whereServiceSectionId($section->id)->orderBy('id', 'DESC')->active()->paginate(9);
                if ($services->count() > 0) {
                    $data['services']   = ServiceResource::collection($services)->response()->getData(true);
                    return response()->api($data, 200);
                }
                return response()->api(null, 200, false, __('api.not found data'));
            } else {
                $services   = Service::query()->with('service_section')->whereServiceSectionId($section->id)->orderBy('id', 'DESC')->active()->get();
                if ($services->count() > 0) {
                    return response()->api(ServiceResource::collection($services), 200);
                }
                return response()->api(null, 200, false, __('api.not found data'));
            }
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    public function serviceDetails($section, $service)
    {
        $section    = ServiceSection::whereId($section)->first();
        $service    = Service::whereId($service)->active()->first();

        if ($section && $section->status == 'active' && $service) {
            return response()->api(new ServiceResource($service), 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    public function beneficiariesOfSection($section)
    {
        $section    = ServiceSection::whereId($section)->first();
        if ($section && $section->status == 'active') {
            if (request()->collection == 'pagination') {
                $beneficiaries   = Beneficiary::query()->with('service_section')->whereServiceSectionId($section->id)->orderBy('id', 'DESC')->active()->paginate(9);
                if ($beneficiaries->count() > 0) {
                    $data['beneficiaries']   = BeneficiaryResource::collection($beneficiaries)->response()->getData(true);
                    return response()->api($data, 200);
                }
                return response()->api(null, 200, false, __('api.not found data'));
            } else {
                $beneficiaries   = Beneficiary::query()->with('service_section')->whereServiceSectionId($section->id)->orderBy('id', 'DESC')->active()->get();
                if ($beneficiaries->count() > 0) {
                    return response()->api(BeneficiaryResource::collection($beneficiaries), 200);
                }
                return response()->api(null, 200, false, __('api.not found data'));
            }
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }
}
