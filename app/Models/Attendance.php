<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['id_stagiaire','date','entry_time','exit_time'];
    public function stagiaire()
{
    return $this->belongsTo(User::class,'id_stagiaire');
}
}
