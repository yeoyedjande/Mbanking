<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taux extends Model
{
    use HasFactory;

    protected $fillable = [ 

        'taux_commission', 

        'taux_interet',

        'taux_assurance',
        
        'is_active',

        'frais_de_dossier',

    ];

     protected $table = 'taux';
}
