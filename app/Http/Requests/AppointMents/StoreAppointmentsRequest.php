<?php

namespace App\Http\Requests\AppointMents;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pet_id' => ['required'],
            'date' => ['required', 'date', 'after_or_equal:' . now()->toDateString()],
            'hour_id' => ['required'],
            'reason' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'pet_id.required' => 'La mascota es requerida',
            'date.required' => 'El campo es requerido',
            'date.date' => 'Fecha no valida',
            'after_or_equal' => 'La fecha debe ser mayor a ' . now()->toDateString(),
            'hour_id.required' => 'La hora es requerida',
            'reason.required' => 'El campo es requerido'
        ];
    }
}
