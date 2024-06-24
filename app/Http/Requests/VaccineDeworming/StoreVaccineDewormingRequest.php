<?php

namespace App\Http\Requests\VaccineDeworming;

use Illuminate\Foundation\Http\FormRequest;

class StoreVaccineDewormingRequest extends FormRequest
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
            'pet_id' => ['required'],
            'name' => ['required'],
            'date' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'pet_id' => 'Selecciona al menos una opcion',
            'name.required' => 'Campo requerido',
            'date.required' => 'Campo requerido'
        ];
    }
}
