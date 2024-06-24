<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'date',
        'hour_id',
        'reason',
        'user_id',
        'status'
    ];

    //establece la relación inversa, indicando que un appointment pertenece a un user.
    // Obtener el user al que pertenece un appointment
    // $appointment = Appointments::find(1);
    // $user = $appointment->users;
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)->select(['id', 'name']);
    }

    public function pet(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pets::class)->select(['id', 'name']);
    }

    public function hour(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Hours::class)->select(['id', 'hour']);
    }
}
