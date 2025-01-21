<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:read_notes'])->only(['index', 'show']);
    //     $this->middleware(['permission:create_notes'])->only('create');
    //     $this->middleware(['permission:update_notes'])->only('edit');
    //     $this->middleware(['permission:delete_notes'])->only(['destroy']);
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content'   => ['required', 'string', 'min:5'],
        ]);

        $note               = new Note();
        $note->written_by   = auth()->user()->name;
        $note->content      = $data['content'];
        $note->save();
        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->back();
    }

    public function destroy($id)
    {
        $note = Note::whereId($id)->first();
        if($note) {
            $note->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $note = Note::whereId($id)->first();
        if($note) {
            // $request->validate([
            //     'status'    => ['required', 'in:new,progress,completed']
            // ]);

            $note->status = $note->status == 'new' ? 'progress' : 'completed';
            $note->save();
            // $note->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->back();
    }
}
