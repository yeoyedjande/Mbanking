<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objet_demandes extends Model
{
    use HasFactory;

    protected $fillable = [ 

        'libelle', 

        'description',

    ];
}
