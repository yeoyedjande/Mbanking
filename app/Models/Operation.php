<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Operation extends Model

{



    protected $fillable = [ 

    	'type_operation_id', 

        'montant',
        'type_carte',
        'frais',
    	'serie_cheque',

        'account_id',

        'user_id',

        'ref',

        'date_op',

        'account_dest',

        'statut',
        'deposant_id',
        'motif',
        'type_personne',
        'type_piece',
        'num_piece',
        'date_delivrance_piece',
        'date_expiration_piece',
        'file_scanne_piece',
        'nom_porteur',
        'expediteur_virement_id',
        'compte_comptable_id',
        'heure_op'

    ];



}

