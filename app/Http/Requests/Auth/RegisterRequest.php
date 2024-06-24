<?php

namespace App\Http\Requests\Auth;

// use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

class RegisterRequest extends FormRequest
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
            'cedula' => ['required', 'unique:users,cedula', 'digits:10'],
            'name' => ['required'],
            'last_name' => ['required'],
            'email' => [
                'required',
                'unique:users,email',
                'lowercase',
                function ($attribute, $value, $fail) {
                    $this->validateEmail($value, $fail);
                },
            ],
            'phone_number' => ['required', 'digits:10'],
            'password' => [
                'required',
                'confirmed',
                PasswordRules::min(8)->letters()->symbols()->numbers(),
            ],
        ];
    }

    private function validateEmail($value, $fail)
    {
        // Validar el formato del correo electrónico usando una expresión regular
        //Se utiliza filter_var con FILTER_VALIDATE_EMAIL para validar el formato del correo electrónico.
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('El email no es válido.');
            return;
        }
        // Se agregó una verificación adicional de la longitud del usuario y del formato del dominio.
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
            'cedula.required' => 'La cédula es obligatoria',
            'cedula.unique' => 'La cédula ya está registrada',
            'cedula.digits' => 'La cédula debe tener exactamente 10 caracteres y deben ser numeros',
            'name.required' => 'El nombre es obligatorio',
            'last_name.required' => 'El apellido es obligatorio',
            'email.required' => 'El Email es obligatorio',
            'email.unique' => 'El usuario ya está registrado',
            'email.lowercase' => 'El Email debe ser en minusculas',
            'phone_number.required' => 'El Telefono es requerido',
            'phone_number.digits' => 'El telefono debe tener exactamente 10 caracteres y deben ser numeros',
            'password.required' => 'El password es obligatorio',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ];
    }
}
