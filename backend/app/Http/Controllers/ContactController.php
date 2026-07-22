<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function send(ContactRequest $request): RedirectResponse
    {
        activity('kontakt')->log('Kontakt poruka: '.$request->input('email'));

        \App\Support\OrgNotifier::send(new \App\Notifications\OrgNovaPoruka(
            $request->input('ime'),
            $request->input('email'),
            $request->input('poruka'),
        ));

        return back()->with('status', 'Poruka je poslana. Hvala na javljanju!');
    }
}
