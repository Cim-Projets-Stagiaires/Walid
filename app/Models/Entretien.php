<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entretien extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_stagiaire',
        'date',
        'time',
        'status',
    ];
    public function stagiaire()
    {
        return $this->belongsTo(User::class, 'id_stagiaire');
    }
}
