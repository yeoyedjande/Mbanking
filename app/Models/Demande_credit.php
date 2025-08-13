<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Demande_credit extends Model

{



    protected $fillable = [ 

    	'client_id', 

        'raison_demande',

    	'montant_demande',

        'type_demande',

        'type_credit',

        'doc_demande',

        'statut',

        'acitivite_principal',
        'user_id',

    ];



}

