<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required',
        ]);
        $email = $validated['email'];
        // Send the email
        Mail::to($email)->send(new ContactFormMailable($validated['name'], $validated['email'], $validated['message']));
        return back()->with('success', 'Your message has been sent successfully!');
    }
}
