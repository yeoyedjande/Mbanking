<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Main_account extends Model
{

    protected $fillable = [ 
    	'type_operation_id', 
        'solde_operation',
    	'solde_final',
    	'date_operation',
        'heure_operation',
    	'account_id',

    ];

}
