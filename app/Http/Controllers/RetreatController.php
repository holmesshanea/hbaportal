<?php

namespace App\Http\Controllers;

use App\Models\Retreat;

class RetreatController extends Controller
{
    public function show(Retreat $retreat)
    {
        return view('retreats.show', compact('retreat'));
    }
}
