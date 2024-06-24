<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class ExistsWithEmailOrCedula implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->existsWithEmailOrCedula($value)) {
            $fail('El email o cedula que digitaste no esta concectado a ninguna cuenta.');
        }
    }

    protected function existsWithEmailOrCedula($value)
    {
        //se hace una busqueda en la base de datos
        return DB::table('users')
            ->where(function ($query) use ($value) {
                $query->where('email', $value)
                      ->orWhere('cedula', $value);
            })
            ->exists();
    }
}
