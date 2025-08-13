<?php
  
namespace App\Models;
  
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
  
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'compte_comptable_id',
        'nom',
        'prenom',
        'phone',
        'photo',
        'agence_id',
        'email',
        'matricule',
        'role_id',
        'password',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'type_piece',
        'numero_piece',
        'adresse',
        'date_creation',
        'date_edit',
        'user_create',
        'user_edit',
        'statut',
        'superviseur',
        'gestionnaire',
    ];
  
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
  
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function hasPermission($permission) {

        if( in_array( $permission, $this->role->permissions()->pluck('name')->all() ) ){
            return true ;
        }
        return false;

    }
}