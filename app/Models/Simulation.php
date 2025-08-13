<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{

    protected $fillable = [ 
    	'dossier','client_account', 'duree', 'date_deboursement', 'type_prod', 'amount', 'amount_commission', 'amount_assurances', 'amount_garantie_numeraire', 'amount_garantie_materiel', 'differe', 'taux_interet', 'periodicite', 'mode_calcul', 'delai', 'nbr_jr'
    ];

}
