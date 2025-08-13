<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Agence extends Model

{



    protected $fillable = [ 

    	'name', 
    	'ville',
    	'quartier',
    	'tel',
    	'adresse',
        'banque_id',
        'user_id',

    ];



}

