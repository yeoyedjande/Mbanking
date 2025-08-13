<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Correspondance extends Model

{



    protected $fillable = [ 

    	'date', 
    	'heure',
    	'nature',

        'quantite',

        'auteur_livraison',

    	'expediteur',

        'destinataire',

        'description',

        'user_id', 
          

    ];



}

