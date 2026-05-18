<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UpdateUserRequest extends ApiFormRequest {
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
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $this->id,
            'password' => 'sometimes|string|min:6',
            'role_id' => 'sometimes|exists:roles,id',
            'area_id' => 'sometimes|exists:areas,id',
        ];
    }

    #[ Override ]

    public function messages() {
        return [

            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',

            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.unique' => 'Este correo ya está registrado.',

            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',

            'role_id.exists' => 'El rol seleccionado no existe.',

            'area_id.exists' => 'El área seleccionada no existe.',
        ];

    }
}
