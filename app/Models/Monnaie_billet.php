<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Monnaie_billet extends Model

{



    protected $fillable = [ 

    	'monnaie', 

    	'nombre',

    	'total',

        'date_jour',
    	'statuts',

    	'guichet',

    ];



}

