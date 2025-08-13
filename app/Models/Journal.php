<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [ 

    	'date',
        'debit',
    	'credit',
        'reference',
        'compte',
        'description',
        'fonction',
        'numero_piece',
        'intitule',
        'account_id',
        'user_id',
    	'agence_id',

    ];
}

