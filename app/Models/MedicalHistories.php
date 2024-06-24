<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistories extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'date',
        'reasonConsult',
        'observations',
        'food',
        'frequencyFood'
    ];

    /*establishes the inverse relationship, indicating that a medical history belongs to a pet.
    * Get the pet that belongs to a medical history
    * $MedicalHistory = MedicalHistories::find($id);
    * $pet = $MedicalHistory->pets;
    */
    public function pets()
    {
        return $this->belongsTo(Pets::class);
    }

    public function previous_treatments()
    {
        return $this->hasMany(PreviousTreatment::class, 'medical_histories_id')->select(['id', 'name', 'date', 'medical_histories_id']);
    }

    public function surgical_procedures()
    {
        return $this->hasMany(SurgicalProcedures::class, 'medical_histories_id')->select(['id', 'name', 'date', 'medical_histories_id']);
    }
}
