<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model

{


    protected $fillable = [ 

    	'dossier', 
    	'avis',
    	'montant_propose',
        'garantie_avis',
        'nantissement_avis',
        'assurance_avis',
        'type_credit_avis',
        'versement_initial_avis',
        'periode_de_grace_avis',
        'commentaire_avis',
        'nom_et_prenom_avis',
        'date_avis',
        'taux',
        'user_id',

    ];



}

