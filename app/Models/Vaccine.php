<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    protected $fillable = ['pet_id', 'name', 'date'];

    public function pets()
    {
        return $this->belongsTo(Pets::class);
    }
}
