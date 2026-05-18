<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class SearchIncidentRequest extends ApiFormRequest {
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
            'title'       => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
            'direction'   => 'nullable|string|max:255',
            'user_id'     => 'nullable|integer|exists:users,id',
            'page'        => 'nullable|integer|min:1',

        ];
    }

    public function messages(){
        return [
        'user_id.exists' => 'El usuario especificado no existe.',
        'page.integer'   => 'El número de página debe ser un número entero.',
    ];
    }
}
