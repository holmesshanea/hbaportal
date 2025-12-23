<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact');
    }

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'name'                     => ['required', 'string', 'max:255'],
            'phone'                    => ['nullable', 'string', 'max:50'],
            'email'                    => ['required', 'email', 'max:255'],
            'preferred_contact_method' => ['required', 'string', 'max:50'],
            'preferred_time'           => ['nullable', 'string', 'max:255'],
            'comments'                 => ['required', 'string'],
            'g-recaptcha-response'     => [
                'required',
                function ($attribute, $value, $fail) {
                    $response = Http::asForm()->post(
                        'https://www.google.com/recaptcha/api/siteverify',
                        [
                            'secret'   => config('services.recaptcha.secret_key'),
                            'response' => $value,
                            'remoteip' => request()->ip(),
                        ]
                    );

                    if (! $response->json('success')) {
                        $fail('Please confirm that you are not a robot.');
                    }
                },
            ],
        ]);

        // Send the email
        Mail::to('wecare@homewardboundadirondacks')->send(
            new ContactFormSubmitted($validated)
        );
        // ^ if your real email is e.g. .org, update this string accordingly.

        return back()->with('success', 'Thank you! Your message has been sent successfully.');
    }
}
