<?php

namespace App\Http\Controllers\Dashboard;

use App\Gift;
use App\Note;
use App\User;
use App\Donor;
use App\Contact;
use App\Service;
use App\Donation;
use App\ServiceSection;
use Illuminate\Http\Request;
use App\GeneralAssemblyMember;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {


        $count_general_assembly_members = GeneralAssemblyMember::count();
        $count_donors                   = Donor::count();
        $count_services                 = Service::count();
        $count_gifts                    = Gift::count();
        $count_donations                = Donation::count();
        $count_contacts                 = Contact::count();

        $categories_chart               = ServiceSection::query()
                                            ->select(['service_sections.id', 'service_sections.title'])
                                            ->withCount('services')->groupBy('title')->get();

        $donations_data                 = Donation::query()->select(
                                                DB::raw('YEAR(created_at) AS year'),
                                                DB::raw('MONTH(created_at) AS month'),
                                                DB::raw('COUNT(*) AS total')
                                            )->groupBy('year')->get();

        $paid_donations                 = Donation::paid()->count();
        $unpaid_donations               = Donation::unpaid()->count();

        $donations                      = Donation::select('total_amount')->get();
        $paidDonations                  = Donation::paid()->select('total_amount')->get();
        $unpaidDonations                = Donation::unpaid()->select('total_amount')->get();
        $total_donations                = $donations->sum('total_amount');
        $total_paid_donations           = $paidDonations->sum('total_amount');
        $total_unpaid_donations         = $unpaidDonations->sum('total_amount');

        $percent_count                  = $paid_donations != 0 ? number_format(round(($paid_donations/$count_donations)*100)) : 0;

        $percent_paid_total             = $total_paid_donations != 0 ? number_format(round(($total_paid_donations/$total_donations)*100)) : 0;
        $percent_unpaid_total           = $total_unpaid_donations != 0 ? number_format(round(($total_unpaid_donations/$total_donations)*100)) : 0;

        $notes                          =  Note::query()->orderBy('id', 'DESC')->get();

        return view('dashboard.home', compact(
                    'count_general_assembly_members', 'count_donors',
                    'count_services', 'count_gifts', 'count_donations',
                    'count_contacts', 'donations_data', 'categories_chart',
                    'paid_donations', 'unpaid_donations', 'total_paid_donations',
                    'total_unpaid_donations', 'percent_count', 'percent_paid_total',
                    'percent_unpaid_total', 'notes'
                ));
    }

    public function editAdmin()
    {
        $admin = auth()->user();
        return view('dashboard.admin.edit', compact('admin'));
    }

    public function updateAdmin(Request $request)
    {
        $request->validate([
            'name'                  => 'required|min:3',
            'email'                 => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'password'              => 'nullable|same:confirm_password|min:6',
        ]);

        $data = $request->except(['_token', 'confirm_password']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }else {
            unset($data['password']);
        }

        auth()->user()->update($data);

        session()->flash('success', __('dashboard.updated_successfully'));
        return redirect()->back();
    }

    public function lang($locale)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }

    public function switchLang($lang)
    {
        $supportedLanguages = ['ar', 'en'];
        if (!in_array($lang, $supportedLanguages)) {
            $lang = 'ar';
        }

        session()->put('language', $lang);

        return redirect()->back()->with('success', __('dashboard.language_switched'));
    }
    public function generalSearch()
    {
        $keyword        = (isset(request()->keyword) && request()->keyword != '') ? request()->keyword : null;
        $service_id     = (isset(\request()->service_id) && \request()->service_id != '') ? \request()->service_id : null;
        $payment_ways   = (isset(\request()->payment_ways) && \request()->payment_ways != '') ? \request()->payment_ways : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $donations  = Donation::query()->withCount('services')->with('donor:id,membership_no');

        if ($keyword != null) {
            $donations = $donations->search($keyword);
        }

        $donations = $donations->orderBy($sort_by, $order_by);
        $donations = $donations->paginate($limit_by);

        $services = Service::orderBy('id', 'DESC')->pluck('title', 'id');
        return view('dashboard.research-results', compact('donations', 'services'));
    }

    public function indexAppNotifications()
    {
        return view('dashboard.app-notifications');
    }

    public function storeAppNotifications(Request $request)
    {

        $firebaseToken = Donor::whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $SERVER_API_KEY = 'AAAAtMzPe1o:APA91bHQGR45peyghQri3IiWTxVxt-lAN4tfYZMgaZ5QlkAs03BOSmxbpO3fDlssteeDkcqtn_nWe6ECGoODVdlAhNhyJauBfrAQcfXu-7_dvysaM-Jr8t2pYgvP0D4WjuZ5_2-OVCMw';

        $data = [
            "to" => "/topics/donors",
            "notification" => [
                "title"         => strip_tags($request->title),
                "body"          => strip_tags($request->content),
                "beneficiary"   =>  false,
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
