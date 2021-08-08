<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{
    public function detail(Request $request)
    {
        return Inertia::render('Detail', [
            'quantityProps' => $request->quantity,
            'auth' => Auth::user()
        ]);
    }
}
