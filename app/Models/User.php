<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'phone',
        'type',
        'email',
        'password',
        'profile_picture',
        'id_demande',
        'id_encadrant',
        'id_rapport',
        'permanent',
        'deleted',
    ];

    public function encadrant()
    {
        return $this->belongsTo(User::class, 'id_encadrant');
    }

    public function rapport()
    {
        return $this->hasMany(Rapport::class);
    }
    public function demande()
    {
        return $this->hasOne(Demande_de_stage::class, 'id', 'id_demande');
    }

    public function entretien()
    {
        return $this->hasOne(Entretien::class, 'id_stagiaire');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
