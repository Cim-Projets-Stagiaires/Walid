<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rapport extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'type',
        'lien',
        'id_stagiaire',
        'status'
    ];

    public function stagiaire(){
        return $this->belongsTo(User::class,'id_stagiaire');
    }

    public function getRapportAttribute($value)
    {
        return asset('storage/rapports/' . $value);
    }
    
}
