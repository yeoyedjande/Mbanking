<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seuil extends Model
{

    protected $fillable = [ 
    	'type_operation_id', 
    	'periode',
    	'montant_limite',
    ];

}
