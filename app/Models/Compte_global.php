<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Compte_global extends Model

{



    protected $fillable = [ 

    	'name', 

    	'montant',

        'compte_comptable_id',

    ];



}

