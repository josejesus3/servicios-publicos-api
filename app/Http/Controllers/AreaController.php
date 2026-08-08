<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AreaController extends Controller
{
    public function index()
    {
        $area = Area::query()->with('incidents')->get();
         return response()->json([
            'success' => true,
            'message' => 'Areas obtenidas correctamente',
            'data' => $area
        ], Response::HTTP_OK);
    }
    public function show(Area $area)
    {
        $area::all();

        return response()->json([
            'success' => true,
            'message' => 'Area obtenida correctamente',
            'data' => $area
        ], Response::HTTP_OK);
    }
    public function strore(){
        
    }
}
