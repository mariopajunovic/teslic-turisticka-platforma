<?php

namespace App\Http\Controllers;

use App\Rules\Captcha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        $request->validate([
            'ime' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'tema' => ['nullable', 'string', 'max:255'],
            'poruka' => ['required', 'string', 'max:5000'],
            'captcha' => ['nullable', new Captcha()],
        ]);

        activity('kontakt')->log('Kontakt poruka: '.$request->input('email'));

        return back()->with('status', 'Poruka je poslana. Hvala na javljanju!');
    }
}
