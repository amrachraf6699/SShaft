<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Page;
use App\Event;
use App\SeasonalProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SeasonalProjectResource;
use App\Review;

class GeneralController extends Controller
{
    /**
     * Donor Statistics
     */
    public function DonorStatistics()
    {
        $cartCount = auth()->user()->carts()->count();

        $cartTotal = Cart::whereDonorId(auth()->user()->id)->select(
                            DB::raw('quantity * amount as total_amount')
                        )->get()->sum('total_amount');
        $countNot  = auth()->user()->unreadNotifications->count();

        return response()->api([
            'cart_count' => $cartCount,
            'cart_total' => $cartTotal,
            'notifications_count' => $countNot,
        ], 200);
    }

    /**
     * Events
     */
    public function events()
    {
        $events = Event::query()->active()->orderBy('id', 'DESC')->paginate(12);
        if ($events->count() > 0) {
            $data['events']   = EventResource::collection($events)->response()->getData(true);
            return response()->api($data, 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * Seasonal projects
     */
    public function seasonalProjects()
    {
        $projects = SeasonalProject::query()->active()->orderBy('id', 'DESC')->paginate(12);
        if ($projects->count() > 0) {
            $data['projects']   = SeasonalProjectResource::collection($projects)->response()->getData(true);
            return response()->api($data, 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * Seasonal statistics
     */
    public function associationStatistics()
    {
        $statistics  = Page::where('key', 'statistics')->first();
        if ($statistics->value) {
            return response()->api(['statistics' => $statistics->value], 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * Payment True Or False
     */
    public function paymentTrueOrFalse()
    {
        $payment_s = true;
        return response()->api(['payment_s' => $payment_s], 200);
    }

    /**
     * Store Reviews
     */
    public function storeReviews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating'        =>  'required|numeric|in:1,2,3,4,5',
            'review'        =>  'sometimes|nullable|string|min:4',
            'donation_id'   =>  'required|exists:donations,id|integer',
        ]);

        if ($validator->fails()) {
            return response()->api(null, 200, true, $validator->errors()->first());
        }

        if (! Review::whereDonationId($request->donation_id)->exists()) {
            $review = Review::create([
                'rating'        => $request->rating,
                'review'        => $request->review,
                'donation_id'   => $request->donation_id,
                'status'        => 'active',
            ]);

            return response()->api([
                                'rating'        => $review->rating,
                                'review'        => $review->review,
                                'donation_id'   => $review->donation_id,
                            ], 200, false, __('api.Added Successfully'));
        }

        return response()->api(null, 200, false, 'تم تقييم تجربتك سابقاَ.');

    }
}
