<?php

namespace App\Traits;

use App\Models\Appointments;
use App\Models\Pets;

trait AppointmentTrait
{
    public function checkExistingAppointment($date, $hourId) : bool
    {
        // Verificar si ya hay una cita para la fecha y hora seleccionadas
        return Appointments::where('date', $date)
            ->where('hour_id', $hourId)
            ->exists();
    }

    public function checkIfPetBelongsToUser($userId, $petId) : bool
    {
        //verificar si
        return Pets::where('user_id', $userId)
            ->where('id', $petId)
            ->exists();
    }

    public function checkPendigAppointment($petId, $userId) : bool
    {
        return Appointments::where('pet_id', $petId)
            ->where('user_id', $userId)
            ->where('status', 0)
            ->exists();
    }

    public function generateErrorResponse($message, $status)
    {
        return response(['errors' => ['error' => [$message]]], $status);
    }
}
