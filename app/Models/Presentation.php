<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_stagiaire',
        'title',
        'lien',
        'status',
    ];

    public function stagiaire()
    {
        return $this->belongsTo(User::class, 'id_stagiaire');
    }
}
