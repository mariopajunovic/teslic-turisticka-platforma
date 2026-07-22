<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use App\Support\AdminObavijesti;
use Illuminate\Http\JsonResponse;

class ObavijestiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'stavke' => AdminObavijesti::sve(12),
            'broj' => AdminObavijesti::broj(),
        ]);
    }
}
