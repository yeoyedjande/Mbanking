<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Releve extends Model
{

    protected $fillable = [ 
        'account_id',
        'nombre_page',
        'prix_unitaire',
        'prix_total',
        'file',
    	'user_id',
    ];

}
