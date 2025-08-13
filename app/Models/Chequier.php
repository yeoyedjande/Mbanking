<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chequier extends Model
{

    protected $fillable = [ 
        'account_id', 
        'reference', 
        'date_order', 
        'heure_order', 
    	'type', 
    	'qte',
    	'montant',
    	'guichetier',
        'montant_total'
    ];

}
