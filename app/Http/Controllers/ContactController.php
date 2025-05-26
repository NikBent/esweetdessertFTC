<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validate the input
        $request->validate([
            'first_name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you can handle the form (e.g., send an email or save to DB)
        // Example: send email (you must configure mail settings)
        /*
        Mail::to('your@email.com')->send(new ContactMail($request->all()));
        */

        // Redirect back with success
        return redirect()->back()->with('success', 'Thank you for your message. We will be in touch soon!');
    }
}
