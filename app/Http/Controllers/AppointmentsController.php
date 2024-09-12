<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Http\Resources\AppointmentsResource;
use App\Traits\AppointmentTrait;
use App\Http\Requests\AppointMents\StoreAppointmentsRequest;
use App\Http\Requests\AppointMents\UpdateAppointmentsRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{

    // we use trait to handle validations of appointments
    //usamos trait para manejar validaciones de appointments

    use AppointmentTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $userId = auth()->user()->id;
        $date = $request->date;
        $isAdmin = auth()->user()->admin;
        $isDoctor = auth()->user()->doctor;
        // If the user is an administrator, all appointments for the given date are displayed.
        // If the user is not an administrator, only the appointments of the authenticated user are shown.
        $query = Appointments::query()
            ->with(['pet', 'hour', 'user'])
            ->where('status', 0);

        if (!$isAdmin && !$isDoctor) {
            $query->where('user_id', $userId);
        } else if ($date) {
            $query->where('date', $date);
        }

        $appointments = $query->get();

        return AppointmentsResource::collection($appointments);
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(StoreAppointmentsRequest $request): array|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data = $request->validated();
        $this->authorize('create', Appointments::class);

        $userId = auth()->user()->admin ? $request->user_id : Auth::user()->id;

        if (!$this->checkIfPetBelongsToUser($userId, $data['pet_id'])) {
            return $this->generateErrorResponse('La mascota no pertenece al usuario.', 422);
        }

        if ($this->checkPendigAppointment($data['pet_id'], $userId)) {
            return $this->generateErrorResponse('La mascota tiene una consulta pendiente.', 422);
        }

        if ($this->checkExistingAppointment($data['date'], $data['hour_id'])) {
            return $this->generateErrorResponse('Ya hay una cita programada para la fecha y hora seleccionadas.', 422);
        }

        Appointments::create([
            'pet_id' => $data['pet_id'],
            'date' => $data['date'],
            'hour_id' => $data['hour_id'],
            'reason' => $data['reason'],
            'user_id' => $userId,
            'status' => 0
        ]);

        return [
            'message' => 'Cita agendada con exito'
        ];
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(UpdateAppointmentsRequest $request, $id): array|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        //load the appointment
        $appointment = Appointments::findOrFail($id);

        $data = $request->validated();

        $this->authorize('update', $appointment);

        // Check if there is already an appointment for the selected date and time
        if ($this->checkExistingAppointment($data['date'], $data['hour_id'])) {
            return $this->generateErrorResponse('Ya hay una cita programada para la fecha y hora seleccionadas.', 422);
        }

        $appointment->update($data);

        return [
            'message' => 'La cita se ha cambiado',
        ];
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy($id): array
    {
        // Cargar la cita
        $appointment = Appointments::findOrFail($id);

        $this->authorize('delete', $appointment);

        $appointment->delete();

        return [
            'message' => 'La cita se ha cancelado'
        ];
    }
}
