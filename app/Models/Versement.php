<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Versement extends Model
{

    protected $fillable = [ 'ref', 'montant', 'account_id', 'user_id' ];

}
