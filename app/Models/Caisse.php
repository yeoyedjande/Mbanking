<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{

    protected $fillable = [ 
    	'name', 
    	'agence_id',
        'montant',
    	'compte_comptable_id',
    	'user_id',
    ];

}
