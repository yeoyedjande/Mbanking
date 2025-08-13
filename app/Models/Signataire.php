<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Signataire extends Model

{



    protected $fillable = [ 

    	'account_id',
        'nom_prenom',
        'cni',
        'telephone',

    ];



}

