<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExtraController extends Controller
{
    public function auth_reset(Request $request)
    {
        return view('auth.auth_reset');
    }
}
