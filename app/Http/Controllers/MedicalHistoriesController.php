<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalHistories;
use App\Http\Requests\MedicalHistories\StoreMedicalHistoriesRequest;
use App\Http\Requests\MedicalHistories\UpdateMedicalHistoriesRequest;
use App\Models\Appointments;
use App\Models\PreviousTreatment;
use App\Models\SurgicalProcedures;
use Illuminate\Http\JsonResponse;

class MedicalHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : JsonResponse
    {
        $medicalHistories = MedicalHistories::where('pet_id', $request->pet_id)->get(['id', 'date', 'reasonConsult', 'observations', 'food', 'frequencyFood']);
        $previous_treatments = PreviousTreatment::where('pet_id', $request->pet_id)->get(['id', 'name', 'date']);
        $surgical_procedures = SurgicalProcedures::where('pet_id', $request->pet_id)->get(['id', 'name', 'date']);

        return response()->json([
            'medicalHistoriesPet' => $medicalHistories,
            'previous_treatments' => $previous_treatments,
            'surgical_procedures' => $surgical_procedures
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicalHistoriesRequest $request): array
    {
        //
        $data = $request->validated();
        //create medicalHistory
        $medicalHistory = MedicalHistories::create([
            'pet_id' => $request->pet_id,
            'date' => now()->toDateString(),
            'reasonConsult' => $data['reasonConsult'],
            'observations' => $data['observations'],
            'food' => $data['food'],
            'frequencyFood' => $data['frequencyFood']
        ]);

        if ($request->has('previous_treatments')) {
            $medicalHistory->previous_treatments()->createMany($request->previous_treatments);
        }

        if ($request->has('surgical_procedures')) {
            $medicalHistory->surgical_procedures()->createMany($request->surgical_procedures);
        }

        $appointments = new Appointments;
        $appointment = $appointments::find($request->appointment_id);
        $appointment->status = 1;
        $appointment->save();

        return [
            'message' => 'Hisotria clinica Creada con exito'
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalHistoriesRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
