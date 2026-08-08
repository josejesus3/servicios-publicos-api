<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncidentRequest;
use App\Http\Requests\SearchIncidentRequest;
use App\Http\Requests\UpdateIncidentRequest;
use App\Models\Incident;
use App\Services\Incident\CreateIncidentService;
use App\Services\Incident\SearchIncidentService;
use App\Services\Incident\UpdateIncidentService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IncidentController extends Controller
{
    public function __construct(protected CreateIncidentService $create, protected SearchIncidentService $search, protected UpdateIncidentService $update) {}

    public function index(SearchIncidentRequest $request)
    {
        $incident = $this->search->searchService($request);

        return response()->json(
            [
                'success' => true,
                'message' => 'Lista de reportes',
                'data' => $incident
            ]
        );
    }

    public function show(int $id = 0)
    {
        $incident = Incident::find($id);

        if (!$incident) {
            return response()->json([
                'message' => 'Reporte No encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Reporte obtenido correctamente',
            'data' => $incident
        ], Response::HTTP_OK);
    }
    public function getIncident()
    {
        $incident = Incident::query()->with(['media'])->with(['area'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return response()->json(
            [
                'success' => true,
                'message' => 'Lista de reportes',
                'data' => $incident
            ]
        );
    }

    public function store(IncidentRequest $request)
    {
        try {

            // 1. Creamos el incidente con sus datos reales
            $incident = $this->create->createIncident($request);

            return response()->json([
                'success' => true,
                'message' => 'Reporte creado correctamente',
                'data' => $incident->load('media') // Cargamos los archivos para confirmar
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al crear el reporte',
                'details' => $e->getMessage() // Mejor mostrar el mensaje que todo el objeto
            ], 500);
        }
    }

    public function update(IncidentRequest $request, Incident $incident)
    {
        $incident=$this->update->updateIncident($request,$incident);
        return response()->json([
            'message' => 'Reporte actualizado correctamente',
            'data' => $incident
        ], Response::HTTP_OK);
    }

    public function destroy(Incident $incident)
    {
        $incident->delete();
        return response()->json([
            'message' => 'Reporte se elimino correctamete',
            'data' => $incident
        ]);
    }
}
