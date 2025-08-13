<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Account extends Model

{

    protected $fillable = [ 
        'number_account',
        'type_account_id',
        'client_id',
        'solde_init',
        'solde',
        'statut',
        'date_cloture_compte',
        'date_ouverture_compte',
        'nom_prenom_signataire1', 
        'cni_signataire1', 
        'nom_prenom_signataire2', 
        'cni_signataire2', 
        'nom_prenom_signataire3', 
        'cni_signataire3', 
        'telephone_signataire1', 
        'telephone_signataire2', 
        'telephone_signataire3', 
        'pouvoir_signataires',
        'nom_heritier1', 
        'nom_heritier2', 
        'nom_heritier3', 
        'nom_mandataire', 
        'cni_mandataire',
        'telephone_mandataire',
        'pin_code',
        'nbr_jours_bloque',
        'interet_annuel',
        'solde_calcul_interets',
        'date_solde_calcul_interets',
        'date_calcul_interets',
        'tx_interet_cpte',
        'terme_cpte',
        'freq_calcul_int_cpte',
        'cpte_virement_clot',
        'mode_paiement_cpte',
        'date_clot',
        'solde_clot',
        'raison_clot',
        'mnt_bloq',
        'num_cpte',
        'raison_blocage',
        'date_blocage',
        'utilis_bloquant',
        'dat_prolongation',
        'dat_date_fin',
        'dat_num_certif',
        'dat_nb_prolong',
        'dat_decision_client',
        'dat_date_decision_client',
        'intitule_compte',
        'devise',
        'decouvert_max',
        'export_netbank',
        'id_dern_extrait_imprime',
        'decouvert_date_util',
        'num_last_cheque',
        'etat_chequier',
        'date_demande_chequier',
        'chequier_num_cheques',
        'mnt_min_cpte',
        'solde_part_soc_restant',
        'id_ag',
        'interet_a_capitaliser',
        'ancien_id_cpte',
        'dat_nb_reconduction',
        'num_cpte_comptable',
        'mnt_bloq_cre',
        'nbre_cycle',
        'id_cycle_en_cours',
        'user_id'
    ];
}




