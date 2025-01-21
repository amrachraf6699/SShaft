<?php

namespace App\Http\Controllers\Dashboard;

use App\Review;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:read_reviews'])->only(['index', 'show']);
    //     $this->middleware(['permission:create_reviews'])->only('create');
    //     $this->middleware(['permission:update_reviews'])->only('edit');
    //     $this->middleware(['permission:delete_reviews'])->only(['destroy', 'multiDelete']);
    // }

     public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';
        $service_id     = (isset(\request()->service_id) && \request()->service_id != '') ? \request()->service_id : null;

        $reviews = Review::query()->with('donation');

        if ($keyword != null) {
            $reviews = $reviews->search($keyword);
        }

        if ($service_id != null) {
            $reviews = $reviews->whereHas('donation', function($query) {
                $query;
            });
        }

        $reviews = $reviews->orderBy($sort_by, $order_by);
        $reviews = $reviews->paginate($limit_by);
    
        $services = Service::orderBy('id', 'DESC')->active()->pluck('title', 'id');

        return view('dashboard.reviews.index', compact('reviews', 'services'));
    }

    public function destroy($id)
    {
        $review = Review::whereId($id)->first();
        if ($review) {
            Storage::disk('public')->delete('/beneficiaries/' . $review->img);
            $review->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.reviews.index');
        }
        return redirect()->route('dashboard.reviews.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $reviews = Review::select('id', 'ident_img')->whereIn('id', $ids)->get();
        if ($reviews) {
            foreach ($reviews as $review) {
                Storage::disk('public')->delete('/beneficiaries/' . $review->ident_img);
                $review->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.reviews.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $review = Review::whereId($id)->first();
        if($review) {
            $data = $request->validate([
                'status'    =>  'required|in:active,inactive,pending',
            ]);

            $review->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.reviews.index');
    }
}
