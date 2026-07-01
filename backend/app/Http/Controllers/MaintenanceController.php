<?php

namespace App\Http\Controllers;

use App\Settings\SiteSettings;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function unlock(Request $request)
    {
        $settings = app(SiteSettings::class);
        $lozinka = (string) $request->input('lozinka', '');

        if ($settings->odrzavanje_lozinka === '' || ! hash_equals($settings->odrzavanje_lozinka, $lozinka)) {
            return back()->with('maintenance_error', 'Pogrešna lozinka. Pokušajte ponovo.');
        }

        $minuta = max(1, (int) $settings->odrzavanje_minuta);

        return redirect('/')->withCookie(
            cookie('site_unlock', (string) now()->addMinutes($minuta)->timestamp, $minuta)
        );
    }
}
