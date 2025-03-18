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
        // Obtener los parámetros de filtro
         $filters = [
            'cultivo' => $request->input('cultivo'),
            'contratante' => $request->input('contratante'),
            'tipo_evento' => $request->input('tipo_evento'),
            'inspector' => $request->input('inspector'),
            'ubicacion' => $request->input('ubicacion') //Filtro combinado de Departamento y Provincia
        ];

        // Construir la consulta base
        $query = sinprogramar::where('user_id', Auth()->id());

        // Aplicar filtros
        if ($filters['ubicacion']) {
            $query->where(function ($q) use ($filters) {
                $q->where('departamento', 'LIKE', '%' . $filters['ubicacion'] . '%')
                ->orWhere('provincia', 'LIKE', '%' . $filters['ubicacion'] . '%');
            });
        }
        if ($filters['cultivo']) {
            $query->where('cultivo', 'LIKE', '%' . $filters['cultivo'] . '%');
         }
        if ($filters['contratante']) {
            $query->where('contratante', 'LIKE', '%' . $filters['contratante'] . '%');
        }
        if ($filters['tipo_evento']) {
            $query->where('tipo_evento', $filters['tipo_evento']);
        }
        if ($filters['inspector']) {
            $query->where('inspector', 'LIKE', '%' . $filters['inspector'] . '%');
        }

        // Obtener el número de registros por página desde la solicitud (por defecto 5)
        $perPage = $request->input('per_page', 5);
        $sinprogramar = $query->paginate($perPage)->withQueryString();

        return Inertia::render('SinProgramar/Index', compact('sinprogramar', 'filters'));
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
    public function show($id)
    {
        //Buscar el registro por el ID
        $detalle = sinprogramar::findOrFail($id);

        // Pasar los datos a la vista
        return Inertia::render('SinProgramar/Show', ['detalle' => $detalle,]);
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
