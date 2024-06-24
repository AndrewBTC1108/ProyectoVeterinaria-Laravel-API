<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rules\Password as PasswordRules;
use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
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
            'current_password' => ['required', 'current_password'],
            'password' => ['required','confirmed', PasswordRules::min(8)->letters()->symbols()->numbers()],
            'password_confirmation' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'El campo "password actual" es requerido.',
            'current_password.current_password' => 'El password actual es incorrecto.',
            'password.required' => 'El campo "nuevo password" es requerido.',
            'password.confirmed' => 'Los password no coinciden.',
            'password' => 'El password debe contener al menos 8 caracteres, un símbolo y un número.',
            'password_confirmation.required' => 'El campo "repetir password" es requerido.'
        ];
    }
}
