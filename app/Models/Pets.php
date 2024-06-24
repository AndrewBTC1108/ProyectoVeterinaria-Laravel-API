<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'species',
        'breed',
        'color',
        'sex',
        'user_id'
    ];
    /*
    * a pet can has many Histories
    * $pet = Pet::find($id)
    * $ClinicalHistories = $pet->medical_histories
    */
    public function medical_histories()
    {
        return $this->hasMany(MedicalHistories::class, 'pet_id')->select('id', 'date', 'reasonConsult', 'observations', 'food', 'frequencyFood', 'pet_id');
    }

    public function vaccines()
    {
        return $this->hasMany(Vaccine::class, 'pet_id')->select(['id', 'name', 'date', 'pet_id']);
    }

    public function previous_treatments()
    {
        return $this->hasMany(PreviousTreatment::class, 'pet_id')->select(['id', 'name', 'date', 'pet_id']);
    }

    public function dewormings()
    {
        return $this->hasMany(Deworming::class, 'pet_id')->select(['id', 'name', 'date', 'pet_id']);
    }

    public function surgical_procedures()
    {
        return $this->hasMany(SurgicalProcedures::class, 'pet_id')->select(['id', 'name', 'date', 'pet_id']);
    }
}
