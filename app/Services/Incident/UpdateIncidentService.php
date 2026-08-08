<?php

namespace App\Services\Incident;

use App\Http\Requests\IncidentRequest;
use App\Models\Incident;
use Faker\Core\File;
use Illuminate\Support\Facades\DB;

class UpdateIncidentService
{

    public function updateIncident(IncidentRequest $request, Incident $incident)
    {
        $user = auth()->user();
        if ($user->role_id == 3) {
            abort(403, 'El director no puede crear reportes');
        }
        $validateDate = $request->validated();
        $incident->update($validateDate);

        if ($request->hasFile('archivos')) {
            $this->storeFiles($request->file('archivos'), $incident);
        }
        return $incident;
    }

    public function storeFiles(array $files, Incident $incident)
    {

        foreach ($files as $file) {
            $path = $file->store('reportes', 'public');
            $extension = strtolower($file->getClientOriginalExtension());
            $tipo = in_array($extension, ['mp4', 'mov', 'avi']) ? 'video' : 'image';

            $incident->media()->update([
                'file_path' => $path,
                'file_type' => $tipo,
            ]);
        }
    }
}
