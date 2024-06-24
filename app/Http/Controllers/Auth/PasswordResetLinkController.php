<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Auth\ForgotRequest;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ForgotRequest $request): JsonResponse
    {
        //primero pasar por esta validacion
        $data = $request->validated();

        // Buscar al usuario por correo electrónico o cédula
        $user = User::where('email', $data['email_or_cedula'])
            ->orWhere('cedula', $data['email_or_cedula'])
            ->first();

        // Enviar el enlace de restablecimiento de contraseña al correo electrónico del usuario
        $status = Password::sendResetLink([
            'email' => $user->email
        ]);

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['status' => __($status)]);
    }
}
