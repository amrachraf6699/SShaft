<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewContactForAdminNotify;

class ContactController extends Controller
{
    public function index()
    {
        $pageTitle  =   __('web.contact_us');
        return view('frontend.contacts.index', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      =>  'required|string|min:3|max:50',
            'email'     =>  'required|email|max:255',
            'phone'     =>  'required|numeric',
            'subject'   =>  'required|string|max:255',
            'message'   =>  'required|string|min:20',
        ]);

        $contact = Contact::create([
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'phone'     =>  $request->phone,
            'subject'   =>  $request->subject,
            'message'   =>  $request->message,
        ]);

        User::each(function($admin, $key) use ($contact) {
            $admin->notify(new NewContactForAdminNotify($contact));
        });
        session()->flash('sessionSuccess', 'تم إرسال رسالتك بنجاح، وسيتم التواصل معكم في أقرب وقت ممكن!');
        return redirect()->back();
    }
}
