<?php

namespace App\Http\Requests\Auth;

use Illuminate\Support\Str;
use App\Rules\ExistsWithEmailOrCedula;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'email_or_cedula' => ['required', new ExistsWithEmailOrCedula],
            'password' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'email_or_cedula.required' => 'El Email o Cédula es Obligatorio',
            'password.required' => 'El password es obligatorio'
        ];
    }
    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        //validar que no se haya exedido en los intentos de autenticacion
        $this->ensureIsNotRateLimited();
        //tomamos el valor de emai_or_cedula
        $value = $this->input('email_or_cedula');
        $isCedula = is_numeric($value); // Verifica si el valor es numérico, asumiendo que la cédula es numérica.

        $credentials = [
            $isCedula ? 'cedula' : 'email' => $value,
            'password' => $this->input('password'),
        ];

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'password' => __('Password incorrecto'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email_or_cedula' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }
    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email_or_cedula')).'|'.$this->ip());
    }
}
