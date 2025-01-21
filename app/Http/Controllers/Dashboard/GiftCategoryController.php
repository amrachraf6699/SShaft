<?php

namespace App\Http\Controllers\Dashboard;

use App\GiftCard;
use App\GiftCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Dashboard\GiftCategoryRequest;

class GiftCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_gifts'])->only(['index', 'show']);
        $this->middleware(['permission:create_gifts'])->only('create');
        $this->middleware(['permission:update_gifts'])->only('edit');
        $this->middleware(['permission:delete_gifts'])->only(['destroy', 'multiDelete', 'removeCard']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $categories = GiftCategory::query();

        if ($keyword != null) {
            $categories = $categories->search($keyword);
        }

        $categories = $categories->orderBy($sort_by, $order_by);
        $categories = $categories->paginate($limit_by);
        return view('dashboard.gift-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.gift-categories.create');
    }

    public function store(GiftCategoryRequest $request)
    {
        $data   = $request->validated();

        try {
            DB::beginTransaction();
                $category   = GiftCategory::create($data);

                if ($request->cards && count($request->cards) > 0) {
                    $i = 1;
                    foreach ($request->cards as $file) {
                        $filename   = 'CARD_' . time() . '_' . $i . rand(1, 99999) . '.' . $file->getClientOriginalExtension();
                        $file_size  = $file->getSize();
                        $file_type  = $file->getMimeType();
                        $path       = storage_path('app/public/uploads/gift_cards/' . $filename);
                        Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path, 100);

                        $category->cards()->create([
                            'file_name' => $filename,
                            'file_size' => $file_size,
                            'file_type' => $file_type,
                        ]);
                        $i++;
                    }
                }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.gift-categories.index');
    }

    public function edit($id)
    {
        $category = GiftCategory::with(['cards'])->whereId($id)->first();
        if($category) {
            return view('dashboard.gift-categories.edit', compact('category'));
        }
        return redirect()->route('dashboard.gift-categories.index');
    }

    public function update(GiftCategoryRequest $request, $id)
    {
        $category = GiftCategory::whereId($id)->first();
        if($category) {
            $data = $request->validated();

            try {
                DB::beginTransaction();

                    $category->update($data);

                    foreach($category->cards() as $card) {
                        if (File::exists(storage_path('app/public/uploads/gift_cards/' . $card->file_name))) {
                            unlink(storage_path('app/public/uploads/gift_cards/' . $card->file_name));
                        }
                        $card->delete();
                    }

                    if ($request->cards && count($request->cards) > 0) {
                        $i = 1;
                        foreach ($request->cards as $file) {
                            $filename   = 'CARD_' . time() . '_' . $i . rand(1, 99999) . '.' . $file->getClientOriginalExtension();
                            $file_size  = $file->getSize();
                            $file_type  = $file->getMimeType();
                            $path       = storage_path('app/public/uploads/gift_cards/' . $filename);
                            Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($path, 100);

                            $category->cards()->create([
                                'file_name' => $filename,
                                'file_size' => $file_size,
                                'file_type' => $file_type,
                            ]);
                            $i++;
                        }
                    }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.gift-categories.index');
        }
        return redirect()->route('dashboard.gift-categories.index');
    }

    public function destroy($id)
    {
        $category = GiftCategory::whereId($id)->first();
        if($category) {
            if ($category->cards->count() > 0) {
                foreach ($category->cards as $card) {
                    if (File::exists(storage_path('app/public/uploads/gift_cards/' . $card->file_name))) {
                        unlink(storage_path('app/public/uploads/gift_cards/' . $card->file_name));
                    }
                }
            }
            $category->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.gift-categories.index');
        }
        return redirect()->route('dashboard.gift-categories.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $categories = GiftCategory::select('id')->whereIn('id', $ids)->get();
        if ($categories) {
            foreach ($categories as $category) {
                foreach ($category->cards as $card) {
                    if (File::exists(storage_path('app/public/uploads/gift_cards/' . $card->file_name))) {
                        unlink(storage_path('app/public/uploads/gift_cards/' . $card->file_name));
                    }
                }
                $category->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.gift-categories.index');
    }

    public function removeCard(Request $request)
    {
        $card = GiftCard::whereId($request->card_id)->first();
        if ($card) {
            if (File::exists(storage_path('app/public/uploads/gift_cards/' . $card->file_name))) {
                unlink(storage_path('app/public/uploads/gift_cards/' . $card->file_name));
            }
            $card->delete();
            return true;
        }
        return false;
    }
}
