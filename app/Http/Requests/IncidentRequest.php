<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class IncidentRequest extends ApiFormRequest {
    /**
    * Determine if the user is authorized to make this request.
    */

    public function authorize(): bool {
        return true;
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, ValidationRule|array<mixed>|string>
    */

    public function rules(): array {
        return [
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'direction'=>'required|string',
            'latitude'=>'sometimes|decimal:2,9',
            'longitude'=>'sometimes|decimal:2,10',
             'status'=>'sometimes',
            'area_id'=>'required|exists:areas,id',
            'archivos.*'=>'file|mimes:jpeg,png,jpg,mp4,mov,avi|max:51200', 
        ];
    }

    public function messages() {
        return[
            // Título
            'title.required' => 'El título es obligatorio.',
            'title.string'   => 'El título debe ser una cadena de texto.',
            'title.max'      => 'El título no puede tener más de 255 caracteres.',

            // Descripción
            'description.required' => 'La descripción es necesaria.',
            'description.string'   => 'La descripción debe ser texto válido.',

            // Dirección
            'direction.required' => 'La dirección es obligatoria.',
            'direction.string'   => 'La dirección debe ser una cadena de texto.',

            // Latitud y Longitud
            'latitude.numeric'   => 'La latitud debe ser un valor numérico.',
            'longitude.numeric'  => 'La longitud debe ser un valor numérico.',


            // Relaciones ( Foreign Keys )
            'area_id.required' => 'El área es obligatoria.',
            'area_id.exists'   => 'El área seleccionada no es válida.',
        ];
    }
}
