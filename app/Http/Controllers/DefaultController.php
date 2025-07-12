<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class DefaultController extends Controller
{
    public function privacy(): View
    {
        return view('privacy');
    }
}
