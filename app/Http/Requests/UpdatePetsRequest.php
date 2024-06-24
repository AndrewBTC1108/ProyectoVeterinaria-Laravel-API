<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePetsRequest extends FormRequest
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
        $method = $this->method();
        if($method == 'PUT'){
            return [
                'name' => ['required', 'alpha'],
                'birth_date' => ['required', 'date'],
                'species' => ['required', 'alpha'],
                'breed' => ['required', 'alpha'],
                'color' => ['required', 'alpha'],
                'sex' => ['required', 'alpha']
            ];
        } else {
            return [
            'name' => ['sometimes', 'required', 'alpha'],
            'birth_date' => ['sometimes', 'required', 'date'],
            'species' => ['sometimes', 'required', 'alpha'],
            'breed' => ['sometimes', 'required', 'alpha'],
            'color' => ['sometimes', 'required', 'alpha'],
            'sex' => ['sometimes', 'required', 'alpha']
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo es requerido',
            'name.alpha' => 'El campo debe contener solo letras',
            'birth_date.required' => 'El campo es requerido',
            'birth_date.date' => 'Fecha no valida',
            'species.required' => 'El campo es requerido',
            'species.alpha' => 'El campo debe contener solo letras',
            'breed.required' => 'El campo es requerido',
            'breed.alpha' => 'El campo debe contener solo letras',
            'color.required' => 'El campo es requerido',
            'color.alpha' => 'El campo debe contener solo letras',
            'sex.required' => 'El campo es requerido',
            'sex.alpha' => 'El campo debe contener solo letras'
        ];
    }
}
