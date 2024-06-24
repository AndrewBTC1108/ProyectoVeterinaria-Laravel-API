<?php

namespace App\Http\Resources\AppointmentsResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HourResource extends JsonResource
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
            'hour' => $this->hour
        ];
    }
}
