<?php

namespace App\Http\Controllers;

use App\Models\sinprogramar;
use App\Models\Llamada;
use Illuminate\Http\Request;
use App\Http\Requests\Llamada\StoreRequest;
use App\Http\Requests\Llamada\UpdateRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $query = sinprogramar::query();

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
        $sinProgramar = SinProgramar::findOrFail($id);

        $data = $request->except('audio_file');

        if ($request->hasFile('audio_file')) {
            $data['audio_path'] = $request->file('audio_file')->store('audios', 'public');
        }

        $llamada = $sinProgramar->llamadas()->create($data);

        return response()->json([
            'message' => 'Llamada creada con éxito',
            'detalle' => $llamada->fresh(), // Devolvemos solo la nueva llamada
        ]);
    }

    /**
    * Actualizar una llamada existente.
    */
    public function updateLlamada(UpdateRequest $request, $id, $llamadaId)
    {
        $llamada = Llamada::where('sinprogramar_id', $id)->findOrFail($llamadaId);

        $data = $request->except('audio_file', '_method');

        if ($request->hasFile('audio_file')) {
            // ✅ Si ya tenía un archivo, eliminarlo antes de guardar el nuevo
            if ($llamada->audio_path) {
                Storage::disk('public')->delete($llamada->audio_path);
            }

            $data['audio_path'] = $request->file('audio_file')->store('audios', 'public');
        }

        $llamada->update($data);

        return response()->json([
            'message' => 'Llamada actualizada con éxito',
            'detalle' => $llamada->fresh(),
        ]);
    }

    /**
     * Eliminar una llamada existente.
     */
    public function destroyLlamada($id, $llamadaId)
    {
        $llamada = Llamada::where('sinprogramar_id', $id)->findOrFail($llamadaId);

        if ($llamada->audio_path) {
            Storage::disk('public')->delete($llamada->audio_path);
        }

        $llamada->delete();

        return response()->json([
            'message' => 'Llamada eliminada con éxito',
            'id_eliminado' => $llamadaId,
        ]);
    }
}
