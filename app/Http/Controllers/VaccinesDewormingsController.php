<?php

namespace App\Http\Controllers;

use App\Http\Requests\VaccineDeworming\StoreVaccineDewormingRequest;
use App\Http\Resources\AppointmentsResources\PetsVDResource;
use App\Models\Deworming;
use App\Models\Pets;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class VaccinesDewormingsController extends Controller
{
    //to show Pets
    public function index(Request $request)
    {
        $user_id = $request->userId;
        $pets = Pets::where('user_id', $user_id)
            ->get();

        return PetsVDResource::collection($pets);
    }
    //to create Vaccines
    public function createVaccine(StoreVaccineDewormingRequest $request)
    {
        //validate
        $data = $request->validated();
        Vaccine::create([
            'pet_id' => $data['pet_id'],
            'name' => $data['name'],
            'date' => $data['date']
        ]);

        return [
            'message' => 'Vacuna registrada exitosamente'
        ];
    }
    //to create Dewormings
    public function createDeworming(StoreVaccineDewormingRequest $request)
    {
        //validate
        $data = $request->validated();
        Deworming::create([
            'pet_id' => $data['pet_id'],
            'name' => $data['name'],
            'date' => $data['date']
        ]);

        return [
            'message' => 'Desparasitación registrada exitosamente'
        ];
    }
}
