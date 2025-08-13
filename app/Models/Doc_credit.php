<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doc_credit extends Model
{

    protected $fillable = [ 
    	'libelle', 
        'file',
    	'code',
    	'client_id'
    ];

}
