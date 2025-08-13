<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;



class Client extends Authenticatable

{

    use HasFactory;
    protected $guard = 'client';

    protected $fillable = [ 

    	'nom', 
    	'prenom',
        'email',
    	'code_client',
    	'telephone',
    	'ville',
    	'adresse',
    	'residence',
    	'date_naissance',
        'lieu_naissance',
    	'solde',
        'raison_social',
        'nom_association',
        'nombre_membres',
        'commune',
        'quartier',
        'cni_client',
        'date_delivrance',
        'lieu_delivrance',
        'nationalite',
        'nom_conjoint',
        'profession',
        'employeur',
        'lieu_activite',
        'etat_civil',
        'agence_id',
        'login',
        'password',

    ];



    protected $hidden = [

        'password',

        'remember_token',

    ];



}

