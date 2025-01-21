<?php

namespace App\Http\Controllers\Dashboard;

use App\Donor;
use App\Beneficiary;
use App\Neighborhood;
use App\ServiceSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BeneficiaryResource;
use App\Http\Requests\Dashboard\BeneficiaryRequest;

class BeneficiariesRequestController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:read_beneficiaries_requests'])->only(['index', 'show']);
    //     $this->middleware(['permission:create_beneficiaries_requests'])->only('create');
    //     $this->middleware(['permission:update_beneficiaries_requests'])->only('edit');
    //     $this->middleware(['permission:delete_beneficiaries_requests'])->only(['destroy', 'multiDelete']);
    // }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $beneficiaries_requests = Beneficiary::query();

        if ($keyword != null) {
            $beneficiaries_requests = $beneficiaries_requests->search($keyword);
        }

        $beneficiaries_requests = $beneficiaries_requests->orderBy($sort_by, $order_by);
        $beneficiaries_requests = $beneficiaries_requests->paginate($limit_by);
        return view('dashboard.beneficiaries-requests.index', compact('beneficiaries_requests'));
    }

    public function create()
    {
        $sections       = ServiceSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
        $neighborhoods  = Neighborhood::orderBy('id', 'DESC')->active()->pluck('name', 'id');
        return view('dashboard.beneficiaries-requests.create', compact('sections', 'neighborhoods'));
    }

    public function store(BeneficiaryRequest $request)
    {
        $data = $request->validated();
        // ident_img
        if ($ident_img  = $request->file('ident_img')) {
            $idFilename   = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $ident_img->getClientOriginalExtension();
            $path       = storage_path('app/public/uploads/beneficiaries_requests/' . $idFilename);
            Image::make($ident_img->getRealPath())->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $data['ident_img'] = $idFilename;
        }

        // beneficiaries_request image
        if ($img  = $request->file('img')) {
            $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
            $path           = storage_path('app/public/uploads/beneficiaries_requests/' . $filename);
            Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $data['img'] = $filename;
        }

        // app icon
        if ($app_icon  = $request->file('app_icon')) {
            $iconName       = 'ICON_' . time() . '_' . rand(1, 999999) . '.' . $app_icon->getClientOriginalExtension();
            $path           = storage_path('app/public/uploads/beneficiaries_requests/' . $iconName);
            Image::make($app_icon->getRealPath())->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $data['app_icon'] = $iconName;
        }
        Beneficiary::create($data);

        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.beneficiaries-requests.index');
    }

    public function edit($id)
    {
        $beneficiaries_request = Beneficiary::whereId($id)->first();
        if($beneficiaries_request) {
            $sections = ServiceSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
            return view('dashboard.beneficiaries-requests.edit', compact('beneficiaries_request', 'sections'));
        }
        return redirect()->route('dashboard.beneficiaries-requests.index');
    }

    public function update(BeneficiaryRequest $request, $id)
    {
        $beneficiaries_request = Beneficiary::whereId($id)->first();
        if($beneficiaries_request) {
            $data = $request->validated();
            // beneficiaries_request image
            if ($img  = $request->file('img')) {
                Storage::disk('public')->delete('/beneficiaries_requests/' . $beneficiaries_request->img);
                $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/beneficiaries_requests/' . $filename);
                Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img'] = $filename;
            }

            // app icon
            if ($app_icon  = $request->file('app_icon')) {
                Storage::disk('public')->delete('/beneficiaries_requests/' . $beneficiaries_request->app_icon);
                $iconName       = 'ICON_' . time() . '_' . rand(1, 999999) . '.' . $app_icon->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/beneficiaries_requests/' . $iconName);
                Image::make($app_icon->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['app_icon'] = $iconName;
            }
            $beneficiaries_request->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.beneficiaries-requests.index');
        }
        return redirect()->route('dashboard.beneficiaries-requests.index');
    }

    public function destroy($id)
    {
        $beneficiaries_request = Beneficiary::whereId($id)->first();
        if ($beneficiaries_request) {
            Storage::disk('public')->delete('/beneficiaries_requests/' . $beneficiaries_request->img);
            $beneficiaries_request->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.beneficiaries-requests.index');
        }
        return redirect()->route('dashboard.beneficiaries-requests.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $beneficiaries_requests = Beneficiary::select('id', 'ident_img')->whereIn('id', $ids)->get();
        if ($beneficiaries_requests) {
            foreach ($beneficiaries_requests as $beneficiaries_request) {
                Storage::disk('public')->delete('/beneficiaries_requests/' . $beneficiaries_request->ident_img);
                $beneficiaries_request->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.beneficiaries-requests.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $beneficiaries_request = Beneficiary::whereId($id)->first();
        if($beneficiaries_request) {
            $data = $request->validate([
                'status'    =>  'required|in:active,inactive,pending',
            ]);

            $beneficiaries_request->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.beneficiaries-requests.index');
    }

    public function storeAppNotificationBeneficiary($id)
    {
        $beneficiary = Beneficiary::whereId($id)->first();

        $firebaseToken = Donor::whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $SERVER_API_KEY = 'AAAAtMzPe1o:APA91bHQGR45peyghQri3IiWTxVxt-lAN4tfYZMgaZ5QlkAs03BOSmxbpO3fDlssteeDkcqtn_nWe6ECGoODVdlAhNhyJauBfrAQcfXu-7_dvysaM-Jr8t2pYgvP0D4WjuZ5_2-OVCMw';

        $data = [
            // "registration_ids" => $firebaseToken,
            "to"            => "/topics/donors",
            "notification" => [
                "title"         =>  'تم إضافة حالة جديدة للحالات الواردة',
                "body"          =>  new BeneficiaryResource($beneficiary),
                "beneficiary"   =>  true,
            ]
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);

        // dd($response);
        session()->flash('success', __('dashboard.updated_successfully'));
        return redirect()->back();
    }
}
