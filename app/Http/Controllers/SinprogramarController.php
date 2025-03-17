<?php

namespace App\Http\Controllers;

use App\Models\sinprogramar;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;


class SinprogramarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el número de registros por página desde la solicitud (por defecto 5)
        $perPage = $request->input('per_page', 5);

        $sinprogramar = sinprogramar::where('user_id', Auth()->id())->paginate($perPage);
        return Inertia::render('SinProgramar/Index', compact('sinprogramar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(sinprogramar $sinprogramar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sinprogramar $sinprogramar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sinprogramar $sinprogramar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sinprogramar $sinprogramar)
    {
        //
    }
}
