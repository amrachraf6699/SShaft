<?php

namespace App\Http\Controllers\Dashboard;

use App\Director;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\DirectorRequest;

class DirectorController extends Controller
{
    public function create()
    {
        return view('dashboard.get-to-know-us.directors.create');
    }

    public function store(DirectorRequest $request)
    {
        $data   = $request->validated();
        // img
        $img            = $request->file('img');
        $filename       = 'IMG_' . time() . '_' . rand(1, 9999) . '_' . rand(1, 999999999) . '.' . $img->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/directors/' . $filename);
        Image::make($img->getRealPath())->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);
        $data['img']   = $filename;

        Director::create($data);
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.get-to-know-us.board-of-directors.index');
    }

    public function edit($id)
    {
        $director = Director::whereId($id)->first();
        if($director) {
            return view('dashboard.get-to-know-us.directors.edit', compact('director'));
        }
        return redirect()->route('dashboard.get-to-know-us.board-of-directors.index');
    }

    public function update(DirectorRequest $request, $id)
    {
        $director = Director::whereId($id)->first();
        if($director) {
            $data   = $request->validated();
            // img
            if ($img = $request->file('img')) {
                Storage::disk('public')->delete('/directors/' . $director->img);

                $filename       = 'IMG_' . time() . '_' . rand(1, 9999) . '_' . rand(1, 999999999) . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/directors/' . $filename);
                Image::make($img->getRealPath())->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img']   = $filename;
            }

            $director->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.get-to-know-us.board-of-directors.index');
        }
        return redirect()->route('dashboard.get-to-know-us.board-of-directors.index');
    }

    public function destroy($id)
    {
        $director = Director::whereId($id)->first();
        if ($director) {
            Storage::disk('public')->delete('/directors/' . $director->img);
            $director->delete();

            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.get-to-know-us.board-of-directors.index');
        }
        return redirect()->route('dashboard.get-to-know-us.board-of-directors.index');
    }
}
