<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Client;
use App\Models\Devise;
use App\Models\Analyse;
use App\Models\Type_account;
use App\Models\Account;
use App\Models\Chequier;
use App\Models\Monnaie_billet;
use App\Models\Agence;
use App\Models\Operation;
use App\Models\Billet;
use App\Models\Avis;
use App\Models\Mouvement;
use App\Models\Caisse;
use App\Models\Type_operation;
use App\Models\Simulation;
use App\Models\Main_account;
use App\Models\Versement;
use App\Models\Taux_interet;
use App\Models\Permission;
use App\Models\Releve;
use App\Models\Doc_credit;
use App\Models\Demande_credit;
use App\Models\Demande_credit_doc;
use App\Models\Analyste_demande;
use App\Models\Operation_mouvement;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Gate;

use DB;
use Auth;
use setasign\Fpdi\PdfParser\PdfParser;


use Illuminate\Support\Facades\File;
use Dompdf\Dompdf;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set('Africa/Bujumbura');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        //dd(bcrypt('Client2023!'));
        $title = 'Tableau de bord';

        $solde_principal = Agence::Where('id', Auth::user()->agence_id)->first();

        $caisses = Mouvement::join('caisses', 'caisses.id', '=', 'mouvements.caisse_id')
        ->join('agences', 'agences.id', '=', 'caisses.agence_id')
        ->join('users', 'users.id', '=', 'mouvements.guichetier')
        ->select('caisses.*', 'mouvements.solde_initial', 'mouvements.verify', 'mouvements.solde_final','users.nom', 'users.prenom')
        ->Where('agences.id', Auth::user()->agence_id)
        ->Where('mouvements.date_mvmt', date('d/m/Y'))
        ->OrderBy('mouvements.date_mvmt', 'DESC')
        ->get();


        $verif_caisse =  Mouvement::Where('guichetier', Auth::user()->id)
        ->Where('date_mvmt', date('d/m/Y'))
        //->Where('verify', 'yes')
        ->first();

        //dd($verif_caisse);
        $solde_caisse =  Mouvement::Where('user_id', Auth::user()->id)
        ->Where('date_mvmt', date('d/m/Y'))
        ->get();

        /**Versement globale par agence**/
        $versement_globals = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->join('users', 'users.id', '=', 'operations.user_id')
        ->Where('users.agence_id', Auth::user()->agence_id)
        ->Where('operations.type_operation_id', 3)
        ->Where('operations.statut', 'valide')
        ->Where('operations.date_op', date('d/m/Y'))
        ->get();

        $som_versement_global = 0;
        foreach ($versement_globals as $key => $value) {
            $som_versement_global = $som_versement_global + $value->montant;
        }
        /***Fin versement globale par agence***/

        /**retrait globale par agence**/
        $retrait_globals = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->join('users', 'users.id', '=', 'operations.user_id')
        ->Where('users.agence_id', Auth::user()->agence_id)
        ->Where('operations.type_operation_id', 2)
        ->Where('operations.date_op', date('d/m/Y'))
        ->get();

        $som_retrait_global = 0;
        foreach ($retrait_globals as $key => $value) {
            $som_retrait_global = $som_retrait_global + $value->montant;
        }
        /***Fin retrait globale par agence***/


        /**Versement effectuer par un guichetier**/
        $versements = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->Where('operations.user_id', Auth::user()->id)
        ->Where('operations.type_operation_id', 3)
        ->Where('operations.statut', 'valide')
        ->Where('operations.date_op', date('d/m/Y'))
        ->get();

        $som_versement = 0;
        foreach ($versements as $key => $value) {
            $som_versement = $som_versement + $value->montant;
        }


        /***Fin versement effectuer par un guichetier***/


        /*** Retrait effectuer par un guichetier ***/
        $retraits = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->Where('operations.user_id', Auth::user()->id)
        ->Where('operations.type_operation_id', 2)
        ->Where('operations.date_op', date('d/m/Y'))
        ->get();

        $som_retrait = 0;
        foreach ($retraits as $key => $value) {
            $som_retrait = $som_retrait + $value->montant;
        }

        /*** Fin retrait effectuer par un guichetier ***/

        $som_solde_ouverture = 0;
        foreach ($solde_caisse as $key => $value) {
            $som_solde_ouverture = $som_solde_ouverture + $value->solde_initial;
        }


        /****COMPTE PRINCIPAL (GRAND LIVRE)****/
        $retrait_p = Main_account::Where('type_operation_id', 2)
        //->Where('operations.date_op', date('d/m/Y'))
        ->get();

        $versement_p = Main_account::Where('type_operation_id', 3)
        //->Where('operations.date_op', date('d/m/Y'))
        ->get();

        $som_retrait_p = 0;

        foreach ($retrait_p as $key => $value) {
            $som_retrait_p = $som_retrait_p + $value->solde_final;
        }

        $som_versement_p = 0;

        foreach ($versement_p as $key => $value) {
            $som_versement_p = $som_versement_p + $value->solde_final;
        }


        $total_cp = $som_retrait_p - $som_versement_p;

        /***FIN GRNAD LIVRE****/


        $transactions = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom', 'operations.montant', 'type_operations.name', 'accounts.number_account')
        ->Where('operations.statut', 'valide')
        ->orderBy('operations.id', 'DESC')
        ->paginate(6);

        $transactions_caissier = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->Where('operations.user_id', Auth::user()->id)
        ->Where('operations.date_op', date('d/m/Y'))
        ->Where('operations.statut', 'valide')
        ->select('operations.*', 'clients.nom', 'clients.prenom', 'operations.montant', 'type_operations.name', 'accounts.number_account')
        ->orderBy('operations.id', 'DESC')
        ->paginate(6);

        $nb_client = Client::count();

        $nb_demande = Demande_credit::Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.id')
       //->Where('demande_credits.user_id', Auth::user()->id)
       ->count();

       $demandes = Demande_credit::Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.id')
       ->Where('demande_credits.user_id', Auth::user()->id)
       ->Select('demande_credits.*', 'clients.nom', 'clients.prenom')
       ->OrderBy('demande_credits.created_at', 'DESC')
       ->get();

       //dd($demandes);
        $billets = Billet::all();

        /**Caisse echec fermeture**/

            $mvmt = Mouvement::Where('guichetier', Auth::user()->id)
            ->Where('date_mvmt', date('d/m/Y'))
            ->first();

            if ($mvmt) {
                // code...
            
                $solde_cash = $mvmt->solde_fermeture;
                $solde_final = $mvmt->solde_final;


                if ( intval($solde_cash) >= intval($solde_final) ) {
                    
                    $diff = intval($solde_cash) - intval($solde_final);

                }else{
                    $diff = intval($solde_final) - intval($solde_cash);
                }

            }else{
                $solde_cash = 0;
                $solde_final = 0;
                $diff = 0;
            }

        /**Fin echec fermeture**/

        /**Cloture de caisse**/
        $data_fermeture = Mouvement::join('caisses', 'caisses.id', '=', 'mouvements.caisse_id')
        ->join('users', 'users.id', '=', 'mouvements.guichetier')
        ->Where('mouvements.date_mvmt', date('d/m/Y'))
        ->Where('mouvements.guichetier', Auth::user()->id)
        ->select('mouvements.*', 'caisses.name', 'users.nom', 'users.prenom')
        ->first();
        /**Fin cloture**/

        $accountCount = Account::count();

        return view('pages.dashboard.dashboard')
        ->with('transactions_caissier', $transactions_caissier)
        ->with('transactions', $transactions)
        ->with('nb_client', $nb_client)
        ->with('solde_cash', $solde_cash)
        ->with('accountCount', $accountCount)
        ->with('solde_final', $solde_final)
        ->with('diff', $diff)
        ->with('data_fermeture', $data_fermeture)
        ->with('nb_demande', $nb_demande)
        ->with('demandes', $demandes)
        ->with('caisses', $caisses)
        ->with('solde_principal', $solde_principal)
        ->with('billets', $billets)
        ->with('som_versement', $som_versement)
        ->with('som_retrait', $som_retrait)
        ->with('som_versement_global', $som_versement_global)
        ->with('som_retrait_global', $som_retrait_global)
        ->with('som_solde_ouverture', $som_solde_ouverture)
        ->with('verif_caisse', $verif_caisse)
        ->with('total_cp', $total_cp)
        ->with('title', $title);
    }


        public function transactionAttente()
    {
        $title = "Transaction en attente de validation";

        $transactionsAttente = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom', 'operations.montant', 'type_operations.name', 'accounts.number_account')
        ->Where('operations.statut', 'invalid')
        ->orderBy('operations.id', 'DESC')
        ->get();

        //dd($transactionsAttente);
        return view('pages.transactions.index')
        ->with('title', $title)
        ->with('transactionsAttente', $transactionsAttente);
    }

    public function transactionAttenteValid(Request $request)
    {
        $title = "Transaction en attente de validation";

        if ( $request->name == 'Retrait' ) {
            
                $account = Account::Where('number_account', $request->num_account)->first();
            
                if ( intval($account->solde) < intval($request->amount) ) {
                    $request->session()->flash('msg_error', 'Le montant que vous voulez retirer est superieur au solde du client, Veuillez réajuster !');
                    return back();
                }

                Operation::Where('id', $request->operation_id)
                ->update([
                    'montant' => $request->amount,
                    'statut' => 'valide',
                    'date_op' => date('d/m/Y'),
                    'heure_op' => date('H:i:s'),
                ]);




            //Cumul du solde
            /** Mise a jour du compte client **/
            
            Account::Where('number_account', $request->num_account)
            ->update([
                'solde' => intval($account->solde) - intval($request->amount),
            ]);
            /** Fin Mise a jour du compte client **/

            /** Mise a jour de la caisse du guichetier **/
            $mvmt = Mouvement::Where('guichetier', $request->user_id)
            ->Where('date_mvmt', date('d/m/Y'))
            ->first();

            Mouvement::Where('id', $mvmt->id)
            ->update([
                'solde_final' => intval($mvmt->solde_final) - intval($request->amount),
            ]);
            /** Fin Mise a jour de la caisse du guichetier **/


            /**Mise a jour du solde principal**/
            $user = User::Where('id', $request->user_id)->first();
            $agence = Agence::Where('id', $user->agence_id)
            ->first();

            Agence::Where('id', $agence->id)
            ->update([
                'solde_principal' => intval($agence->solde_principal) + intval($request->amount),
            ]);

            $balance = Main_account::latest()->first();

            Main_account::create([

                'type_operation_id' => 2,
                'solde_operation' => $request->amount,
                'solde_final' => $request->amount,
                'account_id' => $request->num_account,
                'date_operation' => date('d/m/Y'),
                'heure_operation' => date('H:i:s'),

            ]);
            /**Fin mise a jour **/


            $request->session()->flash('msg_success', 'Vous avez valider le retrait avec succès!');

 
        }elseif( $request->name == 'Versement' ){

            Operation::Where('id', $request->operation_id)
            ->update([
                //'montant' => $request->amount,
                'date_op' => date('d/m/Y'),
                'heure_op' => date('H:i:s'),
                'statut' => 'valide',
            ]);


            //Cumul du solde
            /** Mise a jour du compte client **/
            $account = Account::Where('number_account', $request->num_account)->first();
            
            Account::Where('number_account', $request->num_account)
            ->update([
                'solde' => intval($account->solde) + intval($request->amount),
            ]);
            /** Fin Mise a jour du compte client **/

            /** Mise a jour de la caisse du guichetier **/
            $mvmt = Mouvement::Where('guichetier', $request->user_id)
            ->Where('date_mvmt', date('d/m/Y'))
            ->first();

            Mouvement::Where('id', $mvmt->id)
            ->update([
                'solde_final' => intval($mvmt->solde_final) + intval($request->amount),
            ]);
            /** Fin Mise a jour de la caisse du guichetier **/


            /**Mise a jour du solde principal**/
            $user = User::Where('id', $request->user_id)->first();
            $agence = Agence::Where('id', $user->agence_id)
            ->first();

            Agence::Where('id', $agence->id)
            ->update([
                'solde_principal' => intval($agence->solde_principal) - intval($request->amount),
            ]);
            /**Fin mise a jour **/

            Main_account::create([

                'type_operation_id' => 3,
                'solde_operation' => $request->amount,
                'solde_final' => $request->amount,
                'account_id' => $request->num_account,
                'date_operation' => date('d/m/Y'),
                'heure_operation' => date('H:i:s'),

            ]);

            $request->session()->flash('msg_success', 'Le versement a été validé avec succès!');

        }else{

            Operation::Where('id', $request->operation_id)
            ->update([
                'montant' => $request->amount,
                'date_op' => date('d/m/Y'),
                'heure_op' => date('H:i:s'),
                'statut' => 'valide',
                'user_id' => Auth::user()->id,
            ]);

            /**Expediteur**/
            $solde_exp = Account::Where('number_account', $request->num_account)->first();
            
            Account::Where('number_account', $request->num_account)
            ->update([
                'solde' => intval($solde_exp->solde) - intval($request->amount) 
            ]);
            /**Fin Expediteur**/

            /**Destinateur**/
            $solde_dest = Account::Where('number_account', $request->num_account_dest)->first();
            
            Account::Where('number_account', $request->num_account_dest)
            ->update([
                'solde' => intval($solde_dest->solde) + intval($request->amount) 
            ]);
            /**Fin Destinateur**/

            $request->session()->flash('msg_success', 'Virement passé avec succès !');
        }

        return back()
        ->with('title', $title);
    }

    /***ROLES***/
    public function roles()
    {

        if (! Gate::allows('is-admin')) {
            return view('errors.403');
        }
        
        $title = "Rôles";
        $roles = Role::OrderBy('name', 'ASC')->get();
        return view('pages.users.role')
        ->with('title', $title)
        ->with('roles', $roles);
    }

    public function roleAdd(Request $request)
    {
        $title = "Creer Rôles";

        if ( !isset($request->nom) || empty($request->nom) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le nom du Rôle');
        }else{

            $roleExist = Role::Where('name', ucwords($request->nom))->first();

            if ( $roleExist  ) {
                $request->session()->flash('msg_error', 'Ce rôle existe deja !');
            }else{

                //Ajout d'un role
                Role::create([
                    'name' => $request->nom,
                    'guard_name' => $request->description
                ]);
                $request->session()->flash('msg_success', 'Vous avez ajouté un Rôle succès!');

            }
            
        }

        return back()
        ->with('title', $title);
    }

    public function roleEdit(Request $request)
    {
        $title = "Editer rôle";

        if ( !isset($request->nom) || empty($request->nom) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le nom du Rôle');
        }else{

                Role::Where('id', $request->edit_id)
                ->update([
                    'name' => $request->nom,
                    'guard_name' => $request->description
                ]);

                $request->session()->flash('msg_success', 'Vous avez modifié ce rôle succès!');

        }

        return back()
        ->with('title', $title);
    }

    public function roleDel(Request $request)
    {
        
        Role::findOrFail($request->id)->delete();
        $request->session()->flash('msg_error', 'Vous avez supprimé ce role avec succès!');

        return back();
    }
    /***FIN ROLES***/


    /***PRET***/
    public function pretNew()
    {
        $title = "Demande de Prêt";

        return view('pages.prets.new')
        ->with('title', $title);
    }

    public function pretNew2(Request $request)
    {
        $title = "Demande de Prêt";

        if ( !isset( $request->num_account ) || empty($request->num_account) ) {
            
            $request->session()->flash('msg_error', 'Vous devez saisir le numero du compte client');

        }else{

            $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('accounts.number_account', $request->num_account)
            ->first();

            if ( $data ) {
                $type_credits = DB::table('type_credits')->latest()->get();
                return view('pages.prets.new-2')
                ->with('type_credits', $type_credits)
                ->with('data', $data)
                ->with('title', $title);
            }else{
                $request->session()->flash('msg_error', 'Le numero du compte que vous avez saisi ne correspond a aucun compte. Merci de renseigner un bon numero de compte.');
                return back()
                ->with('title', $title);
            }

        }
    }

    public function simulation_new($id)
    {

        $title = "Faire une simulation";
        $demande = Demande_credit::Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
       ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'demande_credits.id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.id')
       ->Select('demande_credits.*', 'clients.nom', 'clients.prenom')
       ->OrderBy('demande_credits.created_at', 'DESC')
       ->Where('analyste_demandes.analyste', Auth::user()->id)
       ->Where('demande_credits.id', $id)
       ->first();

       $type_credits = DB::table('type_credits')->latest()->get();
       //dd($demande);


        return view('pages.credits.simulation')
        ->with('title', $title)
        ->with('type_credits', $type_credits)
        ->with('demande', $demande);
    }

    public function pretSimualation(Request $request)
    {

        $title = 'Simulation';

        $number_account = $request->num_account;
        $duree = $request->duree_credit;
        $date = $request->date_deboursement;

        $amount_frais = $request->amount_frais;

        $periode = $request->periode;
        $type_credit = $request->type_credit;

        $amount = intval(str_replace(' ', '', $request->amount));
        $amount_commission = intval(str_replace(' ', '', $request->amount_commission));
        $amount_assurances = intval(str_replace(' ', '', $request->amount_assurances));


        $taux_interet = $request->taux_interet;
        $description = $request->description;


        /**Client**/
        $accountClient = Account::join('clients', 'clients.id', '=', 'accounts.client_id')
        ->Where('accounts.number_account', $request->num_account)
        ->first();

        //dd($duree);
        /**Fin client**/

        /**Calcul des capitaux**/
        $capital = $amount / $duree;
        $montant_total_rembourse = intval(round($capital)) * $duree;
        $montant_dernier = intval(round($capital)) - ( $montant_total_rembourse - $amount );
        
        /**Fin Calcul des capitaux**/


        /**Calcul des interets**/
        $interet_mensuel = $amount * ($taux_interet / 100) * ($duree / 12);
        $interet_mensuel = $interet_mensuel / $duree;

        $montant_total_rembourse = intval(round($capital)) * $duree;
        $montant_dernier = intval(round($capital)) - ( $montant_total_rembourse - $amount );

        /**Fin Calcul des interets**/
        
        $interet_total = 0;
        
        for ($i=1; $i <= $duree; $i++) { 
            $interet_total = $interet_mensuel + $interet_total;
        }
        $interet_solde_total = $interet_total;

        return view('pages.credits.result_simulation')
        ->with('duree', $duree)
        ->with('amount', $amount)
        ->with('taux_interet', $taux_interet)
        ->with('amount_frais', $amount_frais)
        ->with('amount_assurances', $amount_assurances)
        ->with('amount_commission', $amount_commission)
        ->with('date', $date)
        ->with('interet_solde_total', $interet_solde_total)
        ->with('accountClient', $accountClient)
        ->with('interet_mensuel', $interet_mensuel)
        ->with('number_account', $number_account)
        ->with('capital', $capital)
        ->with('periode', $periode)
        ->with('type_credit', $type_credit)
        ->with('montant_dernier', $montant_dernier)
        ->with('title', $title);
    }

    public function pretSimualationValidate(Request $request)
    {

        //dd('Validation Simulation');

        Simulation::create([

            'client_account' => $request->client_account, 
            'duree' => $request->duree, 
            'date_deboursement' => $request->date_deboursement, 
            'type_prod' => $request->type_prod, 
            'amount' => $request->amount, 
            'amount_commission' => $request->amount_commission, 
            'amount_assurances' => $request->amount_assurances, 
            'amount_garantie_numeraire' => $request->amount_garantie_numeraire, 
            'amount_garantie_materiel' => $request->amount_garantie_materiel, 
            'differe' => $request->differe, 
            'taux_interet' => $request->taux_interet, 
            'periodicite' => $request->periodicite, 
            'mode_calcul' => $request->mode_calcul, 
            'delai' => $request->delai, 
            'nbr_jr' => $request->nbr_jr
            
        ]);

        $request->session()->flash('msg_success', 'Vous avez enregistrer la simulation avec succes!');

        return redirect()->route('simulation-succes');

    }


    public function succes_simulation()
    {
        
        return view('pages.credits.succes_simulation');

    }


    /***FIN PRET***/

    /***VERSEMENTS***/

    public function versements()
    {
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        $title = "Versements du ".date('d/m/Y');

        $versements = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom')
        ->Where('operations.user_id', Auth::user()->id)
        ->Where('operations.date_op', date('d/m/Y'))
        ->Where('operations.statut', 'valide')
        ->Where('operations.type_operation_id', 3)
        ->OrderBy('operations.id', 'DESC')
        ->get();


        $verif_caisse =  Mouvement::Where('guichetier', Auth::user()->id)
        ->Where('date_mvmt', date('d/m/Y'))
        ->first();

        if (isset($verif_caisse)) {
            
        
        if ($verif_caisse->verify == 'no') {
            return redirect()->route('dashboard');
        }else{
            return view('pages.versements.index')
            ->with('versements', $versements)
            ->with('title', $title);
        }

    }else{
        return redirect()->route('dashboard');
    }

    }


    public function versementStart()
    {
        return view('pages.versements.demarrage');
    }

    public function versementNew()
    {
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        $title = "Faire un versement";

        $accounts = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
        ->get();

        return view('pages.versements.new')
        ->with('accounts', $accounts)
        ->with('title', $title);
    }

    public function versementSearchAccount(Request $request)
    {
       
        //dd($request->num_account);
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        $title = "Faire un versement";

        if ( !isset( $request->flash ) || empty($request->flash) ) {
            
            $request->session()->flash('msg_error', 'Vous devez saisir le numero du compte client');
            return back();

        }else{

            $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('accounts.number_account', trim($request->flash))
            ->first();

            $versements = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
            ->join('clients', 'clients.id', '=', 'accounts.client_id')
            ->select('operations.*', 'clients.nom', 'clients.prenom')
            ->Where('operations.date_op', date('d/m/Y'))
            ->Where('operations.account_id', $request->flash)
            ->Where('operations.statut', 'valide')
            ->Where('operations.type_operation_id', 3)
            ->get();

            $cumulVersementJour = 0;

            foreach ($versements as $v) {
                $cumulVersementJour = $cumulVersementJour + $v->montant;
            }

            if ( $data ) {
                //dd($data);
                return view('pages.versements.new')
                ->with('cumulVersementJour', $cumulVersementJour)
                ->with('data', $data)
                ->with('title', $title);

            }else{
                $request->session()->flash('msg_error', 'Le numero du compte que vous avez saisi ne correspond a aucun compte. Merci de renseigner un bon numero de compte.');
                return back()
                ->with('title', $title);
            }

        }
       
    }

    public function versementNewValid(Request $request)
    {
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        $title = "Faire un versement";

        //dd($request->amount);
 
       // $amount = intval(str_replace(' ', '', $request->amount));
        
        $amount = $request->amount;

        if ( !isset( $request->amount ) || empty($request->amount) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le montant a verser');
        }else{
            
            /**Cumul des versements de la journee**/
            $versements = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
            ->join('clients', 'clients.id', '=', 'accounts.client_id')
            ->select('operations.*', 'clients.nom', 'clients.prenom')
            ->Where('operations.date_op', date('d/m/Y'))
            ->Where('operations.account_id', $request->num_account)
            ->Where('operations.statut', 'valide')
            ->Where('operations.type_operation_id', 3)
            ->get();

            $cumulVersementJour = 0;

            foreach ($versements as $v) {
                $cumulVersementJour = $cumulVersementJour + $v->montant;
            }
            //On ajoute le montant recent sur le somme des operations obetenu
            $cumulVersementJourFinal = $cumulVersementJour + $amount;

            $mvmt = Mouvement::Where('guichetier', Auth::user()->id)
            ->Where('date_mvmt', date('d/m/Y'))
            ->first();

            $type_op = Type_operation::Where('id', 3)->first();

            //Versement sur le compte du client
            $init = "REF-VERS-";
            $rand = rand(111111, 999999);
            $date = date("Ymd");

            $code = $init.$rand.$date;

            $montant_limit = 20000000;
            //$montant_limit_start = 500001;

            if ( $cumulVersementJourFinal > $montant_limit ) {
                
                $operation = Operation::create([
                    'ref' => $code,
                    'montant' => $amount,
                    'type_operation_id' => $type_op->id,
                    'account_id' => $request->num_account,
                    'date_op' => date('d/m/Y'),
                    'heure_op' => date('H:i:s'),
                    'statut' => 'invalid',
                    'nom_deposant' => $request->nom_deposant,
                    'tel_deposant' => $request->tel_deposant,
                    'motif_depot' => $request->motif_versement,
                    'user_id' => Auth::user()->id,
                ]);

                Operation_mouvement::create([
                    'operation_id' => $operation->id,
                    'mouvement_id' => $mvmt->id
                ]);

                $attentes = 'invalid';
                $title = 'Faire un versement';
                
                $request->session()->flash('msg_info', 'Important: Vous avez lancé un retrait qui depasse le grand seuil limite, donc le service des operations et la Direction analyseront pour validation !');

                return back()
                ->with('attentes', $attentes)
                ->with('title', $title);

                

            }/*elseif(($amount > $montant_limit_start) && ($amount <= $montant_limit)){

                
                $operation = Operation::create([
                    'ref' => $code,
                    'montant' => $amount,
                    'type_operation_id' => $type_op->id,
                    'account_id' => $request->num_account,
                    'date_op' => date('d/m/Y'),
                    'heure_op' => date('H:i:s'),
                    'statut' => 'invalid',
                    'nom_deposant' => $request->nom_deposant,
                    'tel_deposant' => $request->tel_deposant,
                    'motif_depot' => $request->motif_versement,
                    'user_id' => Auth::user()->id,
                ]);

                Operation_mouvement::create([
                    'operation_id' => $operation->id,
                    'mouvement_id' => $mvmt->id
                ]);

                $attentes = 'invalid';
                $title = 'Faire un versement';
                
                $request->session()->flash('msg_info', 'Important: Vous avez lancé un retrait qui depasse le seuil, donc le service des operations analysera pour validation !');

                return back()
                ->with('attentes', $attentes)
                ->with('title', $title);
                

            }*/else{

                $operation = Operation::create([
                    'ref' => $code,
                    'montant' => $amount,
                    'type_operation_id' => $type_op->id,
                    'account_id' => $request->num_account,
                    'date_op' => date('d/m/Y'),
                    'heure_op' => date('H:i:s'),
                    'nom_deposant' => $request->nom_deposant,
                    'tel_deposant' => $request->tel_deposant,
                    'motif_depot' => $request->motif_versement,
                    'user_id' => Auth::user()->id,
                ]);

                Operation_mouvement::create([
                    'operation_id' => $operation->id,
                    'mouvement_id' => $mvmt->id
                ]);

            //Cumul du solde
            /** Mise a jour du compte client **/
            $account = Account::Where('number_account', $request->num_account)->first();
            
            Account::Where('number_account', $request->num_account)
            ->update([
                'solde' => intval($account->solde) + $amount,
            ]);
            /** Fin Mise a jour du compte client **/

            /** Mise a jour de la caisse du guichetier **/
            

            //dd($mvmt);

            Mouvement::Where('id', $mvmt->id)
            ->update([
                'solde_final' => intval($mvmt->solde_final) + $amount,
            ]);
            /** Fin Mise a jour de la caisse du guichetier **/


            /**Mise a jour du solde principal**/
            $agence = Agence::Where('id', Auth::user()->agence_id)
            ->first();

            Agence::Where('id', $agence->id)
            ->update([
                'solde_principal' => intval($agence->solde_principal) - $amount,
            ]);
            /**Fin mise a jour **/

            Main_account::create([

                'type_operation_id' => 3,
                'solde_operation' => $amount,
                'solde_final' => $amount,
                'account_id' => $request->num_account,
                'date_operation' => date('d/m/Y'),
                'heure_operation' => date('H:i:s'),

            ]);



            $request->session()->flash('msg_success', 'Vous avez effectuer le versement avec succès!');
            return redirect()->route('versement-validate', strtolower($code));
            }

        }

        
    }



    public function versementHistorique()
    {
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        $title = "Historiques des versements";

        $versements = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom')
        ->Where('operations.user_id', Auth::user()->id)
        ->Where('operations.type_operation_id', 3)
        ->Where('operations.statut', 'valide')
        ->OrderBy('operations.id', 'DESC')
        ->get();

        return view('pages.versements.historique')
        ->with('versements', $versements)
        ->with('title', $title);
    }

    public function VersementValidate($ref)
    {

        $ref = $ref;
        return view('pages.versements.succes_versement')
        ->with('ref', $ref);

    }


    public function VersementPrint($ref)
    {

        $data = [
            
            'logo' => 'assets/images/logo/hopeFund.png',
            'v' => Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
                ->join('clients', 'clients.id', '=', 'accounts.client_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->join('agences', 'agences.id', '=', 'users.agence_id')
                ->select('operations.*', 'clients.nom', 'clients.prenom', 'agences.name as nom_agence', 'users.matricule')
                ->Where('operations.user_id', Auth::user()->id)
                ->Where('operations.type_operation_id', 3)
                ->Where('operations.ref', strtoupper($ref))
                ->OrderBy('operations.id', 'DESC')
                ->first()
        ];
        
        //dd($data);
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.versements.print', $data)->render();

        // Convertir la vue en PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'portrait'); 

        $dompdf->render();

        // Générer le fichier PDF
        $output = $dompdf->output();
        
        // Enregistrer le fichier PDF
        $filename = date('dmY').'-recu_versement.pdf';
        file_put_contents($filename, $output);
        
        //$dompdf->stream();

        // Retourner une réponse avec le nom de fichier pour le téléchargement
       // return response()->loadView($filename);
        return $dompdf->stream($filename, ['Attachment' => false]);
        //return view('pages.caisses.print_close_caisse');
    }

    /***FIN VERSEMENTS***/

    /***RETRAITS***/
    public function retraits()
    {
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        $title = "Retraits du ".date('d/m/Y');

        

        $retraits = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom')
        ->Where('operations.user_id', Auth::user()->id)
        ->Where('operations.date_op', date('d/m/Y'))
        ->Where('operations.type_operation_id', 2)
        ->OrderBy('operations.id', 'DESC')
        ->get();


        $verif_caisse =  Mouvement::Where('guichetier', Auth::user()->id)
        ->Where('date_mvmt', date('d/m/Y'))
        ->first();


        if (isset($verif_caisse)) {
            
        if ($verif_caisse->verify == 'no') {
            return redirect()->route('dashboard');
        }else{
            return view('pages.retraits.index')
            ->with('retraits', $retraits)
            ->with('title', $title);
        }

    }else{

        return redirect()->route('dashboard');
    }

    }

    public function retraitHistorique()
    {
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        $title = "Historiques des Retraits";

        $retraits = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom')
        ->Where('operations.user_id', Auth::user()->id)
        ->Where('operations.type_operation_id', 2)
        ->OrderBy('operations.id', 'DESC')
        ->get();

        return view('pages.retraits.historique')
        ->with('retraits', $retraits)
        ->with('title', $title);
    }

    public function retraitStart()
    {
        return view('pages.retraits.demarrage');
    }
    public function retraitNew()
    {
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        $title = "Faire un retrait";

        $accounts = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
        ->get();

        return view('pages.retraits.new')
        ->with('accounts', $accounts)
        ->with('title', $title);
    }

    public function retraitSearchAccount(Request $request)
    {
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        $title = "Faire un retrait";

        if ( !isset( $request->flash ) || empty($request->flash) ) {
            
            $request->session()->flash('msg_error', 'Vous devez saisir le numero du compte client');

        }else{

            $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('accounts.number_account', $request->flash)
            ->first();

            $retraits = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
            ->select('operations.*')
            ->Where('operations.date_op', date('d/m/Y'))
            ->Where('operations.account_id', $request->flash)
            ->Where('operations.type_operation_id', 2)
            ->get();

            $cumulRetraitJour = 0;

            foreach ($retraits as $r) {
                $cumulRetraitJour = $cumulRetraitJour + $r->montant;
            }


            $retraitMois = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
            ->select(DB::raw('SUM(operations.montant) as total_retraits'))
            ->where('operations.account_id', $request->flash)
            ->where('operations.type_operation_id', 2)
            ->whereRaw('MONTH(operations.date_op) = ?', [date('m')])
            ->get();

            $cumulRetraitMonth = 0;

            foreach ($retraitMois as $r) {
                $cumulRetraitMonth = $cumulRetraitMonth + $r->montant;
            }

            if ( $data ) {
                return view('pages.retraits.new')
                ->with('data', $data)
                ->with('cumulRetraitJour', $cumulRetraitJour)
                ->with('cumulRetraitMonth', $cumulRetraitMonth)
                ->with('title', $title);
            }else{
                $request->session()->flash('msg_error', 'Le numero du compte que vous avez saisi ne correspond a aucun compte. Merci de renseigner un bon numero de compte.');
                return back()
                ->with('title', $title);
            }

        }
    }

    public function retraitNewValid(Request $request)
    {
        
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        //dd($request->filename);

        $title = "Faire un retrait";

        //$amount = intval(str_replace(' ', '', $request->amount));

        $amount = intval($request->amount);



        if ( !isset($request->amount) || empty($request->amount) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le montant a retirer');
        }else{
            
            $mvmt = Mouvement::Where('guichetier', Auth::user()->id)
            ->Where('date_mvmt', date('d/m/Y'))
            ->first();

            /// $filename = $request->file_piece;
            ////$filePath = public_path().'/assets/docs/pieces/'.$filename;

            ////$ext = File::extension($filePath);
            ////$name = time().'.'.$ext;

            ////File::move($filePath, public_path().'/assets/docs/pieces/'.$name);

           /**CUMUL DES RETRAITS PAR JOUR**/
           $retraits = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
            ->select('operations.*')
            ->Where('operations.date_op', date('d/m/Y'))
            ->Where('operations.account_id', $request->num_account)
            ->Where('operations.type_operation_id', 2)
            ->get();

            $cumulRetraitJour = 0;

            foreach ($retraits as $r) {
                $cumulRetraitJour = $cumulRetraitJour + $r->montant;
            }

            $cumulRetraitJourFinal = $cumulRetraitJour + $amount;

            /**FIN CUMUL DES RETRAITS PAR JOUR**/

            /**CUMUL DES RETRAITS PAR MOIS**/

            $retraits = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
            ->select(DB::raw('SUM(operations.montant) as total_retraits'))
            ->where('operations.account_id', $request->num_account)
            ->where('operations.type_operation_id', 2)
            ->whereRaw('MONTH(operations.date_op) = ?', [date('m')])
            ->get();

            $cumulRetraitMonth = 0;

            foreach ($retraits as $r) {
                $cumulRetraitMonth = $cumulRetraitMonth + $r->montant;
            }

            $cumulRetraitMonthFinal = $cumulRetraitMonth + $amount; 


            /**FIN CUMUL DES RETRAITS PAR MOIS**/
            $type_op = Type_operation::Where('id', 2)->first();

            //Versement sur le compte du client
            $init = "REF-RET-";
            $rand = rand(111111, 999999);
            $date = date("Ymd");

            $code = $init.$rand.$date;

            $montant_limit_jour = 15000000;
            $montant_limit_mois = 100000000;
            $montant_limit_operation = 1000000;


            if ( $request->type_personne === 'porteur' ) {
                
                $limit_porteur = 500000;

                if ( $amount > $limit_porteur ) {
                    $request->session()->flash('msg_error', 'Un porteur de cheque ne peut pas effectuer une operation de plus de 500 000 BIF !');
                    return back();
                }else{
                    
                    $account = Account::Where('number_account', $request->num_account)->first();



                    $operation = Operation::create([
                        'ref' => $code,
                        'montant' => $amount,
                        'type_operation_id' => $type_op->id,
                        'account_id' => $request->num_account,
                        'type_personne' => $request->type_personne,
                        'type_piece' => $request->type_piece,
                        'num_piece' => $request->num_piece,
                        'type_carte' => $request->type_carte,
                        'frais' => $request->frais,
                        'serie_cheque' => $request->serie_cheque,
                        'nom_porteur' => $request->nom_porteur,
                        'date_delivrance_piece' => $request->date_delivrance_piece,
                        'date_expiration_piece' => $request->date_expiration_piece,
                        'date_op' => date('d/m/Y'),
                        'heure_op' => date('H:i:s'),
                        'user_id' => Auth::user()->id,
                    ]);
 
                    Operation_mouvement::create([
                        'operation_id' => $operation->id,
                        'mouvement_id' => $mvmt->id
                    ]);

                    Account::Where('number_account', $request->num_account)
                    ->update([
                        'solde' => intval($account->solde) - intval($amount+$request->frais),
                    ]);
                    /** Fin Mise a jour du compte client **/

                    /** Mise a jour de la caisse du guichetier **/
                

                    Mouvement::Where('id', $mvmt->id)
                    ->update([
                        'solde_final' => intval($mvmt->solde_final) - $amount,
                    ]);
                    /** Fin Mise a jour de la caisse du guichetier **/


                    /**Mise a jour du solde principal**/
                    $agence = Agence::Where('id', Auth::user()->agence_id)
                    ->first();

                    Agence::Where('id', $agence->id)
                    ->update([
                        'solde_principal' => intval($agence->solde_principal) + intval($amount+$request->frais),
                    ]);

                    $balance = Main_account::latest()->first();

                    Main_account::create([

                        'type_operation_id' => 2,
                        'solde_operation' => $amount,
                        'solde_final' => $amount,
                        'account_id' => $request->num_account,
                        'date_operation' => date('d/m/Y'),
                        'heure_operation' => date('H:i:s'),

                    ]);
                    /**Fin mise a jour **/

                    $request->session()->flash('msg_success', 'Vous avez effectuer le retrait avec succès!');

                    }
                return redirect()->route('retrait-validate', strtolower($code));
                //return back()->with('title', $title);

            }else{

                
                //dd('autres');
                if ( ($cumulRetraitJourFinal > $montant_limit_jour) && ($cumulRetraitJourFinal < $montant_limit_mois) ) {
                    
                    $account = Account::Where('number_account', $request->num_account)->first();
                
                    if ( intval($account->solde) < intval($amount) ) {
                        $request->session()->flash('msg_error', 'Le montant que vous voulez retirer est superieur au solde du client, Veuillez réajuster !');
                        return back();
                    }

                    $operation = Operation::create([
                        'ref' => $code,
                        'montant' => $amount,
                        'type_operation_id' => $type_op->id,
                        'account_id' => $request->num_account,
                        'type_personne' => $request->type_personne,
                        'type_piece' => $request->type_piece,
                        'num_piece' => $request->num_piece,
                        'type_carte' => $request->type_carte,
                        'frais' => $request->frais,
                        'serie_cheque' => $request->serie_cheque,
                        'nom_porteur' => $request->nom_porteur,
                        'date_delivrance_piece' => $request->date_delivrance_piece,
                        'date_expiration_piece' => $request->date_expiration_piece,
                        //'file_scanne_piece' => $name,
                        'date_op' => date('d/m/Y'),
                        'heure_op' => date('H:i:s'),
                        'statut' => 'invalid',
                        'user_id' => Auth::user()->id,
                    ]);

                    Operation_mouvement::create([
                        'operation_id' => $operation->id,
                        'mouvement_id' => $mvmt->id
                    ]);

                    $request->session()->flash('msg_info', 'Important: Vous avez lancé un retrait qui depasse le grand seuil limite du jour, donc le service des operations et la Direction analyseront pour validation !');
                    return back()->with('title', $title);
                }
                elseif($cumulRetraitMonthFinal > $montant_limit_mois){


                    $account = Account::Where('number_account', $request->num_account)->first();
                
                    if ( intval($account->solde) < $amount ) {
                        $request->session()->flash('msg_error', 'Le montant que vous voulez retirer est superieur au solde du client, Veuillez réajuster !');
                        return back();
                    }

                    $operation = Operation::create([
                        'ref' => $code,
                        'montant' => $amount,
                        'type_operation_id' => $type_op->id,
                        'account_id' => $request->num_account,
                        'type_personne' => $request->type_personne,
                        'type_piece' => $request->type_piece,
                        'num_piece' => $request->num_piece,
                        'type_carte' => $request->type_carte,
                        'frais' => $request->frais,
                        'serie_cheque' => $request->serie_cheque,
                        'nom_porteur' => $request->nom_porteur,
                        'date_delivrance_piece' => $request->date_delivrance_piece,
                        'date_expiration_piece' => $request->date_expiration_piece,
                        //'file_scanne_piece' => $name,
                        'date_op' => date('d/m/Y'),
                        'heure_op' => date('H:i:s'),
                        'statut' => 'invalid',
                        'user_id' => Auth::user()->id,
                    ]);

                    Operation_mouvement::create([
                        'operation_id' => $operation->id,
                        'mouvement_id' => $mvmt->id
                    ]);

                    $request->session()->flash('msg_info', 'Important: Vous avez lancé un retrait qui depasse le seuil du mois, donc le service des operations analysera pour validation !');
                    return back()->with('title', $title);

                }elseif(($amount > $montant_limit_operation) && ($amount < $cumulRetraitJourFinal)){


                    $account = Account::Where('number_account', $request->num_account)->first();
                
                    if ( intval($account->solde) < $amount ) {
                        $request->session()->flash('msg_error', 'Le montant que vous voulez retirer est superieur au solde du client, Veuillez réajuster !');
                        return back();
                    }

                    $operation = Operation::create([
                        'ref' => $code,
                        'montant' => $amount,
                        'type_operation_id' => $type_op->id,
                        'account_id' => $request->num_account,
                        'type_personne' => $request->type_personne,
                        'type_piece' => $request->type_piece,
                        'num_piece' => $request->num_piece,
                        'type_carte' => $request->type_carte,
                        'frais' => $request->frais,
                        'serie_cheque' => $request->serie_cheque,
                        'nom_porteur' => $request->nom_porteur,
                        'date_delivrance_piece' => $request->date_delivrance_piece,
                        'date_expiration_piece' => $request->date_expiration_piece,
                        //'file_scanne_piece' => $name,
                        'date_op' => date('d/m/Y'),
                        'heure_op' => date('H:i:s'),
                        'statut' => 'invalid',
                        'user_id' => Auth::user()->id,
                    ]);

                    Operation_mouvement::create([
                        'operation_id' => $operation->id,
                        'mouvement_id' => $mvmt->id
                    ]);

                    $request->session()->flash('msg_info', 'Important: Vous avez lancé un retrait qui depasse le seuil d\'une operation, donc le service des operations analysera pour validation !');
                    return back()->with('title', $title);
                }else{

                        //Cumul du solde
                        /** Mise a jour du compte client **/
                        $account = Account::Where('number_account', $request->num_account)->first();
                        
                        if ( intval($account->solde) < $amount ) {
                            $request->session()->flash('msg_error', 'Le montant que vous voulez retirer est superieur au solde du client, Veuillez réajuster !');
                            return back();
                        }

                        $operation = Operation::create([
                            'ref' => $code,
                            'montant' => $amount,
                            'type_operation_id' => $type_op->id,
                            'account_id' => $request->num_account,
                            'type_personne' => $request->type_personne,
                            'type_piece' => $request->type_piece,
                            'num_piece' => $request->num_piece,
                            'type_carte' => $request->type_carte,
                            'frais' => $request->frais,
                            'serie_cheque' => $request->serie_cheque,
                            'nom_porteur' => $request->nom_porteur,
                            'date_delivrance_piece' => $request->date_delivrance_piece,
                            'date_expiration_piece' => $request->date_expiration_piece,
                            //'file_scanne_piece' => $name,
                            'date_op' => date('d/m/Y'),
                            'heure_op' => date('H:i:s'),
                            'user_id' => Auth::user()->id,
                        ]);

                        Operation_mouvement::create([
                            'operation_id' => $operation->id,
                            'mouvement_id' => $mvmt->id
                        ]);

                        Account::Where('number_account', $request->num_account)
                        ->update([
                            'solde' => intval($account->solde) - intval($amount+$request->frais),
                        ]);
                        /** Fin Mise a jour du compte client **/

                        /** Mise a jour de la caisse du guichetier **/
                        

                        Mouvement::Where('id', $mvmt->id)
                        ->update([
                            'solde_final' => intval($mvmt->solde_final) - $amount,
                        ]);
                        /** Fin Mise a jour de la caisse du guichetier **/


                        /**Mise a jour du solde principal**/
                        $agence = Agence::Where('id', Auth::user()->agence_id)
                        ->first();

                        Agence::Where('id', $agence->id)
                        ->update([
                            'solde_principal' => intval($agence->solde_principal) + intval($amount+$request->frais),
                        ]);

                        $balance = Main_account::latest()->first();

                        Main_account::create([

                            'type_operation_id' => 2,
                            'solde_operation' => $amount,
                            'solde_final' => $amount,
                            'account_id' => $request->num_account,
                            'date_operation' => date('d/m/Y'),
                            'heure_operation' => date('H:i:s'),

                        ]);
                        /**Fin mise a jour **/


                        $request->session()->flash('msg_success', 'Vous avez effectuer le retrait avec succès!');

                        return redirect()->route('retrait-validate', strtolower($code));

                    }

            }
        }

        //return back()->with('title', $title);

    }

    public function RetraitValidate($ref)
    {
        $ref = $ref; 
        return view('pages.retraits.succes_retrait')->with('ref', $ref);
    }

    public function RetraitPrint($ref)
    {

        $data = [
            
            'logo' => 'assets/images/logo/hopeFund.png',
            'v' => Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
                ->join('clients', 'clients.id', '=', 'accounts.client_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->join('agences', 'agences.id', '=', 'users.agence_id')
                ->select('operations.*', 'clients.nom', 'clients.prenom', 'agences.name as nom_agence', 'users.matricule')
                ->Where('operations.user_id', Auth::user()->id)
                ->Where('operations.type_operation_id', 2)
                ->Where('operations.ref', strtoupper($ref))
                ->OrderBy('operations.id', 'DESC')
                ->first()
        ];
        
        //dd($data);
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.retraits.print', $data)->render();

        // Convertir la vue en PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'portrait'); 

        $dompdf->render();

        // Générer le fichier PDF
        $output = $dompdf->output();
        
        // Enregistrer le fichier PDF
        $filename = date('dmY').'-recu_retrait.pdf';
        file_put_contents($filename, $output);
        
        //$dompdf->stream();

        // Retourner une réponse avec le nom de fichier pour le téléchargement
       // return response()->loadView($filename);
        return $dompdf->stream($filename, ['Attachment' => false]);
        //return view('pages.caisses.print_close_caisse');
    }
    /***FIN RETRAITS***/


    /**CONSULTATION**/
    public function accountsConsultation()
    {
        if (! Gate::allows('is-caissier') && ! Gate::allows('is-service-operation') && ! Gate::allows('is-analyste-credit') && ! Gate::allows('is-chef-service-credit') ) {
            return view('errors.403');
        }

        // code...
        $title = "Consultation";

        $verif_caisse =  Mouvement::Where('guichetier', Auth::user()->id)
        ->Where('date_mvmt', date('d/m/Y'))
        ->first();

        
        return view('pages.accounts.consultation')->with('title', $title);
          

    }

    public function accountsConsultationVerif(Request $request)
    {
        if (! Gate::allows('is-caissier') && ! Gate::allows('is-service-operation') && ! Gate::allows('is-analyste-credit') && ! Gate::allows('is-chef-service-credit')) {
            return view('errors.403');
        }

        $title = 'Compte client';

        if ( !isset($request->num_account) && !isset($request->email) && !isset($request->phone) ) {
            
            $request->session()->flash('msg_error', 'Vous devez remplir au plus un champ pour la consultation!');
            return back();
        }elseif ( isset($request->num_account) && isset($request->email) && isset($request->phone) ) {
            
            $request->session()->flash('msg_error', 'Vous ne devez pas remplir les trois champs en meme temps pour la consultation!');
            return back();
        }else{

            if (isset($request->num_account) || !empty($request->num_account)) {
                
                $verif = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
                ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                ->Where('accounts.number_account', $request->num_account)
                ->first();



                if (!$verif) {
                    $request->session()->flash('msg_error', 'Ce numero de compte n\'existe pas dans le systeme!');
                    return back();
                }


                $versements = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', $request->num_account)
                ->Where('operations.type_operation_id', 3)
                ->Where('operations.date_op', date('d/m/Y'))
                ->get();

                $som_versement = 0;
                foreach ($versements as $key => $value) {
                    $som_versement = $som_versement + $value->montant;
                }
                
                $retraits = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', $request->num_account)
                ->Where('operations.type_operation_id', 2)
                ->Where('operations.date_op', date('d/m/Y'))
                ->get();

                $som_retrait = 0;
                $som_frais = 0;
                foreach ($retraits as $key => $value) {
                    $som_retrait = $som_retrait + $value->montant;
                    $som_frais = $som_frais + $value->frais;
                }


                $chequiers = Chequier::Where('account_id', $request->num_account)
                ->Where('date_order', date('d/m/Y'))
                ->get();

                $montant_total_commande = 0;
                foreach ($chequiers as $key => $value) {
                    $montant_total_commande = $montant_total_commande + $value->montant_total;
                }

                $detail_transaction = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->Where('operations.account_id', $request->num_account)
                ->OrderBy('operations.date_op', 'DESC')
                ->get();

                //dd($detail_transaction);
            }

            if (isset($request->email) || !empty($request->email)) {
                
                $verif = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
                ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                ->Where('clients.email', $request->email)
                ->first();


                if (!$verif) {
                    $request->session()->flash('msg_error', 'Cette adresse Email n\'existe pas dans le systeme!');
                    return back();
                }

                $versements = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', $verif->number_account)
                ->Where('operations.type_operation_id', 3)
                ->Where('operations.date_op', date('d/m/Y'))
                ->get();

                $som_versement = 0;
                foreach ($versements as $key => $value) {
                    $som_versement = $som_versement + $value->montant;
                }

                $retraits = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', $verif->number_account)
                ->Where('operations.type_operation_id', 2)
                ->Where('operations.date_op', date('d/m/Y'))
                ->get();

                $som_retrait = 0;
                $som_frais = 0;
                foreach ($retraits as $key => $value) {
                    $som_retrait = $som_retrait + $value->montant;
                    $som_frais = $som_frais + $value->frais;
                }

                $chequiers = Chequier::Where('account_id', $verif->num_account)
                ->Where('date_order', date('d/m/Y'))
                ->get();

                $montant_total_commande = 0;
                foreach ($chequiers as $key => $value) {
                    $montant_total_commande = $montant_total_commande + $value->montant_total;
                }


                $detail_transaction = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->Where('operations.account_id', $verif->number_account)
                ->OrderBy('operations.date_op', 'DESC')
                ->get();

            }

            if (isset($request->phone) || !empty($request->phone)) {
                
                $verif = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
                ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                ->Where('clients.telephone', $request->phone)
                ->first();
                if (!$verif) {
                    $request->session()->flash('msg_error', 'Ce telephone n\'existe pas dans le systeme!');
                    return back();
                }

                $versements = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', $verif->number_account)
                ->Where('operations.type_operation_id', 3)
                ->Where('operations.date_op', date('d/m/Y'))
                ->get();

                $som_versement = 0;
                foreach ($versements as $key => $value) {
                    $som_versement = $som_versement + $value->montant;
                }

                $retraits = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', $verif->number_account)
                ->Where('operations.type_operation_id', 2)
                ->Where('operations.date_op', date('d/m/Y'))
                ->get();

                $som_retrait = 0;
                $som_frais = 0;
                foreach ($retraits as $key => $value) {
                    $som_retrait = $som_retrait + $value->montant;
                    $som_frais = $som_frais + $value->frais;
                }

                $chequiers = Chequier::Where('account_id', $verif->num_account)
                ->Where('date_order', date('d/m/Y'))
                ->get();

                $montant_total_commande = 0;
                foreach ($chequiers as $key => $value) {
                    $montant_total_commande = $montant_total_commande + $value->montant_total;
                }

                $detail_transaction = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->Where('operations.account_id', $verif->number_account)
                ->OrderBy('operations.date_op', 'DESC')
                ->get();
            }

            return view('pages.accounts.profile')
            ->with('title', $title)
            ->with('montant_total_commande', $montant_total_commande)
            ->with('som_versement', $som_versement)
            ->with('detail_transaction', $detail_transaction)
            ->with('som_retrait', $som_retrait)
            ->with('som_frais', $som_frais)
            ->with('verif', $verif);
        }
        
    }


    /**FIN CONSULTATION**/
    /***CAISSE***/
    public function Caisse()
    {

        if (! Gate::allows('is-caissier-principal')) {
            return view('errors.403');
        }

        $title = "Caisse";
        $agences = Agence::latest()->get();

        $solde_principal = Agence::Where('id', Auth::user()->agence_id)->first();

        $caisses = Caisse::join('agences', 'agences.id', '=', 'caisses.agence_id')
        ->select('caisses.*')
        ->Where('agences.id', Auth::user()->agence_id)
        ->OrderBy('caisses.id', 'DESC')
        ->get();

        $guichetiers = User::join('agences', 'agences.id', '=', 'users.agence_id')
        ->select('users.*')
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->Where('agences.id', Auth::user()->agence_id)
        ->Where('roles.name', 'Caissier')
        ->OrderBy('agences.id', 'DESC')
        ->get();

        $mvts = Mouvement::join('caisses', 'caisses.id', '=', 'mouvements.caisse_id')
        ->join('users', 'users.id', '=', 'mouvements.guichetier')
        ->Where('mouvements.date_mvmt', date('d/m/Y'))
        ->Where('users.agence_id', Auth::user()->agence_id)
        ->WhereIn('mouvements.verify', ['ferme','yes','no', 'cancel'])
        ->select('mouvements.*', 'caisses.name', 'users.nom', 'users.prenom')
        ->OrderBy('caisses.id', 'DESC')
        ->get();

        return view('pages.caisses.index')
        ->with('caisses', $caisses)
        ->with('mvts', $mvts)
        ->with('guichetiers', $guichetiers)
        ->with('agences', $agences)
        ->with('solde_principal', $solde_principal)
        ->with('title', $title);
       
    }

    public function CaisseCreate()
    {

        if (! Gate::allows('is-service-operation')) {
            return view('errors.403');
        }

        $title = "Creation de Caisse";
        $agences = Agence::latest()->get();

        $caisses = Caisse::join('agences', 'agences.id', '=', 'caisses.agence_id')
        ->select('caisses.*', 'agences.name as nom_agence')
        ->Where('agences.id', Auth::user()->agence_id)
        ->OrderBy('caisses.id', 'DESC')
        ->get();

        

        return view('pages.caisses.create')
        ->with('agences', $agences)
        ->with('caisses', $caisses)
        ->with('title', $title);
    }

    public function CaisseCreateValid(Request $request)
    {

        if (! Gate::allows('is-service-operation')) {
            return view('errors.403');
        }

        if( !isset( $request->name_caisse ) || empty($request->name_caisse) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le nom de caisse');
        }else{

        Caisse::create([
            'montant' => 0,
            'name' => $request->name_caisse,
            'agence_id' => Auth::user()->agence_id,
            'user_id' => Auth::user()->id,
        ]);
        
            $request->session()->flash('msg_success', 'Vous avez ajouté une nouvelle caisse avec succès!');
        }

        return back();
    }

    public function CaisseEditValid(Request $request)
    {

        if (! Gate::allows('is-service-operation')) {
            return view('errors.403');
        }

        if( !isset( $request->name_caisse ) || empty($request->name_caisse) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le nom de caisse');
        }else{

        Caisse::Where('id', $request->edit_id)
        ->update([
            'montant' => 0,
            'name' => $request->name_caisse,
            'agence_id' => Auth::user()->agence_id,
            'user_id' => Auth::user()->id,
        ]);
        
            $request->session()->flash('msg_success', 'Vous avez ajouté une nouvelle caisse avec succès!');
        }

        return back();
    }

    public function CaisseDelValid(Request $request)
    {
        if (! Gate::allows('is-service-operation')) {
            return view('errors.403');
        }

        Caisse::findOrFail($request->id)->delete();
        $request->session()->flash('msg_error', 'Vous avez supprimé une caisse avec succès!');

        return back();

    }

    public function CaisseRechargement()
    {

        if (! Gate::allows('is-caissier-principal')) {
            return view('errors.403');
        }

        $title = "Rechargement des caisses du ".date('d/m/Y');

        $caisses = Caisse::join('agences', 'agences.id', '=', 'caisses.agence_id')
        ->select('caisses.*')
        ->Where('agences.id', Auth::user()->agence_id)
        ->OrderBy('caisses.id', 'DESC')
        ->get();

        $guichetiers = User::join('agences', 'agences.id', '=', 'users.agence_id')
        ->select('users.*')
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->Where('agences.id', Auth::user()->agence_id)
        ->Where('roles.name', 'Caissier')
        ->get();

        //dd($guichetiers);
        return view('pages.caisses.rechargement_caisse')
        ->with('caisses', $caisses)
        ->with('guichetiers', $guichetiers)
        ->with('title', $title);
       
    }

    public function CaisseRechargementValid(Request $request)
    {

        if (! Gate::allows('is-caissier-principal')) {
            return view('errors.403');
        }

        $amount = intval(str_replace(' ', '', $request->montant));

        if( !isset( $request->caisse ) || empty($request->caisse) ) {
            $request->session()->flash('msg_error', 'Vous devez selectionner une caisse');
        }elseif( !isset( $request->montant ) || empty($request->montant) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le montant initial');
        }else{


        $_Single_caisse = Mouvement::join('users', 'users.id', '=', 'mouvements.guichetier')
        ->Where('mouvements.caisse_id', $request->caisse)
        ->Where('mouvements.date_mvmt', date('d/m/Y'))
        ->first();

        $_single_guichetier = Mouvement::join('users', 'users.id', '=', 'mouvements.guichetier')
        ->Where('mouvements.guichetier', $request->guichetier)
        ->Where('mouvements.date_mvmt', date('d/m/Y'))
        ->first();


        if ($_Single_caisse) {

           $guichetier = $_Single_caisse->nom.' '.$_Single_caisse->prenom;
           $request->session()->flash('msg_error', 'Cette caisse a déjà été attribuée au guichetier '.$guichetier);

        }elseif($_single_guichetier){

            $guichetier = $_single_guichetier->nom.' '.$_single_guichetier->prenom;
           $request->session()->flash('msg_error', 'Une caisse a déjà été attribuée au guichetier '.$guichetier);

        }else{

            $solde_principal = Agence::Where('id', Auth::user()->agence_id)->first();

            $caisses = Mouvement::join('caisses', 'caisses.id', '=', 'mouvements.caisse_id')
            ->join('agences', 'agences.id', '=', 'caisses.agence_id')
            ->join('users', 'users.id', '=', 'mouvements.guichetier')
            ->select('caisses.*', 'mouvements.solde_initial', 'mouvements.verify', 'mouvements.solde_final','users.nom', 'users.prenom')
            ->Where('agences.id', Auth::user()->agence_id)
            ->Where('mouvements.date_mvmt', date('d/m/Y'))
            ->OrderBy('mouvements.date_mvmt', 'DESC')
            ->get();

                $solde_attribuee = 0;

                foreach ($caisses as $value) {
                    $solde_attribuee = intval($solde_attribuee) + intval($value->solde_initial);
                }

                //Si la somme des montant attribuee est superieure au solde principal

                //dd($solde_principal->solde_principal.' et '.$request->montant);

                if ( intval($solde_principal->solde_principal) < $amount ) {

                    $request->session()->flash('msg_error', 'Le montant attribué à l\'ensemble des caisses est superieur au solde principal disponible. Veuillez réajuster la repartition !');

                }else{

                Mouvement::create([
                    'solde_initial' => $amount,
                    'solde_final' => $amount,
                    'caisse_id' => $request->caisse,
                    'date_mvmt' => date('d/m/Y'),
                    'heure_mvmt' => date('H:i:s'),
                    'guichetier' => $request->guichetier,
                    'user_id' => Auth::user()->id,
                ]);



                    Agence::Where('id', Auth::user()->agence_id)
                    ->update([
                    'solde_principal' => intval($solde_principal->solde_principal) - $amount
                    ]);
                
                    $request->session()->flash('msg_success', 'Caisse rechargé avec succès!');
                }
            }
        }

        

        return back();
    }

    public function RapportCaisse()
    {
        $title = "Historiques des caisses";

        $rapports = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom', 'operations.montant', 'type_operations.name', 'accounts.number_account')
        ->Where('operations.user_id', Auth::user()->id)
        ->get();

        //dd($rapports);

        return view('pages.caisses.rapport')
        ->with('title', $title)
        ->with('rapports', $rapports);
    }

    public function RapportCaisseResult(Request $request)
    {

        $title = "Historiques des caisses";

        $rapports = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom', 'operations.montant', 'type_operations.name', 'accounts.number_account')
        ->Where('operations.user_id', Auth::user()->id);

        if ( $request->periode == "day" ) {

            $NomPeriode = "d'Ajourd'hui";
            $date = date('d/m/Y');
            
            $rapports = $rapports->Where('operations.date_op', $date)
            ->orderBy('operations.id', 'DESC')->get();

        }else if( $request->periode == "month" ){

            $NomPeriode = "du Mois";
            //$date = date('Y-m-d');
            $debut = '01/'.date('m').'/'.date('Y') ;    
            $fin = '31/'.date('m').'/'.date('Y') ; 

            $rapports = $rapports->whereBetween('operations.date_op', [$debut, $fin])
            ->orderBy('operations.id', 'DESC')->get();

        }else if( $request->periode == "week" ){

            $NomPeriode = "de la Semaine";
            $date = date('d/m/Y');
            $debut = date('d/m/Y', strtotime($date.'-7 days'));

            $rapports = $rapports->whereBetween('operations.date_op', [$debut, $date])
            ->orderBy('operations.id', 'DESC')->get();

        }else{

            $NomPeriode = "de l'année";
            $date = date('d/m/Y');

            $debut = '01/01/' .date('Y');    
            $fin = '31/12/' .date('Y'); 

            $rapports = $rapports->whereBetween('operations.date_op', [$debut, $fin])
            ->orderBy('operations.id', 'DESC')->get();
        }



        if ( isset($request->date_start) AND isset($request->date_end) ) {

            
            $start1 = date_create($request->date_start);
            $start = date_format($start1, 'd/m/Y');
            
            $end1 = date_create($request->date_end);
            $end = date_format($end1, 'd/m/Y');

            //echo $start.' et '.$end;
            //dd();
            $NomPeriode = "du ".$start." au ".$end;

           // dd($NomPeriode);

            $rapports = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->join('accounts', 'accounts.id', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom', 'clients.nom', 'operations.montant', 'type_operations.name', 'accounts.number_account')
        ->whereBetween('operations.date_op', [$start, $end])
        ->Where('operations.user_id', Auth::user()->id)
        ->orderBy('operations.id', 'DESC')->get();


            //dd($rapports);
        }

        return view('pages.caisses.rapport-2')
        ->with('title', $title)
        ->with('rapports', $rapports);
    }

    public function HistoriqueCaisse()
    {
        $title = "Historiques de caisses";

        /**Versement globale par agence**/
        

        $historys = Mouvement::join('caisses', 'caisses.id', '=', 'mouvements.caisse_id')
        ->join('users', 'users.id', '=', 'mouvements.guichetier')
        ->Where('mouvements.verify', '<>', 'no')
        ->select('mouvements.*', 'caisses.name')
        ->get();

        //dd($historys);
        return view('pages.caisses.historique_ouverture')
        ->with('title', $title)
        ->with('historys', $historys);
    }

    public function AgenceByUser($id)
    {
        
        // recuperation des users selon la caisse
        $data = User::Where('agence_id', $id)->get();
        return response()->json($data);

    }


    public function CaisseOuverture()
    {

        $title = "Ouverture de caisse du ".date('d/m/Y');
       
        $caisse = Mouvement::join('caisses', 'caisses.id', '=', 'mouvements.caisse_id')
        ->join('agences', 'agences.id', '=', 'caisses.agence_id')
        ->select('caisses.*', 'mouvements.solde_initial', 'mouvements.verify', 'mouvements.solde_final',)
        ->Where('agences.id', Auth::user()->agence_id)
        ->Where('mouvements.guichetier', Auth::user()->id)
        ->Where('mouvements.date_mvmt', date('d/m/Y'))
        ->first();

        $billets = Billet::all();
        return view('pages.caisses.ouverture_caisse')
        ->with('billets', $billets)
        ->with('caisse', $caisse)
        ->with('title', $title);
       
    }

    public function CaisseOuvertureVerif(Request $request)
    {
        $caisse = Mouvement::Where('guichetier', Auth::user()->id)
        ->Where('date_mvmt', date('d/m/Y'))
        ->first();

        if ( $caisse->solde_initial == $request->result_verif ) {
            
            
            $billets = Billet::all();
            foreach ($billets as $value) {
                
                $monnaie = 'billet_id_'.$value->montant;
                $nombre = 'nb_'.$value->montant;

                if (!isset($request->$nombre)) {
                     $nombre = 0;
                    }else{
                    $nombre = $request->$nombre;
                    }

                $values = [
                    'monnaie' => $request->$monnaie,
                    'nombre' => $nombre,
                    'date_jour' => date('d/m/Y'),
                    'statuts' => 'open',
                    'guichet' => Auth::user()->id,
                ];

                Monnaie_billet::create($values);

            }

            Mouvement::Where('id', $caisse->id)
            ->update([
            'verify' => 'yes',
             ]);

            $request->session()->flash('msg_success', 'Bravo!!!');
            return back();

        }else{

            $request->session()->flash('msg_error', 'Votre montant ne correspond pas au montant qui vous a été attribué. Merci de verifier avec le caissier principal!');
           return back(); 
        }
        
    }

    public function CaisseFermeture(Request $request)
    {

        if (! Gate::allows('is-caissier-principal')) {
            return view('errors.403');
        }

        //dd('fermeture');
        //$amount = $request->montant;

        Mouvement::Where('id', $request->id)
        ->update([
            'solde_final' => 0,
            'solde_fermeture' => $request->solde_final,
            'date_mvmt_fermeture' => date('d/m/Y'),
            'heure_mvmt_fermeture' => date('H:i:s'),
            'verify' => 'ferme',
            'user_id' => Auth::user()->id,
        ]);
        
        $agence = Agence::Where('id', Auth::user()->agence_id)->first();

        Agence::Where('id', Auth::user()->agence_id)
        ->update([
            'solde_principal' => intval($agence->solde_principal) + intval($request->solde_final),
        ]);
        
        $request->session()->flash('msg_error', 'Vous avez fermé la caisse avec succès!');

        return back();
    }

    public function Reajustement()
    {
        $mvts = Mouvement::join('caisses', 'caisses.id', '=', 'mouvements.caisse_id')
        ->join('users', 'users.id', '=', 'mouvements.guichetier')
        ->Where('mouvements.date_mvmt', date('d/m/Y'))
        ->Where('users.agence_id', Auth::user()->agence_id)
        ->WhereIn('mouvements.verify', ['noferme','yes'])
        ->select('mouvements.*', 'caisses.name', 'users.nom', 'users.prenom')
        ->OrderBy('caisses.id', 'DESC')
        ->get();

        $title = 'Liste des caisses Echouees';
        return view('pages.services_operations.reajustement')
        ->with('mvts', $mvts)
        ->with('title', $title);
    }

    public function CaisseReajuster($id)
    {


        $mvmt = Mouvement::Where('id', $id)->first();

        $billets = Billet::all();

        return view('pages.caisses.reajuster')
        ->with('mvmt', $mvmt)
        ->with('billets', $billets);
    }

    public function CaisseReajusterValide(Request $request)
    {
       $solde_verify  = $request->result_verif;
       $id  = $request->mvmt_id;
       session()->put('solde_verify', $solde_verify);
       session()->put('id', $id);

       return redirect()->route('caisse-reajuster-2');

    }

    public function CaisseReajuster2(Request $request)
    {

        $mvmt = Mouvement::Where('id', session('id'))->first();
        return view('pages.caisses.reajuster-2')->with('mvmt', $mvmt);
    }

    public function CaisseReajusterValideEnd(Request $request)
    {
        $diff_reajustement = $request->solde_final - $request->solde_verify;

        Mouvement::Where('id', $request->mvmt_id)
        ->update([
            'motif_reajustement' => $request->motif_reajustement, 
            'date_reajustement' => date('d/m/Y'), 
            'montant_reajustement' => $diff_reajustement, 
            'verify' => 'ferme', 
            'auteur_reajustement' => Auth::user()->id
        ]);


        return redirect()->route('caisse-reajuster-close');

    }

    public function CaisseReajusterClose()
    {
        

        return view('pages.caisses.reajustement_close');
    }

    public function CaisseCloture()
    {
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        $title = 'Cloture de caisse';

        $billets = Billet::all();

        return view('pages.caisses.fermeture_caisse')
        ->with('billets', $billets)
        ->with('title', $title);
    }

    public function CaisseClotureVerif(Request $request)
    {
        $caisse = Mouvement::Where('guichetier', Auth::user()->id)
        ->Where('date_mvmt', date('d/m/Y'))
        ->first();

        if ( $caisse->solde_final == $request->result_verif ) {
            
            
            $billets = Billet::all();

            foreach ($billets as $value) {
                
                $monnaie = 'billet_id_'.$value->montant;
                $nombre = 'nb_'.$value->montant;

                if (!isset($request->$nombre)) {
                     $nombre = 0;
                    }else{
                    $nombre = $request->$nombre;
                    }

                $values = [
                    'monnaie' => $request->$monnaie,
                    'nombre' => $nombre,
                    'date_jour' => date('d/m/Y'),
                    'statuts' => 'close',
                    'guichet' => Auth::user()->id,
                ];

                Monnaie_billet::create($values);

            }

            Mouvement::Where('id', $caisse->id)
            ->update([
                'solde_final' => 0,
                'solde_fermeture' => $caisse->solde_final,
                'date_mvmt_fermeture' => date('d/m/Y'),
                'heure_mvmt_fermeture' => date('H:i:s'),
                'verify' => 'ferme',
             ]);

            $request->session()->flash('msg_success', 'Vous avez fermé la caisse de cette journée !!!');
            return redirect()->route('caisse-cloture-End');

        }else{

            Mouvement::Where('id', $caisse->id)
            ->update([
                'verify' => 'noferme',
                'solde_fermeture' => $request->result_verif,
                'date_mvmt_fermeture' => date('d/m/Y'),
                'heure_mvmt_fermeture' => date('H:i:s'),
             ]);

            $solde_cash = $request->result_verif;
            $solde_final = $caisse->solde_final;


            if ( intval($solde_cash) >= intval($solde_final) ) {
                
                $diff = intval($solde_cash) - intval($solde_final);

            }else{
                $diff = intval($solde_final) - intval($solde_cash);
            }

            return view('pages.caisses.echec_close')
            ->with('solde_final', $solde_final)
            ->with('diff', $diff)
            ->with('solde_cash', $solde_cash);

            //$request->session()->flash('msg_error', 'Montant en cash: '.number_format($request->result_verif, 0, 2, ' ').' BIF et Montant systeme: '.number_format($caisse->solde_final, 0, 2, ' ').' BIF. Cela signifie que les deux montants ne correspondent pas. Veuillez rentrer en contact avec le caissier principal pour verification!');
            //return back(); 
        }

    }

    public function CaisseClotureEnd()
    {

        $data_fermeture = Mouvement::join('caisses', 'caisses.id', '=', 'mouvements.caisse_id')
        ->join('users', 'users.id', '=', 'mouvements.guichetier')
        ->Where('mouvements.date_mvmt', date('d/m/Y'))
        ->Where('mouvements.guichetier', Auth::user()->id)
        ->select('mouvements.*', 'caisses.name', 'users.nom', 'users.prenom')
        ->first();

        //dd($data_fermeture);
        return view('pages.caisses.succes_close')
        ->with('data_fermeture', $data_fermeture);
    }
    public function CaisseAnnulation(Request $request)
    {

        if (! Gate::allows('is-caissier-principal')) {
            return view('errors.403');
        }

        Mouvement::Where('id', $request->id)
        ->update([
            'solde_final' => 0,
            'solde_annulation' => $request->solde_final,
            'date_mvmt_annulation' => date('d/m/Y'),
            'heure_mvmt_annulation' => date('H:i:s'),
            'motif_annulation' => $request->motif,
            'verify' => 'cancel',
            'user_id' => Auth::user()->id,
        ]);
        
        $agence = Agence::Where('id', Auth::user()->agence_id)->first();

        Agence::Where('id', Auth::user()->agence_id)
        ->update([
            'solde_principal' => intval($agence->solde_principal) + intval($request->solde_final),
        ]);
        
        $request->session()->flash('msg_error', 'Vous avez annulé la caisse avec succès!');

        return back();
    }

    public function CaissePrintClotureEnd()
    {

        $data = [
            'mvt' => Mouvement::join('caisses', 'caisses.id', '=', 'mouvements.caisse_id')
                ->join('users', 'users.id', '=', 'mouvements.guichetier')
                ->join('agences', 'agences.id', '=', 'users.agence_id')
                //->Where('mouvements.date_mvmt', date('d/m/Y'))
                ->Where('mouvements.guichetier', Auth::user()->id)
                ->select('mouvements.*','agences.name as nom_agence', 'caisses.name', 'users.matricule')
                ->first()
        ];
        
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.caisses.print_close_caisse', $data)->render();

        // Convertir la vue en PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); 

        $dompdf->render();

        // Générer le fichier PDF
        $output = $dompdf->output();
        
        // Enregistrer le fichier PDF
        $filename = date('dmY').'-recu_caisse.pdf';
        file_put_contents($filename, $output);
        
        //$dompdf->stream();

        // Retourner une réponse avec le nom de fichier pour le téléchargement
       // return response()->loadView($filename);
        return $dompdf->stream($filename, ['Attachment' => false]);
        //return view('pages.caisses.print_close_caisse');
    }

    public function CaisseEchecClose(Request $request)
    {
        $title = 'Fermeture échoué';

        return view('pages.caisses.echec_close')
        ->with('title',  $title);
    }


    public function CaisseReportClose()
    {
        $data_fermeture = Mouvement::join('caisses', 'caisses.id', '=', 'mouvements.caisse_id')
        ->join('users', 'users.id', '=', 'mouvements.guichetier')
        ->Where('mouvements.guichetier', Auth::user()->id)
        ->Where('mouvements.verify', 'ferme')
        ->select('mouvements.*', 'caisses.name', 'users.nom', 'users.prenom')
        ->get();

        return view('pages.caisses.report_close')
        ->with('data_fermeture', $data_fermeture);
    }
    /***FIN CAISSE***/


    /***VIREMENT***/

    public function virementStart()
    {
        return view('pages.virement.demarrage');
    }

    public function virements()
    {
        $title = "Virements du ".date('d/m/Y');

        if (! Gate::allows('is-comptable')) {
            return view('errors.403');
        }
        

        $virements = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom')
        ->Where('operations.user_id', Auth::user()->id)
        ->Where('operations.date_op', date('d/m/Y'))
        ->Where('operations.type_operation_id', 1)
        ->OrderBy('operations.id', 'DESC')
        ->get();


        $verif_caisse =  Mouvement::Where('guichetier', Auth::user()->id)
        ->Where('date_mvmt', date('d/m/Y'))
        ->first();


       
        return view('pages.virement.index')
        ->with('virements', $virements)
        ->with('title', $title);
            

        
    }

    public function VirementNew()
    {
        $title = "Faire un virement";

        return view('pages.virement.new')
        ->with('title', $title);

    }

    public function VirementPrint($ref)
    {
        $title = "Imprimer recu";

        //dd($ref);

        $data = [
            
            'logo' => 'assets/images/logo/hopeFund.png',
            'v' => Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
                ->join('clients', 'clients.id', '=', 'accounts.client_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->join('agences', 'agences.id', '=', 'users.agence_id')
                ->select('operations.*', 'clients.nom', 'clients.prenom', 'agences.name as nom_agence', 'users.matricule')
                ->Where('operations.user_id', Auth::user()->id)
                ->Where('operations.type_operation_id', 1)
                ->Where('operations.ref', strtoupper($ref))
                ->OrderBy('operations.id', 'DESC')
                ->first()
        ];
        
        //dd($data);
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.virement.print', $data)->render();

        // Convertir la vue en PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'portrait'); 

        $dompdf->render();

        // Générer le fichier PDF
        $output = $dompdf->output();
        
        // Enregistrer le fichier PDF
        $filename = date('dmY').'-recu_virement.pdf';
        file_put_contents($filename, $output);
        
        //$dompdf->stream();

        // Retourner une réponse avec le nom de fichier pour le téléchargement
       // return response()->loadView($filename);
        return $dompdf->stream($filename, ['Attachment' => false]);
        //return view('pages.caisses.print_close_caisse');

    }

    public function VirementNew2(Request $request)
    {

        $title = "Faire un virement";

        if ( !isset( $request->flash ) || empty($request->flash) ) {
            
            $request->session()->flash('msg_error', 'Vous devez saisir le numero du compte client');

        }else{

            $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('accounts.number_account', $request->flash)
            ->first();

            if ( $data ) {
                return view('pages.virement.new-2')
                ->with('data', $data)
                ->with('title', $title);
            }else{
                $request->session()->flash('msg_error', 'Le numero du compte que vous avez saisi ne correspond a aucun compte. Merci de renseigner un bon numero de compte.');
                return back()
                ->with('title', $title);
            }

        }

    }

    public function VirementNewConfirm(Request $request)
    {
        // code...
        $title = "Confirmation du virement";

        //dd('page de confirm_password');
        if ( !isset( $request->num_account ) || empty($request->num_account) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le numero du compte du destinataire');
            return back()
            ->with('title', $title);
        }elseif( !isset( $request->amount ) || empty($request->amount) ){
            $request->session()->flash('msg_error', 'Vous devez saisir le montant du virement');
            return back()
            ->with('title', $title);
        }else{

            $num_account_destinataire = $request->num_account;
            $num_account_expeditaire = $request->num_account_exp;
            $amount = $request->amount;

            $account = Account::Where('number_account', $num_account_expeditaire)->first();

            if ( $num_account_expeditaire == $num_account_destinataire ) {
                $request->session()->flash('msg_error', 'Attention! Le numéro expéditeur et le numéro destinataire sont identique.');
                return back()
                ->with('title', $title);

            }elseif ( intval($account->solde) < intval($amount) ) {
                $request->session()->flash('msg_error', 'Le montant que vous voulez virer est superieur au solde du client expéditeur, Veuillez réajuster !');
                return back()
                ->with('title', $title);

            }else{

                $info_exp = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
                ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                ->Where('accounts.number_account', $num_account_expeditaire)
                ->first();

                $info_dest = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
                ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                ->Where('accounts.number_account', $num_account_destinataire)
                ->first();


                return view('pages.virement.confirm')
                ->with('info_dest', $info_dest)
                ->with('amount', $amount)
                ->with('title', $title)
                ->with('info_exp', $info_exp);
            }
            

        }

        return back()
        ->with('title', $title);
    }

    public function VirementNewConfirmValid(Request $request)
    {
        $title ='Faire un Virement';

        $init = "REF-VIR-";
        $rand = rand(111111, 999999);
        $date = date("Ymd");

        $code = $init.$rand.$date;

        $montant_limit = 2000000;
        $montant_limit_start = 500001;

        $account = Account::Where('number_account', $request->num_account)
            ->first();

        $operation = Operation::create([
            'ref' => $code,
            'montant' => $request->amount,
            'type_operation_id' => 1,
            'account_id' => $request->num_account,
            'account_dest' => $request->num_account_dest,
            'motif_virement' => $request->motif_virement,
            'type_carte' => $request->type_carte,
            'frais' => $request->frais,
            'date_op' => date('d/m/Y'),
            'heure_op' => date('H:i:s'),
            'user_id' => Auth::user()->id,
        ]);


       /* Operation_mouvement::create([
            'mouvement_id' => $account->id,
            'operation_id' => $operation->id
        ]);*/


        /**Expediteur**/
        $solde_exp = Account::Where('number_account', $request->num_account)->first();
        
        Account::Where('number_account', $request->num_account)
        ->update([
            'solde' => intval($solde_exp->solde) - intval($request->amount+$request->frais) 
        ]);
        /**Fin Expediteur**/

        /**Destinateur**/
        $solde_dest = Account::Where('number_account', $request->num_account_dest)->first();
        
        Account::Where('number_account', $request->num_account_dest)
        ->update([
            'solde' => intval($solde_dest->solde) + intval($request->amount) 
        ]);
        /**Fin Destinateur**/

        /**Mise a jour de la caisse principale**/
        $agence = Agence::Where('id', Auth::user()->agence_id)->first();

        Agence::Where('id', $agence->id)
        ->update([
            'solde_principal' => intval($agence->solde_principal) + intval($request->frais),
        ]);


        $balance = Main_account::latest()->first();

        /*Main_account::create([

            'type_operation_id' => 1,
            'solde_operation' => $amount,
            'solde_final' => $amount,
            'account_id' => $request->num_account,
            'date_operation' => date('d/m/Y'),
            'heure_operation' => date('H:i:s'),

        ]);*/

        $request->session()->flash('msg_success', 'Virement passé avec succès !');

        return redirect()->route('client-virements-success', strtolower($code));
        
    }

    public function VirementSuccess($ref)
    {
        $ref = $ref;
        return view('pages.virement.succes_virement')->with('ref', $ref);
    }
    /***FIN VIREMENT***/


    public function AnalysteValid(Request $request)
    {
        $nom = trim($request->nom_emprunteur).' '.trim($request->prenom_emprunteur);

        //$id = 
        $values = array(
                "demande_credit_id" => $request->demande_credit_id,
                "nom_prenom_emprunteur" => $nom,
                "qualite_emprunteur" => trim($request->qualite_emprunteur),
                "sexe_emprunteur" => trim($request->sexe_emprunteur),
                "nom_prenom_pere" => trim($request->nom_prenom_pere),
                "nom_prenom_mere" => trim($request->nom_prenom_mere),
                "nature_numero_piece_identite" => trim($request->nature_numero_piece_identite),
                "lieu_naissance_emprunteur" => trim($request->lieu_naissance_emprunteur),
                "date_naissance_emprunteur" => trim($request->date_naissance_emprunteur),
                "residence_actuelle_emprunteur" => trim($request->residence_actuelle_emprunteur),
                "nom_association" => trim($request->nom_association),
                "employeur_emprunteur" => trim($request->employeur_emprunteur),
                "lieu_travail_emprunteur" => trim($request->lieu_travail_emprunteur),
                "tel_emprunt" => trim($request->tel_emprunt),
                "etat_civil_emprunteur" => trim($request->etat_civil_emprunteur),
                "anciennete_emprunteur" => trim($request->anciennete_emprunteur),
                "nom_conjoint_emprunteur" => trim($request->nom_conjoint_emprunteur),
                "telephone_conjoint" => trim($request->telephone_conjoint),
                "lieu_travail_conjoint" => trim($request->lieu_travail_conjoint),
                "employeur_conjoint" => trim($request->employeur_conjoint),
                "Anciennete_conjoint" => trim($request->Anciennete_conjoint),
                "personne_reference" => trim($request->personne_reference),
                "lieu_perso_ref" => trim($request->lieu_perso_ref),
                "tel_perso_ref" => trim($request->tel_perso_ref),
                "activite1" => trim($request->activite1),
                "activite2" => trim($request->activite2),
                "activite3" => trim($request->activite3),
                "forces_Strategies_envisagees_par_emprunteur" => 
                trim($request->forces_Strategies_envisagees_par_emprunteur),
                "faiblesses_contraintes_emprunteur_marche_approvisionnement" => trim($request->faiblesses_contraintes_emprunteur_marche_approvisionnement),
                "source_revenus1" => trim($request->source_revenus1),
                "montant_source_revenus1" => trim($request->montant_source_revenus1),
                "objet_depense1" => trim($request->objet_depense1),
                "montant_objet_depense1" => trim($request->montant_objet_depense1),
                "source_revenus2" => trim($request->source_revenus2),
                "montant_source_revenus2" => trim($request->montant_source_revenus2),
                "objet_depense2" => trim($request->objet_depense2),
                "montant_objet_depense2" => trim($request->montant_objet_depense2),
                "source_revenus3" => trim($request->source_revenus3),
                "montant_source_revenus3" => trim($request->montant_source_revenus3),
                "objet_depense3" => trim($request->objet_depense3),
                "montant_objet_depense3" => trim($request->montant_objet_depense3),
                "source_revenus4" => trim($request->source_revenus4),
                "montant_source_revenus4" => trim($request->montant_source_revenus4),
                "objet_depense4" => trim($request->objet_depense4),
                "montant_objet_depense4" => 
                trim($request->montant_objet_depense4),
                "flexRadio1" => trim($request->flexRadio1),
                "versement_jour" => trim($request->versement_jour),
                "versement_hebdo" => trim($request->versement_hebdo),
                "versement_mois" => trim($request->versement_mois),
                "versement_trimestre" => trim($request->versement_trimestre),
                "versement_semestre" => trim($request->versement_semestre),
                "nombre_adhesion" => trim($request->nombre_adhesion),
                "volume_adhesion" => trim($request->volume_adhesion),
                "credit" => trim($request->credit),
                "pourquoi_credit" => trim($request->pourquoi_credit),
                "nombre_credit" => trim($request->nombre_credit),
                "date_dernier_credit" => trim($request->date_dernier_credit),
                "montant_credit1" => trim($request->montant_credit1),
                "date_credit1" => trim($request->date_credit1),
                "institution1" => trim($request->institution1),
                "penalites_payees1" => trim($request->penalites_payees1),
                "montant_credit2" => trim($request->montant_credit2),
                "date_credit2" => trim($request->date_credit2),
                "institution2" => trim($request->institution2),
                "penalites_payees2" => trim($request->penalites_payees2),
                "montant_credit3" => trim($request->montant_credit3),
                "date_credit3" => trim($request->date_credit3),
                "institution3" => trim($request->institution3),
                "penalites_payees3" => trim($request->penalites_payees3),
                "montant_credit4" => trim($request->montant_credit4),
                "date_credit4" => trim($request->date_credit4),
                "institution4" => trim($request->institution4),
                "penalites_payees4" => trim($request->penalites_payees4),
                "type_credit_demande" => trim($request->type_credit_demande),
                "detail_objet_precision_activite" => trim($request->detail_objet_precision_activite),
                "cni_montant_demande" => trim($request->cni_montant_demande),
                "date_demande" => trim($request->date_demande),
                "condition_demande" => trim($request->condition_demande),
                "periodicite" => trim($request->periodicite),
                "garantie_propose1" => trim($request->garantie_propose1),
                "nom_prenom_avaliseur" => trim($request->nom_prenom_avaliseur),
                "residence" => trim($request->residence),
                "cni" => trim($request->cni),
                "telephone" => trim($request->telephone),
                "numero_compte" => trim($request->numero_compte),
                "activite_principale" => trim($request->activite_principale),
                "element_dossier" => trim($request->element_dossier),
                "commentaire_agent_demande" => trim($request->commentaire_agent_demande),
                "commentaire_agent_rentabilite" => trim($request->commentaire_agent_rentabilite),
                "mode_description1" => trim($request->mode_description1),
                "valeur_garantie1" => trim($request->valeur_garantie1),
                "combien_km_agence1" => trim($request->combien_km_agence1),
                "doc_materiel_garantie1" => trim($request->doc_materiel_garantie1),
                "valeur_retenu_visiste2" => trim($request->valeur_retenu_visiste2),
                "combien_km_agence2" => trim($request->combien_km_agence2),
                "valeur_garantie2" => trim($request->valeur_garantie2),
                "mode_description3" => trim($request->mode_description3),
                "valeur_garantie3" => trim($request->valeur_garantie3),
                "combien_km_agence3" => trim($request->combien_km_agence3),
                "doc_materiel_garantie3" => trim($request->doc_materiel_garantie3),
                "valeur_retenu_visiste3" => trim($request->valeur_retenu_visiste3),
                "mode_description4" => trim($request->mode_description4),
                "valeur_garantie4" => trim($request->valeur_garantie4),
                "combien_km_agence4" => trim($request->combien_km_agence4),
                "doc_materiel_garantie4" => trim($request->doc_materiel_garantie4),
                "valeur_retenu_visiste4" => trim($request->valeur_retenu_visiste4),
                "mode_description5" => trim($request->mode_description5),
                "valeur_garantie5" => trim($request->valeur_garantie5),
                "combien_km_agence5" => trim($request->combien_km_agence5),
                "doc_materiel_garantie5" => trim($request->doc_materiel_garantie5),
                "valeur_retenu_visiste5" => trim($request->valeur_retenu_visiste5),
                "mode_description6" => trim($request->mode_description6),
                "valeur_garantie6" => trim($request->valeur_garantie6),
                "combien_km_agence6" => trim($request->combien_km_agence6),
                "doc_materiel_garantie6" => trim($request->doc_materiel_garantie6),
                "valeur_retenu_visiste6" => trim($request->valeur_retenu_visiste6),
                "montant_credit_autorise" => trim($request->monant_credit_autorise),
                "commentaires" => trim($request->commentaires),
                "proposition_agent_credit" => trim($request->proposition_agent_credit),
                "montant_propose_agent_credit" => trim($request->montant_propose_agent_credit),
                "type_credit_agent_credit" => trim($request->type_credit_agent_credit),
                "taux_agent_credit" => trim($request->taux_agent_credit),
                "nantissement_agent_credit" => trim($request->Nantissement_agent_credit),
                "garantie_agent_credit" => trim($request->garantie_agent_credit),
                "assurance_agent_credit" => trim($request->assurance_agent_credit),
                "versement_initial_agent_credit" => trim($request->versement_initial_agent_credit),
                "duree_agent_credit" => trim($request->duree_agent_credit),
                "periodicite_agent_credit" => trim($request->periodicite_agent_credit),
                "periode_de_grace_agent_credit" => trim($request->periode_de_grace_agent_credit),
                "commentaire_agent_credit" => trim($request->commentaire_agent_credit),
                "nom_et_prenom_agent_credit" => trim($request->nom_et_prenom_agent_credit),
                
                
                "avis_commentaire_credit_comite" => trim($request->avis_comite),
                "montant_propose_comite" => trim($request->montant_propose_avis),
                "type_credit_comite" => trim($request->type_credit_avis),
                "taux_comite" => trim($request->taux_avis),
                "nantissement_com" => trim($request->nantissement_avis),
                "garantie_comite" => trim($request->garantie_avis),
                "assurance_comite" => trim($request->assurance_avis),
                "versement_initial_comite" => trim($request->versement_initial_avis),
                "duree_comite" => trim($request->duree_avis),

                "periodicite_comite" => trim($request->periodicite_avis),
                "periode_de_grace_comite" => trim($request->periode_de_grace_avis),
                "commentaire_avis_credit" => trim($request->commentaire_avis),
                "nom_et_prenom_credit" => trim($request->nom_et_prenom_avis),

                //"doc_materiel_garantie2" => trim($request->doc_materiel_garantie2),
                //"mode_description2" => trim($request->mode_description2),
               
                );
    
             //dd($values);
             Analyse::create($values);

            Demande_credit::Where('id', $request->demande_credit_id)
            ->update([
                'statut' => 'attente_avis'
            ]);
        

         $request->session()->flash('msg_success', 'The fiche of analyse was successfully created!');
        return back();
    }

    public function demande_attente()
    {
        
       if (! Gate::allows('is-direction') && ! Gate::allows('is-chef-service-credit') ) {
            return view('errors.403');
        }

       $title = 'Liste des demandes en attente d\'avis';


       $demande_attentes = Analyse::Join('demande_credits', 'demande_credits.id', '=', 'analyses.demande_credit_id')
        ->Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
        ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'demande_credits.id')
        ->Join('clients', 'accounts.client_id', '=', 'clients.id')
        ->Join('users', 'users.id', '=', 'demande_credits.user_id')
        ->Select('demande_credits.*', 'clients.nom', 'clients.prenom', 'analyses.id as analyse_id')
        ->Where('demande_credits.statut', 'attente_avis')
        ->Where('users.agence_id', Auth::user()->agence_id)
        ->get();

       //dd($demande_attentes);

        return view('pages.credits.liste_demande_attente_avis')
        ->with('title', $title)
        ->with('demande_attentes', $demande_attentes);
    }

    public function Avis_consulting($id)
    {
        
        if (! Gate::allows('is-direction') && ! Gate::allows('is-chef-service-credit') ) {
            return view('errors.403');
        }

        $title = 'Avis sur la demande';
        
        $_consulting = Analyse::Join('demande_credits', 'demande_credits.id', '=', 'analyses.demande_credit_id')
        ->Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
        ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'demande_credits.id')
        ->Join('clients', 'accounts.client_id', '=', 'clients.id')
        ->Join('users', 'users.id', '=', 'demande_credits.user_id')
        ->Select('analyses.*', 'clients.nom', 'clients.prenom', 'analyses.id as analyse_id')
        ->Where('analyses.id', $id)
        ->Where('users.agence_id', Auth::user()->agence_id)
        ->first();

        $type_credits = DB::table('type_credits')->get();


        


        return view('pages.credits.avis_consulting')
        ->with('_consulting', $_consulting)
        ->with('id', $id)
        ->with('type_credits', $type_credits)
        ->with('title', $title);
    }
    public function SendAvis(Request $request)
    {
        
        Avis::create([

            "analyse_id" => $request->analyse_id,
            "avis_comite" => trim($request->proposition_agent_credit),
            "montant_propose" => trim($request->montant_propose_agent_credit),
            "type_credit_avis" => trim($request->type_credit_agent_credit),
            "taux_avis" => trim($request->taux),
            "nantissement_avis" => trim($request->Nantissement_agent_credit),
            "garantie_avis" => trim($request->garantie_agent_credit),
            "assurance_avis" => trim($request->assurance_agent_credit),
            "versement_initial_avis" => trim($request->versement_initial_agent_credit),
            "duree_avis" => trim($request->duree_agent_credit),
            "periodicite_avis" => trim($request->periodicite_agent_credit),
            "periode_de_grace_avis" => trim($request->periode_de_grace_agent_credit),
            "commentaire_avis" => trim($request->commentaire_agent_credit),
            "date_avis" => date('d/m/Y'),
            "user_id" => Auth::user()->id,

        ]);

        $request->session()->flash('msg_success', 'Votre avis a ete soumis avec succès !');
        return back();
    }


    /***USERS***/
    public function users()
    {
        if (! Gate::allows('is-admin')) {
            return view('errors.403');
        }

        

        //dd($code);

        $title = "Utilisateurs";
        $users = User::join('roles', 'roles.id', '=', 'users.role_id')
        ->join('agences', 'agences.id', '=', 'users.agence_id')
        ->select('users.*', 'agences.name as nom_agence', 'agences.id as id_agence', 'roles.name as role_name', 'roles.id as role_id')
        ->OrderBy('users.id', 'DESC')
        ->get();

        $agences = Agence::OrderBy('name', 'ASC')->get();

        $roles = Role::OrderBy('name', 'ASC')->get();

        return view('pages.users.index')
        ->with('roles', $roles)
        ->with('users', $users)
        ->with('agences', $agences)
        ->with('title', $title);
    }

    public function addUser(Request $request)
    {

        if ( !isset($request->nom) || empty($request->nom) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le nom');
        }elseif ( !isset($request->prenom) || empty($request->prenom) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le Prenoms');
        }elseif ( !isset($request->email) || empty($request->email) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir un email valide');
        }elseif ( !isset($request->role) || empty($request->role) ) {
            $request->session()->flash('msg_error', 'Vous devez choisir le role');
        }else{


            if ( $request->password != $request->confirm_password ) {
                $request->session()->flash('msg_error', 'Les deux mots de passe ne correspondent pas !');
            }else{

                if ( strlen($request->password) < 6 ) {
                    $request->session()->flash('msg_error', 'Le mot de passe doit avoir au moins 6 caracteres !');
                }else{

                    $code = substr(strtoupper($request->nom), 0, 2) . substr(strtoupper($request->prenom), 0, 2) . rand(1000, 9999);

                     User::create([
                        'nom' => $request->nom,
                        'prenom' => $request->prenom,
                        'email' => $request->email,
                        'role_id' => $request->role,
                        'matricule' => $code,
                        'agence_id' => $request->agence,
                        'password' => Hash::make($request->password),
                    ]);
                }
             $request->session()->flash('msg_success', 'Vous avez crée cet utilisateur avec succès!');
            }
        }
        return back();
    }

    public function editUser(Request $request)
    {

        if ( !isset($request->nom) || empty($request->nom) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le nom');
        }elseif ( !isset($request->prenom) || empty($request->prenom) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le Prenoms');
        }elseif ( !isset($request->email) || empty($request->email) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir un email valide');
        }elseif ( !isset($request->role) || empty($request->role) ) {
            $request->session()->flash('msg_error', 'Vous devez choisir le role');
        }else{

             User::Where('id', $request->edit_id)
             ->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'role_id' => $request->role,
                'agence_id' => $request->agence,
            ]);
                
             $request->session()->flash('msg_success', 'Vous avez modifié cet utilisateur avec succès!');
            }
        
        return back();
    }

    public function delUser(Request $request)
    {
        
        User::findOrFail($request->id)->delete();
        $request->session()->flash('msg_error', 'Vous avez supprimé cet utilisateur avec succès!');

        return back();
    }

    public function permissions()
    {

        if (! Gate::allows('is-admin')) {
            return view('errors.403');
        }


        $title = "Permissions";
        $permissions = Permission::OrderBy('id', 'DESC')->get();
        $roles = Role::OrderBy('name', 'ASC')->get();
        return view('pages.users.permissions')
        ->with('permissions', $permissions)
        ->with('roles', $roles)
        ->with('title', $title);
    }

    public function permissionRole($role_id)
    {
        $permissions = DB::table('permission_role')
        ->where('role_id', $role_id)
        ->get()
        ->pluck("permission_id");

        return json_encode($permissions) ; 
    }

    public function permissionCreate()
    {
        // code...
        $title = "Permissions";
        $permissions = Permission::OrderBy('groupe', 'ASC')->get();

        return view('pages.users.create_permission')
        ->with('permissions', $permissions)
        ->with('title', $title);
    }

    public function permissionEdit($id)
    {

        $title = "Editer une permission";
        $permission = Permission::Where('id', $id)->first();
        $permissions = Permission::OrderBy('groupe', 'ASC')->get();
        //dd($permission);
        return view('pages.users.edit_permission')
        ->with('permission', $permission)
        ->with('permissions', $permissions)
        ->with('title', $title);
    }


    public function permissionCreateValid(Request $request)
    {
        if ( !isset($request->nom) || empty($request->nom) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le nom de la permission');
        }else{
            DB::table("permissions")->insert([
                "name" => $request->nom, 
                "description" => $request->description,
                "groupe" => strtoupper($request->groupe)
            ]);
            $request->session()->flash('msg_success', 'Vous avez ajouté la permission avec succès!');
        }

        return back(); 
    }

    public function permissionEditValid(Request $request)
    {
        if( !isset($request->nom) || empty($request->nom) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le nom de la permission');
        }else{
            DB::table('permissions')->Where("id", $request->permission_id)
            ->update([
                "name" => $request->nom, 
                "description" => $request->description,
                "groupe" => strtoupper($request->groupe)
            ]);
            $request->session()->flash('msg_success', 'Vous avez modifié la permission avec succès!');
        }

        return back(); 
    }

    public function assign(Request $request)
    {
        //
        
        if( DB::table("permission_role")->where('role_id', $request->role_id)->where('permission_id', $request->permission_id)->first() ) {   
            echo "Permission Deja accordee a cet utilisateur";
        }else{
            DB::table("permission_role")->insert(["role_id" => $request->role_id, "permission_id" => $request->permission_id]); 
            echo "Inertion effectue";
        }

        //flashMe()->error();
        return back();
    }

    public function mutilple_assign(Request $request)
    {
        
        DB::table('permission_role')->where('role_id', $request->role_id )->delete();

        foreach ($request->permissions as $item) {
            # code...
            DB::table("permission_role")->insert(["role_id" => $request->role_id, "permission_id" => $item]); 
            //echo "1";
        }

        $request->session()->flash('msg_success', 'Permission attribuee avec succès!');

        return back();
    }



    /***FIN USERS***/

    /***DEVISE***/

    public function devises()
    {
        $title = "Monnaies";
        $devises = Devise::OrderBy('name', 'ASC')->get();

        return view('pages.devises.index')
        ->with('devises', $devises)
        ->with('title', $title);
    }

    public function deviseAdd(Request $request)
    {
       $title = "Devises";

        if ( !isset($request->name) || empty($request->name) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le nom de la monnaie');
        }else{
            //Ajout d'une monnaie
            Devise::create([
                'name' => $request->name,
                'description' => $request->description
            ]);

            $request->session()->flash('msg_success', 'Vous avez ajouté une monnaie succès!');
        }

        return back()
        ->with('title', $title);
    }

    /***FIN DEVISE***/

    /***ACCOUNTS***/
    public function accounts()
    {
        $title = "Listes des comptes";

        $membres = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
        ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
        ->select('clients.*', 'accounts.number_account', 'type_accounts.name as type')
        ->get();

        return view('pages.accounts.index')
        ->with('membres', $membres)
        ->with('title', $title);
    }

    public function accountCreate()
    {
        $title = "Ouverture de compte du ".date('d/m/Y');
        $start_number = "1284";
        $end_number = "001";
        $rand = rand(1111111, 9999999);

        while( strlen($rand) < 7 ){
            $rand = rand(1111111, 9999999);
        }

        $number_account = $start_number.$rand.$end_number;

        //dd($number_account);
        $type_accounts = Type_account::OrderBy('name', 'ASC')->get();

        return view('pages.accounts.create')
        ->with('number_account', $number_account)
        ->with('type_accounts', $type_accounts)
        ->with('title', $title);
    }

    public function accountCreateValid(Request $request)
    {
        // code...
        $title = "Type de comptes";

        $values = array(

                // page 1
                "nom" => trim($request->nom),
                "prenom" => trim($request->prenom),
                "type_compte" => trim($request->type_compte),
                "raison_social" => trim($request->raison_social),
                "nom_association" => trim($request->nom_association),
                "nombre_membres" => trim($request->nombre_membres),
                "nationalite" => trim($request->nationalite),
                "cni_client" => trim($request->cni_client),

                // page 2
                "date_delivrance" => trim($request->date_delivrance),
                "lieu_delivrance" => trim($request->lieu_delivrance),
                "date_naissance" => trim($request->date_naissance),
                "lieu_naissance" => trim($request->lieu_naissance),
                "etat_civil" => trim($request->etat_civil),
                "profession" => trim($request->profession),
                "employeur" => trim($request->employeur),
                "lieu_activite" => trim($request->lieu_activite),
                "quartier" => trim($request->quartier),
                "telephone" => trim($request->telephone),
                "commune" => trim($request->commune),
                "adresse" => trim($request->adresse),

                // page 3
                "nom_conjoint" => trim($request->nom_conjoint),
                "agence_id" => Auth::user()->agence_id,

            );

        $client = Client::create($values);

        Account::create([
                "number_account" => $request->numero_compte,
                "type_account_id" => $request->type_compte,
                "client_id" => $client->id,
                "date_ouverture_compte" => trim($request->date_ouverture_compte),
                "date_cloture_compte" => trim($request->date_cloture_compte),
                "cni_signataire1" => trim($request->cni_signataire1),
                "nom_prenom_signataire1" => trim($request->nom_prenom_signataire1),
                "nom_prenom_signataire2" => trim($request->nom_prenom_signataire2),
                "cni_signataire2" => trim($request->cni_signataire2),
                "nom_prenom_signataire3" => trim($request->nom_prenom_signataire3),
                "cni_signataire3" => trim($request->cni_signataire3),
                "telephone_signataire1" => trim($request->telephone_signataire1),
                "telephone_signataire2" => trim($request->telephone_signataire2),
                "telephone_signataire3" => trim($request->telephone_signataire3),
                "pouvoir_signataires" => trim($request->pouvoir_signataires),
                "nom_heritier1" => trim($request->nom_heritier1),
                "nom_heritier2" => trim($request->nom_heritier2),
                "nom_heritier3" => trim($request->nom_heritier3),
                "nom_mandataire" => trim($request->nom_mandataire),
                "cni_mandataire" => trim($request->cni_mandataire),
                "telephone_mandataire" => trim($request->telephone_mandataire),
                "user_id" => Auth::user()->id,
        ]);

        $request->session()->flash('msg_success', 'Vous avez ouvert le compte avec succès !');
        
        return back()
        ->with('title', $title);
    }

    public function accountsSolde()
    {
        
        $title = "Soldes";
        $soldes = Account::join('clients', 'clients.id', '=', 'accounts.client_id')
        ->OrderBy('accounts.solde', 'DESC')->get();

        $total_solde = 0;

        foreach ($soldes as $key => $value) {
            $total_solde = $total_solde + $value->solde;
        }

        return view('pages.accounts.solde')
        ->with('soldes', $soldes)
        ->with('total_solde', $total_solde)
        ->with('title', $title);

    }

    public function type()
    {
        
        $title = "Type de comptes";
        $type_accounts = Type_account::OrderBy('name', 'ASC')->get();
        return view('pages.accounts.type')
        ->with('type_accounts', $type_accounts)
        ->with('title', $title);

    }

    public function typeCreate(Request $request)
    {
        
        $title = "Type de comptes";

        if ( !isset($request->name) || empty($request->name) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le nom du type de compte');
        }else{
            //Ajout d'une monnaie
            Type_account::create([
                'name' => $request->name,
                'description' => $request->description
            ]);

            $request->session()->flash('msg_success', 'Vous avez ajouté un type de compte avec succès!');
        }

        return back()
        ->with('title', $title);
        
    }
    /***FIN ACCOUNTS***/


    /***RECEPTION***/
    public function DemandeCredit()
    {
        if (! Gate::allows('is-receptioniste')) {
            return view('errors.403');
        }

        $title = 'Liste des demandes de credits';

        $demandes = Demande_credit::Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.id')
       ->Where('demande_credits.user_id', Auth::user()->id)
       ->Select('demande_credits.*', 'clients.nom', 'clients.prenom')
       ->OrderBy('demande_credits.created_at', 'DESC')
       ->get();

       //dd($demandes);
        return view('pages.receptions.index')
        ->with('demandes', $demandes)
        ->with('title', $title);
    }

    public function DemandeCreditStep2(Request $request)
    {

        if (! Gate::allows('is-receptioniste')) {
            return view('errors.403');
        }

        $title = 'Montage de la demande de credit';

        if ( !isset( $request->flash ) || empty($request->flash) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le numero du compte client');

        }else{

            $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('accounts.number_account', $request->flash)
            ->first();

            if ( $data ) {

                $docs = Doc_credit::Where('client_id', $request->flash)->orderBy('id', 'DESC')->get();

                $type_credits = DB::table('type_credits')->latest()->get();
                $flash = $request->flash;
                $rand = rand(9999,9999999);

                return view('pages.receptions.demande-step-2')
                ->with('data', $data)
                ->with('flash', $flash)
                ->with('rand', $rand)
                ->with('docs', $docs)
                ->with('type_credits', $type_credits)
                ->with('title', $title);
            }else{
                $request->session()->flash('msg_error', 'Le numero du compte que vous avez saisi ne correspond a aucun compte. Merci de renseigner un bon numero de compte.');
                return back()
                ->with('title', $title);
            }

        }
    }

    public function DemandeCredit2(Request $request)
    {
        if (! Gate::allows('is-receptioniste')) {
            return view('errors.403');
        }

        $title = 'Ajouter les documents';

        $type = $request->type;
        $amount = intval(str_replace(' ', '', $request->amount));;
        $number_account = $request->flash;
        $rand = $request->rand;

        
        $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
        ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
        ->Where('accounts.number_account', $request->flash)
        ->first();

        $demande = Demande_credit::Where('statut', 'sent')
        ->Where('client_id', $request->flash)
        ->first();

        //dd($demande);

        $docs = Doc_credit::Where('client_id', $request->flash)->orderBy('id', 'DESC')->get();
        $type_credits = DB::table('type_credits')->latest()->get();


        return view('pages.receptions.demande-2')
        ->with('data', $data)
        ->with('docs', $docs)
        ->with('type', $type)
        ->with('demande', $demande)
        ->with('rand', $rand)
        ->with('amount', $amount)
        ->with('title', $title);

      
    }

    public function AddFilesCredit(Request $request)
    {

        
        if ( !isset($request->libelle) || empty($request->libelle) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le libelle !');
        }elseif( !isset($request->file) || empty($request->file) ){
            $request->session()->flash('msg_error', 'Vous devez selectionner le fichier !');
        }else{

            $ext = $request->file->getClientOriginalExtension();
            $name = time().'.'.$ext;
            $request->file->move(public_path().'/assets/docs/credits/', $name);

           // dd($request->code,$request->num_account);
            Doc_credit::create([
                'libelle' => $request->libelle,
                'file' => $name,
                'code' => $request->code,
                'client_id' => $request->num_account,
            ]);

            $request->session()->flash('msg_success', 'Vous avez ajouté un fichier avec succès !');
        }
        

        return back();
    }


    public function SendDemandeCredit(Request $request)
    {
        $send_demande = Demande_credit::create([
            'client_id' => $request->num_account,
            'montant_demande' => $request->amount,
            'type_credit' => $request->type,
            'user_id' => Auth::user()->id,
        ]);

        
        Demande_credit_doc::create([
            'code_doc' => $request->code,
            'demande_credit_id' => $send_demande->id,
        ]);

        $request->session()->flash('msg_success', 'Vous avez effectué une demande de credit et la demande sera par traité l\'analyste!');
        return back();

    }

    public function ListDemandes()
    {
       
       $title = 'Liste des demandes';

       $demandes = Demande_credit::Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.id')
       ->Select('demande_credits.*', 'clients.nom', 'clients.prenom')
       ->OrderBy('demande_credits.created_at', 'DESC')
       ->get();

       //$assign = Analyste_demande::Where('demande', $demande->id)->first();

       return view('pages.credits.view')
       ->with('title', $title)
       ->with('demandes', $demandes);

    }

    public function ListDemandesAssign()
    {
       
       $title = 'Liste des demandes';

       $demandes = Demande_credit::Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
       ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'demande_credits.id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.id')
       ->Select('demande_credits.*', 'clients.nom', 'clients.prenom')
       ->OrderBy('demande_credits.created_at', 'DESC')
       ->Where('analyste_demandes.analyste', Auth::user()->id)
       ->get();
       
       //Il faut vraiment du code dans la section du code
       
       return view('pages.credits.list_assign')
       ->with('title', $title)
       ->with('demandes', $demandes);

    }

    public function CompleteDemandes($id)
    {
        $title = "Completer la demande";
        

        $demande = Demande_credit::Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
       ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'demande_credits.id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.id')
       ->Select('demande_credits.*', 'clients.nom', 'clients.prenom')
       ->OrderBy('demande_credits.created_at', 'DESC')
       ->Where('demande_credits.id', $id)
       ->first();

       $type_credits = DB::table('type_credits')->latest()->get();
       $taux = DB::table('taux_interets')->latest()->get();


        return view('pages.credits.complete_info')
        ->with('title', $title)
        ->with('taux', $taux)
        ->with('demande_id', $id)
        ->with('type_credits', $type_credits)
        ->with('demande', $demande);
    }

    public function CompleteDemandesStep2(Request $request, $id)
    {

        $title = "Completer la demande";

        $demande = Demande_credit::Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
       ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'demande_credits.id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.id')
       ->Select('demande_credits.*', 'clients.nom', 'clients.prenom')
       ->OrderBy('demande_credits.created_at', 'DESC')
       ->Where('demande_credits.id', $id)
       ->first();

       //Injecter dans la session
        $request->session()->put('data_step_2', $request->all());

        return view('pages.credits.complete_info_2')
        ->with('demande', $demande)
        ->with('title', $title);

    }

    public function CompleteDemandesStep3(Request $request, $id)
    {

        $title = "Completer la demande";

        $demande = Demande_credit::Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
       ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'demande_credits.id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.id')
       ->Select('demande_credits.*', 'clients.nom', 'clients.prenom')
       ->OrderBy('demande_credits.created_at', 'DESC')
       ->Where('demande_credits.id', $id)
       ->first();

       $request->session()->put('data_step_3', $request->all());

        return view('pages.credits.complete_info_3')
        ->with('demande', $demande)
        ->with('title', $title);
    }

    public function DetailDemandes($id)
    {
        
        $title = 'Détails de la demande';
        $demande = Demande_credit::Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
           ->Join('demande_credit_docs', 'demande_credits.id', '=', 'demande_credit_docs.demande_credit_id')
           //->Join('doc_credits', 'doc_credits.code', '=', 'demande_credit_docs.code')
           ->Join('clients', 'accounts.client_id', '=', 'clients.id')
           ->Select('demande_credits.*', 'clients.nom', 'clients.prenom', 'demande_credit_docs.code_doc')
           ->Where('demande_credits.id', $id)->first();

           //Ici pour les enfants, je suis pas
        return view('pages.credits.detail_demande')
        ->with('title', $title)
        ->with('demande', $demande);
    }

    public function TauxInterets()
    {
        $title = 'Taux Interet';

        $taux = DB::table('taux_interets')->latest()->get();
        return view('pages.taux_interets.index')
        ->with('title', $title)
        ->with('taux', $taux);
    }

    public function TauxInteretCreate(Request $request)
    {
        
        Taux_interet::create([
            'taux' => $request->taux / 100
        ]);
        $request->session()->flash('msg_success', 'Taux Interet crée avec succès !');
        return back();
    }


    public function TauxInteretGet($id)
    {
        $title = "Editer le taux";
        $t = Taux_interet::Where('id', $id)->first();
        $taux = DB::table('taux_interets')->latest()->get();

        return view('pages.taux_interets.edit_taux')
        ->with('taux', $taux)
        ->with('t', $t)
        ->with('title', $title);
    }

    public function TauxInteretEdit(Request $request)
    {
        
        Taux_interet::Where('id', $request->taux_id)
        ->update([
            'taux' => $request->taux / 100
        ]);
        $request->session()->flash('msg_success', 'Taux Interet editer avec succès !');
        return back();
    }

    public function sendDemandeAnalyste($id)
    {
        
        $title = 'Envoyer cette demande à l\'un des analyste';

        $demande = Demande_credit::Join('accounts', 'accounts.number_account', '=', 'demande_credits.client_id')
           ->Join('demande_credit_docs', 'demande_credits.id', '=', 'demande_credit_docs.demande_credit_id')
           //->Join('doc_credits', 'doc_credits.code', '=', 'demande_credit_docs.code')
           ->Join('clients', 'accounts.client_id', '=', 'clients.id')
           ->Select('demande_credits.*', 'clients.nom', 'clients.prenom', 'demande_credit_docs.code_doc')
           ->Where('demande_credits.id', $id)->first();

        $analystes = User::Where('role_id', 7)
        ->Where('agence_id', Auth::user()->agence_id)
        ->get();

        $assign = Analyste_demande::Where('demande', $demande->id)->first();

        return view('pages.credits.send_demande_analyste')
        ->with('analystes', $analystes)
        ->with('title', $title)
        ->with('assign', $assign)
        ->with('demande', $demande);

    }

    public function sendDemandeAnalysteValide(Request $request)
    {

        Analyste_demande::create([
            'analyste' => $request->analyste,
            'demande' => $request->demande,
        ]);

        $request->session()->flash('msg_success', 'Vous avez assigné une demande avec succès!');
        return redirect()->route('liste-demandes');
    }

    /***FIN RECEPTION***/

    /***AGENCE***/
    public function agences()
    {
        $title = "Listes des agences";
        $agences = Agence::OrderBy('name', 'ASC')->get();
        return view('pages.agences.index')
        ->with('agences', $agences)
        ->with('title', $title);
    }

    public function agenceCreate(Request $request)
    {
        
        $title = "Listes des agences";

        if ( !isset($request->nom) || empty($request->nom) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le nom agence');
        }elseif ( !isset($request->ville) || empty($request->ville) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir la ville');
        }elseif ( !isset($request->quartier) || empty($request->quartier) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le quartier');
        }else{
            Agence::create([
                'name' => $request->nom,
                'quartier' => $request->quartier,
                'ville' => $request->ville,
                'adresse' => $request->adresse,
                'tel' => $request->tel,
            ]);

            $request->session()->flash('msg_success', 'Vous avez ajouté une agence avec succès!');
        }

        return back();
    }

    public function agenceEditValid(Request $request)
    {
        
        $title = "Listes des agences";

        if ( !isset($request->nom) || empty($request->nom) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le nom agence');
        }elseif ( !isset($request->ville) || empty($request->ville) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir la ville');
        }elseif ( !isset($request->quartier) || empty($request->quartier) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le quartier');
        }else{
            Agence::Where('id', $request->agence_id)
            ->update([
                'name' => $request->nom,
                'quartier' => $request->quartier,
                'ville' => $request->ville,
                'adresse' => $request->adresse,
                'tel' => $request->tel,
            ]);

            $request->session()->flash('msg_success', 'Vous avez modifié cette agence avec succès!');
        }

        return back();
    }

    public function agenceEdit($id)
    {
        $title = "Modifier cette agence";
        $agence = Agence::Where('id', $id)->first();

        $agences = Agence::latest()->get();
        return view('pages.agences.edit')
        ->with('agence', $agence)
        ->with('agences', $agences)
        ->with('title', $title);
    }
    /***FIN AGENCE***/




    /**CHEQUIERS**/
    public function chequiers()
    {
        $title = 'Liste des Chequiers';

        $chequiers = Chequier::join('accounts', 'accounts.id', '=', 'chequiers.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->Where('chequiers.guichetier', Auth::user()->id)
        ->OrderBy('chequiers.id', 'DESC')
        ->get();

        return view('pages.chequiers.index')
        ->with('chequiers', $chequiers)
        ->with('title', $title);
    }

    public function chequierStart()
    {
        $title = 'Commencer la demande de Chequiers';


        return view('pages.chequiers.demarrage')
        ->with('title', $title);
    }

    public function chequierSearch(Request $request)
    {
        $title = 'Commencer la demande de Chequiers';

        //dd($request->num_account);
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        if ( !isset( $request->flash ) || empty($request->flash) ) {
            
            $request->session()->flash('msg_error', 'Vous devez saisir le numero du compte client');
            return back();

        }else{

            $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('accounts.number_account', trim($request->flash))
            ->first();

            if ( $data ) {
                //dd($data);
                return view('pages.chequiers.new')
                ->with('data', $data)
                ->with('title', $title);

            }else{
                $request->session()->flash('msg_error', 'Le numero du compte que vous avez saisi ne correspond a aucun compte. Merci de renseigner un bon numero de compte.');
                return back()
                ->with('title', $title);
            }

        }
    }

    public function chequierValide(Request $request)
    {

        $init = "REF-CHEQ-";
        $rand = rand(111111, 999999);
        $date = date("Ymd");

        $code = $init.$rand.$date;

        //dd($request->all());

        Chequier::create([
            'reference' => $code,
            'account_id' => $request->num_account,
            'qte' => $request->nb_chequiers,
            'montant' => $request->amount,
            'type' => $request->type_carnet_cheque,
            'montant_total' => intval($request->amount * $request->nb_chequiers),
            'date_order' => date('d/m/Y'),
            'heure_order' => date('H:i:s'),
            'guichetier' => Auth::user()->id,
        ]);

        $account = Account::Where('number_account', $request->num_account)->first();
        
        Account::Where('number_account', $request->num_account)
        ->update([
            'solde' => intval($account->solde) - intval($request->amount*$request->nb_chequiers),
        ]);

        $agence = Agence::Where('id', Auth::user()->agence_id)->first();

        Agence::Where('id', $agence->id)
        ->update([
            'solde_principal' => $agence->solde_principal + intval($request->amount * $request->nb_chequiers)
        ]);

        return redirect()->route('chequiers-succes', strtolower($code));
    }

    public function chequierSuccess($ref)
    {
        $ref = $ref;
        return view('pages.chequiers.succes')->with('ref', $ref);
    }

    public function chequierPrint($ref)
    {
        $data = [
            
            'logo' => 'assets/images/logo/hopeFund.png',
            'v' => Chequier::leftjoin('accounts', 'accounts.number_account', '=', 'chequiers.account_id')
                ->join('clients', 'clients.id', '=', 'accounts.client_id')
                ->join('users', 'users.id', '=', 'chequiers.guichetier')
                ->join('agences', 'agences.id', '=', 'users.agence_id')
                ->select('chequiers.*', 'clients.nom', 'clients.prenom', 'agences.name as nom_agence', 'users.matricule')
                ->Where('chequiers.guichetier', Auth::user()->id)
                ->Where('chequiers.reference', strtoupper($ref))
                ->OrderBy('chequiers.id', 'DESC')
                ->first()
        ];
        
        //dd($data);
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.chequiers.print', $data)->render();

        // Convertir la vue en PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'portrait'); 

        $dompdf->render();

        // Générer le fichier PDF
        $output = $dompdf->output();
        
        // Enregistrer le fichier PDF
        $filename = date('dmY').'-recu_chequiers.pdf';
        file_put_contents($filename, $output);
        
        //$dompdf->stream();

        // Retourner une réponse avec le nom de fichier pour le téléchargement
       // return response()->loadView($filename);
        return $dompdf->stream($filename, ['Attachment' => false]);
        //return view('pages.caisses.print_close_caisse');
    }

    /**FIN CHEQUIERS**/

    /** RELEVES DE COMPTES**/

    public function releveStart()
    {
        return view('pages.releves.demarrage');
    }

    public function releveSearch(Request $request)
    {

        

        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }
        $title = 'Relevé de comptes';
        if ( !isset( $request->flash ) || empty($request->flash) ) {
            
            $request->session()->flash('msg_error', 'Vous devez saisir le numero du compte client');
            return back();

        }else{

            $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('accounts.number_account', trim($request->flash))
            ->first();


            if ( $data ) {

                $operations = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', trim($request->flash))
                ->select('operations.*', 'type_operations.name')
                ->OrderBy('operations.id', 'DESC')
                ->get();

                $account_num = trim($request->flash);


                /*$operations = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', $account)
                ->select('operations.*', 'type_operations.name',)
                ->OrderBy('operations.id', 'DESC')
                ->get();*/
        

                $client = Account::join('clients', 'clients.id', '=', 'accounts.client_id')
                        ->Where('accounts.number_account', $account_num)
                        ->first();

                $number_account = $account_num;

                $datas = [
                    
                    'logo' => 'assets/images/logo/hopeFund.png',
                    'number_account' => $number_account,
                ];
                

                //dd($operations);
                // Créer une instance de Dompdf
                $dompdf = new Dompdf();

                // Récupérer la vue à convertir en PDF
                $html = view('pages.releves.print', compact('operations', 'number_account', 'client'))->render();

                // Convertir la vue en PDF
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait'); 

                $dompdf->render();

                // Trouver le nombre de pages
                $canvas = $dompdf->getCanvas();
                $number_of_pages = $canvas->get_page_number();
                $price_per_page = 1000;

                // Calculer le montant total
                $total_amount = $number_of_pages * $price_per_page;
                return view('pages.releves.index')
                ->with('account_num', $account_num)
                ->with('data', $data)
                ->with('number_of_pages', $number_of_pages)
                ->with('price_per_page', $price_per_page)
                ->with('operations', $operations)
                ->with('title', $title);

            }else{
                $request->session()->flash('msg_error', 'Le numero du compte que vous avez saisi ne correspond a aucun compte. Merci de renseigner un bon numero de compte.');
                return back()
                ->with('title', $title);
            }

        }
    }

    public function releveSearch2(Request $request)
    {

        

        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }
        $title = 'Relevé de comptes';

        if ( !isset( $request->flash ) || empty($request->flash) ) {
            
            $request->session()->flash('msg_error', 'Vous devez saisir le numero du compte client');
            return back();

        }else{

            $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('accounts.number_account', trim($request->flash))
            ->first();


            if ( $data ) {

                $date_debut = date_create($request->date_debut);
                $date_debut = date_format($date_debut, 'd/m/Y');

                $date_fin = date_create($request->date_fin);
                $date_fin = date_format($date_fin, 'd/m/Y');

                $operations = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', trim($request->flash))
                ->whereBetween('operations.date_op', [$date_debut, $date_fin])
                ->select('operations.*', 'type_operations.name')
                ->OrderBy('operations.id', 'DESC')
                ->get();

                $account_num = trim($request->flash);
                $date_debut = date_create($request->date_debut);
                $date_debut = date_format($date_debut, 'd-m-Y');

                $date_fin = date_create($request->date_fin);
                $date_fin = date_format($date_fin, 'd-m-Y');

                return view('pages.releves.releve-2')
                ->with('account_num', $account_num)
                ->with('data', $data)
                ->with('date_debut', $date_debut)
                ->with('date_fin', $date_fin)
                ->with('operations', $operations)
                ->with('title', $title);

            }else{
                $request->session()->flash('msg_error', 'Le numero du compte que vous avez saisi ne correspond a aucun compte. Merci de renseigner un bon numero de compte.');
                return back()
                ->with('title', $title);
            }

        }
    }
    public function relevePrint(Request $request)
    {

        $operations = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', $request->num_account)
                ->select('operations.*', 'type_operations.name')
                ->OrderBy('operations.id', 'DESC')
                ->get();
        
        $client = Account::join('clients', 'clients.id', '=', 'accounts.client_id')
                ->Where('accounts.number_account', $request->num_account)
                ->first();
        $number_account = $request->num_account;

        
        $data = [
            
            'logo' => 'assets/images/logo/hopeFund.png',
            'number_account' => $request->num_account,
        ];
        

        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.releves.print', compact('operations', 'number_account', 'client'))->render();

        // Convertir la vue en PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); 

        $dompdf->render();

        // Trouver le nombre de pages
        $canvas = $dompdf->getCanvas();
        $number_of_pages = $canvas->get_page_number();
        $price_per_page = 1000;


        // Calculer le montant total
        $total_amount = $number_of_pages * $price_per_page;

        

        // Générer le fichier PDF
        $output = $dompdf->output();
        
        $rand = rand(999, 99999).''.date('dmY');

        // Enregistrer le fichier PDF
        $filename = $rand.'-recu_releve_bancaire.pdf';
        $filename_dir = public_path('assets/docs/releves/'.$rand.'-recu_releve_bancaire.pdf'); // chemin relatif vers le dossier public
        $account = Account::Where('number_account', $request->num_account)->first();
        
        if ( intval($request->price_per_page * $request->number_of_pages) > intval($account->solde)) {
            $request->session()->flash('msg_error', 'Le solde du client est insufisant !');
            return back();
        }else{
            Releve::create([
                'account_id' => $request->num_account,
                'nombre_page' => $request->number_of_pages,
                'prix_unitaire' => $request->price_per_page,
                'prix_total' => $request->price_per_page * $request->number_of_pages,
                'file' => $filename,
                'user_id' => Auth::user()->id,
            ]);

            Account::Where('number_account', $request->num_account)
            ->update([
                'solde' => intval($account->solde) - intval($request->price_per_page * $request->number_of_pages),
            ]);

        }

        file_put_contents($filename_dir, $output);
        
        //$dompdf->stream();

        // Retourner une réponse avec le nom de fichier pour le téléchargement
        // return response()->loadView($filename);
        
        return $dompdf->stream($filename, ['Attachment' => false]);
        //return view('pages.caisses.print_close_caisse');


    }

    public function releveApercu($account)
    {

        //$pdfPath = storage_path('app/pdf/nom-du-fichier.pdf');

        // initialiser le parser PDF
        $parser = new PdfParser();

        // charger le document PDF
        $document = $parser->parseFile($filename);

        // compter le nombre de pages
        $pageCount = $document->getNumberOfPages();

        //dd($pageCount);

        return view('pages.releves.apercuDoc');

    }


    public function relevePrints($account, $date_debut, $date_fin)
    {
        
            $date_debut = date_create($date_debut);
            $date_debut = date_format($date_debut, 'd/m/Y');

            $date_fin = date_create($date_fin);
            $date_fin = date_format($date_fin, 'd/m/Y');

            $operations = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', $account)
                ->whereBetween('operations.date_op', [$date_debut, $date_fin])
                ->select('operations.*', 'type_operations.name')
                ->OrderBy('operations.id', 'DESC')
                ->get();

        
        $client = Account::join('clients', 'clients.id', '=', 'accounts.client_id')
                ->Where('accounts.number_account', $account)
                ->first();

        $number_account = $account;

        $data = [
            
            'logo' => 'assets/images/logo/hopeFund.png',
            'number_account' => $account,
        ];
        

        //dd($operations);

        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.releves.print', compact('operations', 'number_account', 'client'))->render();

        // Convertir la vue en PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); 

        $dompdf->render();

        // Générer le fichier PDF
        $output = $dompdf->output();
        
        // Enregistrer le fichier PDF
        $filename = date('dmY').'-recu_releve_bancaire.pdf';
        file_put_contents($filename, $output);
        
        //$dompdf->stream();

        // Retourner une réponse avec le nom de fichier pour le téléchargement
       // return response()->loadView($filename);
        return $dompdf->stream($filename, ['Attachment' => false]);
        //return view('pages.caisses.print_close_caisse');


    }
    /**FIN RELEVES DE COMPTES**/
}
