<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Mandataire extends Model

{



    protected $fillable = [ 

    	'account_id',
        'nom',
        'cni',
        'telephone',

    ];



}

