<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Mouvement extends Model
{

    protected $fillable = ['caisse_principal_id', 'solde_initial', 'solde_final', 'date_mvmt', 'heure_mvmt', 'solde_fermeture', 'date_mvmt_fermeture', 'heure_mvmt_fermeture', 'date_mvmt_annulation', 'solde_annulation', 'heure_mvmt_annulation', 'motif_annulation', 'user_id', 'verify', 'guichetier', 'motif_reajustement', 'date_reajustement', 'montant_reajustement', 'auteur_reajustement', 'reference_mvt', 'compte_comptable_id'];

}

