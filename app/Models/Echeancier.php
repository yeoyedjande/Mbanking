<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echeancier extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_id',
        'dossier',
        'numero',
        'capital_attendu',
        'interet_attendu',
        'garantie_attendu',
        'penalite_attendu',
        'capital_remb',
        'interet_remb',
        'penalite_remb',
        'garantie_remb',
        'montant_total_remb',
        'echeance_cloture',
        'nbr_jour_retard',
        'date_echeance',
        'heure_echeance',
        'statut_paiement',
        'date_remb',
        'annul_remb',
        'his_id',
        'agence_id',
        'user_id',
    ];
}
