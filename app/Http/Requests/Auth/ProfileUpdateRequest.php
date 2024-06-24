<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:225'],
            'phone_number' => ['required', 'digits:10'],
            'email' => [
                'required',
                'string',
                'lowercase',
                Rule::unique(User::class)->ignore($this->user()->id),// La regla única asegura que el valor del campo 'email' sea único en la tabla 'users', pero ignora la fila con el ID actual del usuario ($this->user()->id).
                function ($attribute, $value, $fail) {
                    $this->validateEmail($value, $fail);
                },
            ]
        ];
    }

    private function validateEmail($value, $fail)
    {
        // Validar el formato del correo electrónico usando una expresión regular
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('El email no es válido.');
            return;
        }

        list($user, $domain) = explode('@', $value);

        $validDomains = ['correo.com', 'gmail.com']; // Agrega tus dominios permitidos

        // Validar el dominio y la longitud del usuario
        if (!in_array($domain, $validDomains) || strlen($user) > 64 || !preg_match('/^[a-zA-Z0-9.-]+$/', $user)) {
            $fail('El email no es válido.');
        }
    }

    public function messages()
    {
        return [
            'name' => 'El nombre es Obligatorio',
            'name.string' => 'Nombre no valido',
            'last_name' => 'El apellido es obligatorio',
            'last_name.string' => 'Apellido no valido',
            'phone_number' => 'El Telefono es obligatorio',
            'phone_number.digits' => 'El telefono debe tener exactamente 10 caracteres y deben ser numeros',
            'email.required' => 'El Email es Obligatorio',
            'email.unique' => 'El usuario ya esta registrado',
            'email.lowercase' => 'El Email debe ser en minusculas'
        ];
    }
}
