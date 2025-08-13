<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Coffrefort extends Model
{
    protected $fillable = [ 

    	'name',
        'agence_id',
    	'compte_comptable_id',
    	'montant',

    ];
}

