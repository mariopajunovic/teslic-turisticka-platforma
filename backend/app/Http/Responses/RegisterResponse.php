<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        Auth::guard(config('fortify.guard'))->logout();

        return redirect('/prijava')->with(
            'status',
            'Registracija je uspješna. Nalog čeka odobrenje administratora prije prve prijave.'
        );
    }
}
