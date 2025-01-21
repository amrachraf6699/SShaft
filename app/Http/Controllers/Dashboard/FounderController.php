<?php

namespace App\Http\Controllers\Dashboard;

use App\Founder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\FounderRequest;

class FounderController extends Controller
{
    public function create()
    {
        return view('dashboard.get-to-know-us.founders.create');
    }

    public function store(FounderRequest $request)
    {
        $data   = $request->validated();
        // img
        $img            = $request->file('img');
        $filename       = 'IMG_' . time() . '_' . rand(1, 9999) . '_' . rand(1, 999999999) . '.' . $img->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/founders/' . $filename);
        Image::make($img->getRealPath())->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);
        $data['img']   = $filename;

        Founder::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.get-to-know-us.brief.index');
    }

    public function edit($id)
    {
        $founder = Founder::whereId($id)->first();
        if($founder) {
            return view('dashboard.get-to-know-us.founders.edit', compact('founder'));
        }
        return redirect()->route('dashboard.get-to-know-us.brief.index');
    }

    public function update(FounderRequest $request, $id)
    {
        $founder = Founder::whereId($id)->first();
        if($founder) {
            $data   = $request->validated();
            // img
            if ($img = $request->file('img')) {
                Storage::disk('public')->delete('/founders/' . $founder->img);

                $filename       = 'IMG_' . time() . '_' . rand(1, 9999) . '_' . rand(1, 999999999) . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/founders/' . $filename);
                Image::make($img->getRealPath())->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img']   = $filename;
            }

            $founder->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.get-to-know-us.brief.index');
        }
        return redirect()->route('dashboard.get-to-know-us.brief.index');
    }

    public function destroy($id)
    {
        $founder = Founder::whereId($id)->first();
        if ($founder) {
            Storage::disk('public')->delete('/founders/' . $founder->img);
            $founder->delete();

            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.get-to-know-us.brief.index');
        }
        return redirect()->route('dashboard.get-to-know-us.brief.index');
    }
}
