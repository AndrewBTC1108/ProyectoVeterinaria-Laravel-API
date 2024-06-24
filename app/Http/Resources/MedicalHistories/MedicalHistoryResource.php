<?php

namespace App\Http\Resources\MedicalHistories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'reasonConsult' => $this->reasonConsult,
            'observations' => $this->observations,
            'food' => $this->food,
            'frequencyFood' => $this->frequencyFood,
            'previous_treatments' => $this->whenLoaded('previous_treatments'),
            'surgical_procedures' => $this->whenLoaded('surgical_procedures')
        ];
    }
}
