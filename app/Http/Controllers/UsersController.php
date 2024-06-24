<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) : JsonResponse
    {
        //get permite colocar valor por defecto
        $page = $request->get('page', 1); // get the request page, default is 1
        $search = $request->get('search', ''); // Obtiene el término de búsqueda de la solicitud, por defecto es ''

        // Obtiene los usuarios paginados que coinciden con el término de búsqueda y que no son administradores
        $users = User::where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('cedula', 'like', "%{$search}%");
        })->where('admin', 0)
        ->orderBy('created_at', 'desc')
        ->paginate(6, ['id', 'cedula', 'name', 'last_name', 'email', 'phone_number'], 'page', $page);

        // Retorna los usuarios como una respuesta JSON
        return response()->json($users);
    }
}
