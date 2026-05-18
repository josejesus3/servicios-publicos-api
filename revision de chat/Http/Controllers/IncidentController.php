<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncidentRequest;
use App\Models\Incident;
use App\Services\Incident\CreateIncidentService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IncidentController extends Controller {
    public function __construct( protected CreateIncidentService $create ) {
    }

    public function index( Request $request ) {

        $incident = Incident::all();

        return response()->json(
            [ 'Reportes'=>$incident ]
        );

    }

    public function show( int $id = 0 ) {
        $incident = Incident::find( $id );

        if ( !$incident ) {
            return response()->json( [
                'message' => 'Reporte No encontrado'
            ], 404 );
        }

        return response()->json( [
            'message' => $incident
        ],Response::HTTP_OK );

    }

    public function store( IncidentRequest $request ) {
        try {

            // 1. Creamos el incidente con sus datos reales
            $incident = $this->create->createIncident( $request );

          

            return response()->json( [
                'message' => 'Reporte creado correctamente',
                'data' => $incident->load('media' ) // Cargamos los archivos para confirmar
            ], 201 );

        } catch ( Exception $e ) {
            return response()->json( [
                'error' => 'Error al crear el reporte',
                'details' => $e->getMessage() // Mejor mostrar el mensaje que todo el objeto
            ], 500 );
        }
    }

    public function update( IncidentRequest $request, Incident $incident ) {

        $validateDate = $request->validated();
        $incident->update( $validateDate );
        return response()->json( [
            'message' => 'Reporte actualizado correctamente',
            'Data' => $incident
        ], Response::HTTP_OK );

    }

    public function destroy( Incident $incident ) {
        $incident->delete();
        return response()->json( [
            'message' => 'Reporte se elimino correctamete',
            'data' => $incident
        ] );
    }
}
