<?php

namespace App\Http\Controllers\Dashboard;

use App\Contact;
use Illuminate\Http\Request;
use App\Mail\MessageMembersMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:read_contacts'])->only('index');
    //     $this->middleware(['permission:delete_contacts'])->only(['destroy', 'multiDelete']);
    // }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $status         = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $contacts = Contact::query();

        if ($keyword != null) {
            $contacts = $contacts->search($keyword);
        }
        if ($status != null) {
            $contacts = $contacts->whereStatus($status);
        }

        $contacts = $contacts->orderBy($sort_by, $order_by);
        $contacts = $contacts->paginate($limit_by);

        return view('dashboard.contacts.index', compact('contacts'));
    }
    
    public function update(Request $request, $id)
    {
        $message = Contact::whereId($id)->first();
        if ($message) {
            $request->validate(['message' => ['required', 'string', 'min:10']]);
            $data = [
                'message_title' =>  'رداً علي مراسلتك [' . $message->subject . '] - ' . setting()->name,
                'sent_mail'     =>  $message->email,
                'message'       =>  $request->message,
            ];
            Mail::to($data['sent_mail'])->send(new MessageMembersMail($data));
            session()->flash('success', __('dashboard.sended_successfully'));
            return redirect()->back();
        }
        return abort(404);
    }

    public function show($id)
    {
        $message = Contact::whereId($id)->first();

        if ($message && $message->status == 'is_unread') {
            $message->status = 'is_read';
            $message->save();
        }
        return view('dashboard.contacts.show', compact('message'));
    }

    public function destroy($id)
    {
        $message = Contact::whereId($id)->first();
        if ($message) {
            $message->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.contacts.index');
        }
        return redirect()->route('dashboard.contacts.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $messages = Contact::select('id')->whereIn('id', $ids);
        if ($messages) {
            $messages->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.contacts.index');
        }
        return redirect()->route('dashboard.contacts.index');
    }
}
