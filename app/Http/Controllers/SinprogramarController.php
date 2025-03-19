<?php

namespace App\Http\Controllers;

use App\Models\sinprogramar;
use App\Models\Llamada;
use Illuminate\Http\Request;
use App\Http\Requests\Llamada\StoreRequest;
use App\Http\Requests\Llamada\UpdateRequest;
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
     * Display the specified resource.
     */
    public function show($id)
    {
        //Buscar el registro por el ID
        $detalle = sinprogramar::with('llamadas')->findOrFail($id);

        // Pasar los datos a la vista
        return Inertia::render('SinProgramar/Show', ['detalle' => $detalle,]);
    }

    /**
     * Crear una nueva llamada asociada a un aviso sin programación.
     */
    public function storeLlamada(StoreRequest $request, $id)
    {
        $sinProgramar = sinprogramar::findOrFail($id);

        // Crear la nueva llamada
        $sinProgramar->llamadas()->create($request->validated());

        // Devolver los datos actualizados
        return response()->json([
            'detalle' => $sinProgramar->fresh('llamadas'),
        ]);
    }

    /**
    * Actualizar una llamada existente.
    */
    public function updateLlamada(UpdateRequest $request, $id, $llamadaId)
    {
        // Buscar la llamada específica asociada al aviso sin programación
        $llamada = Llamada::where('sinprogramar_id', $id)->findOrFail($llamadaId);

        // Actualizar la llamada con los datos validados
        $llamada->update($request->validated());

        // Devolver los datos actualizados del aviso sin programación
        $sinProgramar = SinProgramar::findOrFail($id);
        return response()->json([
            'detalle' => $sinProgramar->fresh('llamadas'),
        ]);
    }

    /**
     * Eliminar una llamada existente.
     */
    public function destroyLlamada($id, $llamadaId)
    {
        $llamada = Llamada::where('sinprogramar_id', $id)->findOrFail($llamadaId);

        // Eliminar la llamada
        $llamada->delete();

        // Devolver los datos actualizados
        $sinProgramar = sinprogramar::findOrFail($id);
        return response()->json([
            'detalle' => $sinProgramar->fresh('llamadas'),
        ]);
    }
}
