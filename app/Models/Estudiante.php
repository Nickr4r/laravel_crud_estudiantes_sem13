<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';         
    protected $primaryKey = 'idEstudiante';    
    public $incrementing = true;              
    protected $keyType = 'int';                

    protected $fillable = [
        'nomEstudiante',
        'dirEstudiante',
        'ciuEstudiante'
    ];
}