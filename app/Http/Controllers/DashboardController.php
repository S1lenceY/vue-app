<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sinprogramar;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $cantidadSinProgramar = sinprogramar::where('user_id', Auth()->id())->count();
        return Inertia::render('Dashboard', compact('cantidadSinProgramar'));
    }
}
