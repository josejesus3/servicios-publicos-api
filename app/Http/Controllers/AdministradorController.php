<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Area;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class AdministradorController extends Controller
{
    public function getUsuarios(Request $request)
    {
        $usuarios = User::query()->paginate(10);

        return response()->json(
            ['usuarios' => $usuarios]
        );
    }
    public function userStore(UpdateUserRequest $request)
    {


        try {

            $validateData = $request->validated();
            $user = User::create($validateData);

            return response()->json([
                'success' => true,
                'message' => 'Reporte creado correctamente',
                'data' => $user // Cargamos los archivos para confirmar
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al crear el reporte',
                'details' => $e->getMessage() // Mejor mostrar el mensaje que todo el objeto
            ], 500);
        }
    }

    public function updateUser(UpdateUserRequest $request, User $user)
    {
        $validateData = $request->validated();
        $user->update($validateData);
        return response()->json([
            'message' => ' actualizado correctamente',
            'data' => $user
        ],);
    }


    public function getAreas(Request $request)
    {
        $areas = Area::query()->paginate(10);

        return response()->json([
            'areas' => $areas
        ]);
    }

    public function getIncidentAll()
    {
        $incident = Incident::all();

        return response()->json([
            'data' => $incident
        ]);
    }
}
