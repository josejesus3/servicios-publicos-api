<?php
namespace App\Services\Incident;

use App\Http\Requests\IncidentRequest;
use App\Models\Incident;
use Illuminate\Support\Facades\DB;

class CreateIncidentService{
    public function createIncident(IncidentRequest $request){
        return DB::transaction(function()use ($request){
            $validateData=$request->validated();
            $incident=Incident::create($validateData);

              if ( $request->hasFile( 'fotos' ) ) {
                $this->storeFiles($request->file('fotos'),$incident,'foto');
                
            }

            if ( $request->hasFile( 'videos' ) ) {
                $this->storeFiles($request->file('videos'),$incident,'video');
            }
            return $incident;

        });
        
    }

    private function storeFiles(array $files, Incident $incident,String $type){
        foreach ($files as $file) {
            $path = $file->store('reportes', 'public');

            $incident->media()->create([
                'file_path' => $path,
                'file_type' => $type
            ]);
        }
    }
    }
