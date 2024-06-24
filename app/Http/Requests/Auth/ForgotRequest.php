<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsWithEmailOrCedula;

class ForgotRequest extends FormRequest
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
            //
            'email_or_cedula' => ['required', new ExistsWithEmailOrCedula]
        ];
    }

    public function messages()
    {
        return [
            'email_or_cedula.required' => 'El Email o Cedula es Obligatorio'
        ];
    }
}
