<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Demande_de_stage extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_stagiaire',
        'etablissement',
        'type_de_stage',
        'modalite_de_stage',
        'obligation',
        'status',
        'pole',
        'objectif_de_stage',
        'date_de_debut',
        'date_de_fin',
        'cv',
        'lettre_de_motivation'
    ];
    public function stagiaire()
    {
        return $this->belongsTo(User::class, 'id_stagiaire');
    }
}
