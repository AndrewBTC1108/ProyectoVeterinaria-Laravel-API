<?php

namespace App\Http\Controllers;

use App\Models\Pets;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PetsResource;
use App\Http\Requests\StorePetsRequest;
use App\Http\Requests\UpdatePetsRequest;

class PetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        $userId = (auth()->user()->admin || auth()->user()->doctor) ? $request->user_id : Auth::user()->id;
        $user = User::find($userId);
        //when we need a collection of something like pets, users or appointments, if we need only one element, use resources
        return PetsResource::collection($user->pets);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetsRequest $request): array
    {
        $this->authorize('create', Pets::class);
        $data = $request->validated();
        $userId = auth()->user()->admin ? $request->user_id : Auth::user()->id;

        Pets::create([
            'name' => $data['name'],
            'birth_date' => $data['birth_date'],
            'species' => $data['species'],
            'breed' => $data['breed'],
            'color' => $data['color'],
            'sex' => $data['sex'],
            'user_id' => $userId
        ]);

        return [
            'message' => 'Mascota creada con exito'
        ];
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetsRequest $request, $id): array
    {
        // load pet
        $pets = Pets::findOrFail($id);
        //authorization pilicie
        $this->authorize('update', $pets);
        //validate the form data
        $data = $request->validated();

        $pets->update($data);

        return [
            'message' => 'La mascota se ha actualizado',
        ];
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): array
    {
        $pets = Pets::findOrFail($id);

        $this->authorize('delete', $pets);
        // Delete pet of DB
        $pets->delete();

        return [
            'message' => 'La mascota se ha eliminado'
        ];
    }
}
