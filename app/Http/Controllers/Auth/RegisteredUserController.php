<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

// use Illuminate\Support\Facades\Auth;


class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request) : JsonResponse
    {
        //Validar el registro
        $data = $request->validated();

        //crear el usuario
        $user = User::create([
            'cedula' => $data['cedula'],
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => bcrypt($data['password']) //hashear password
        ]);

        event(new Registered($user));

        return response()->json([
            'token' => $user->createToken('token')->plainTextToken, //crear token para personal_acces_token
            'user' => $user
        ], 200);
    }
}
