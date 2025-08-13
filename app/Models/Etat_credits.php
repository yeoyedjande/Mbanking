<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etat_credits extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'nbre_jours',
        'id_etat_prec',
        'id_ag',
        'taux',
        'provisionne',
        'taux_prov_decouvert',
        'taux_prov_reechelonne',
    ];
}
