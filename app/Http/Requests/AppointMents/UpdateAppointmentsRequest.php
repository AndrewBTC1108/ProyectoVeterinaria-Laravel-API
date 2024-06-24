<?php

namespace App\Http\Requests\AppointMents;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentsRequest extends FormRequest
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
        $method = $this->method();
        if($method == 'PUT'){
            return [
                'date' => ['required', 'date', 'after_or_equal:' . now()->toDateString()],
                'hour_id' => ['required'],
                'reason' => ['required']
            ];
        }else {
            return [
                'date' => ['required', 'date', 'after_or_equal:' . now()->toDateString()],
                'hour_id' => ['sometimes', 'required'],
                'reason' => ['sometimes', 'required']
            ];
        }
    }

    public function messages()
    {
        return [
            'date.required' => 'El campo es requerido',
            'date.date' => 'Fecha no valida',
            'hour_id.required' => 'El campo es requerido',
            'after_or_equal' => 'La fecha debe ser mayor a ' . now()->toDateString(),
            'reason.required' => 'El campo es requerido'
        ];
    }
}
