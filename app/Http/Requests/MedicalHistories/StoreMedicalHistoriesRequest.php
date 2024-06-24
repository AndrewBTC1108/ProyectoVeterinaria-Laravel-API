<?php

namespace App\Http\Requests\MedicalHistories;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalHistoriesRequest extends FormRequest
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
            'reasonConsult' => ['required'],
            'observations' => ['required'],
            'food' => ['required'],
            'frequencyFood' => ['required', 'numeric']
        ];
    }

    public function messages()
    {
        return [
            'reasonConsult.required' => 'Campo Requerido',
            'observations.required' => 'Campo Requerido',
            'food.required' => 'Campo Requerido',
            'frequencyFood.required' => 'Campo Requerido'
        ];
    }
}
