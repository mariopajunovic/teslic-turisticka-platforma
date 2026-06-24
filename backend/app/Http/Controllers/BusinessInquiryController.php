<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Notifications\BusinessInquiry;
use App\Rules\Captcha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BusinessInquiryController extends Controller
{
    public function send(Request $request, string $slug): RedirectResponse
    {
        $request->validate([
            'ime' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'poruka' => ['required', 'string', 'max:5000'],
            'captcha' => ['nullable', new Captcha()],
        ]);

        $biznis = Business::objavljeno()->where('slug', $slug)->firstOrFail();

        if ($biznis->user_id && $biznis->user) {
            $biznis->user->notify(new BusinessInquiry($biznis, $request->only('ime', 'email', 'poruka')));
        }

        activity('upit')->log('Upit za biznis: '.$biznis->naslov.' od '.$request->input('email'));

        return back()->with('status', 'Upit je poslan biznisu.');
    }
}
