<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banquexterne extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'adresse',
        'pays',
        'montant',
        'compte_comptable_id',
    ];
}
