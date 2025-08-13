<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Depense_revenue extends Model

{



    protected $fillable = [ 

    	'libelle', 
    	'sens',
    	'compte_comptable_id',
    	'type_mouvement',

    ];



}

