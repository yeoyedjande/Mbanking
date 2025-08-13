<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plafonds extends Model
{
    use HasFactory;

    protected $fillable = [

        'type_operation_id',
        'montant_min',
        'montant_max',

    ];
}
