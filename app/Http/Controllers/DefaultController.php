<?php

namespace App\Http\Controllers;

use App\Models\Audition;
use Illuminate\Contracts\View\View;

class DefaultController extends Controller
{
    public function privacy(): View
    {
        $audition = Audition::query()->where('active', true)->orderBy('created_at', 'desc')->first();
        return view('privacy', [
            'audition' => $audition
        ]);
    }
}
