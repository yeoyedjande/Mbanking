<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //

    protected $fillable = [ 'name', 'description', 'groupe' ];


    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }
}
