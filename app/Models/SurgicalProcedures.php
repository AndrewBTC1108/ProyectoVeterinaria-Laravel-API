<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurgicalProcedures extends Model
{
    use HasFactory;

    protected $fillable = ['pet_id', 'medical_histories_id', 'name', 'date'];

    public function medical_history()
    {
        return $this->belongsTo(MedicalHistories::class);
    }

    public function pets()
    {
        return $this->belongsTo(Pets::class);
    }
}
