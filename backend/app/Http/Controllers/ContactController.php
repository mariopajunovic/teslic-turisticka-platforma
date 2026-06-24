<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function send(ContactRequest $request): RedirectResponse
    {
        activity('kontakt')->log('Kontakt poruka: '.$request->input('email'));

        return back()->with('status', 'Poruka je poslana. Hvala na javljanju!');
    }
}
