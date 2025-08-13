<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Compte_comptable extends Model

{



    protected $fillable = [ 

    	'id', 

        'numero',
        'libelle',
        'compartiment',
        'debiteur',
        'crediteur',
    	'sens',


    ];



}

