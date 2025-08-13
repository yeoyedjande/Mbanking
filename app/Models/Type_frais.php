<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Type_frais extends Model
{
    protected $fillable = [ 
        'reference', 
        'name', 
        'montant', 
        'type_compte_id', 
        'frequence', 
        'description', 
    	'user_id'
    ];

}

