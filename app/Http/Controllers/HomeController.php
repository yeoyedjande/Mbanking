<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Seuil;
use App\Models\Credit;
use App\Models\Type_frais;
use App\Models\Type_credits;
use App\Models\Client;
use App\Models\Devise;
use App\Models\Analyse;
use App\Models\Coffrefort;
use App\Models\Banquexterne;
use App\Models\Type_account;
use App\Models\Account;
use App\Models\Chequier;
use App\Models\Monnaie_billet;
use App\Models\Agence;
use App\Models\Operation;
use App\Models\Correspondance;
use App\Models\Billet;
use App\Models\Billetage_operation;
use App\Models\Avis;
use App\Models\Mouvement;
use App\Models\Compte_global;
use App\Models\Caisse;
use App\Models\Type_operation;
use App\Models\Compte_comptable;
use App\Models\Simulation;
use App\Models\Journal;
use App\Models\Main_account;
use App\Models\Versement;
use App\Models\Taux_interet;
use App\Models\Permission;
use App\Models\Releve;
use App\Models\Doc_credit;
use App\Models\Demande_credit;
use App\Models\Deposant;
use App\Models\Heritier;
use App\Models\Mandataire;
use App\Models\Signataire;
use App\Models\Depense_revenue;
use App\Models\Demande_credit_doc;
use App\Models\Analyste_demande;
use App\Models\Operation_mouvement;
use App\Models\Clients;
use App\Models\Taux;
use App\Models\Type_biens;
use App\Models\Objet_demandes;
use App\Models\Banquexternes;
use App\Models\Sexes;
use App\Models\Etat_credits;
use App\Models\Plafonds;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Gate;

use DB;
use Auth;
use setasign\Fpdi\PdfParser\PdfParser;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

use Dompdf\Dompdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        

        $title = 'Tableau de bord';

        $users = User::count();

        $solde_principal = Compte_comptable::Where('numero', Auth::user()->compte_comptable_id)->first();

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
        ->first();

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


        /*$transactions = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom', 'operations.montant', 'type_operations.name', 'accounts.number_account')
        ->Where('operations.statut', 'valide')
        ->orderBy('operations.id', 'DESC')
        ->paginate(6);*/


        $transactions_caissier = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
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

        $accounts = Account::all();

        $solde_client = 0;
        foreach ($accounts as $value) {
            $solde_client = $solde_client + $value->solde;
        }


        $accountCount = Account::count();

        return view('pages.dashboard.dashboard')
        ->with('transactions_caissier', $transactions_caissier)
        //->with('transactions', $transactions)
        ->with('nb_client', $nb_client)
        ->with('solde_client', $solde_client)
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
        ->with('users', $users)
        ->with('title', $title);
    }

    public function allTransactions()
    {
        $title  = 'Toutes les opérations';

        $transactions = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
        ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom', 'operations.montant', 'type_operations.name', 'accounts.number_account')
        ->Where('operations.statut', 'valide')
        ->orderBy('operations.id', 'DESC')
        ->get();

        return view('pages.transactions.allOperation')
        ->with('transactions', $transactions)
        ->with('title', $title);
    }
    public function carteBancaire()
    {
        // preparation des cartes...
        $title = 'Carte bancaire';
        return view('pages.cartes.index')->with('title', $title);
    }

    public function carteBancaireCheck(Request $request)
    {
        // preparation des cartes...
        $title = 'Carte bancaire';
        $flash = trim($request->flash);

        if ( strlen($flash) >= 16 ) {
            $compte = DB::table('accounts')->where('number_account', $flash)->first();
        }else{
            $rechercheFormattee = str_pad($flash, 6, "0", STR_PAD_LEFT);
            $compte = DB::table('accounts')
                ->where('number_account', 'LIKE', "001-{$rechercheFormattee}%-%%")
                ->first();

        }

        if ($compte) {
        
            $verif = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.code_client')
                    ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                    ->Where('accounts.client_id', $compte->client_id)
                    ->first();

            $qrCode = QrCode::size(200)->generate($verif->client_id);

            $accountNumber = "12345678901275"; // Assurez-vous que cela ait la longueur appropriée
            $prefix = '7';
            // Assurez-vous que la longueur totale sans le chiffre de contrôle est de 15
            $baseNumber = $prefix . $accountNumber;
            $baseNumber = substr($baseNumber, 0, 15);

            $sum = 0;
            $numDigits = strlen($baseNumber) - 1;
            $parity = $numDigits % 2;

            for ($i = $numDigits; $i >= 0; $i--) {
                $digit = $baseNumber[$i];
                if (!$parity == ($i % 2)) {
                    $digit <<= 1;
                }
                $digit = ($digit > 9) ? ($digit - 9) : $digit;
                $sum += $digit;
            }

            $checksum = $sum % 10;
            if ($checksum != 0) {
                $checksum = 10 - $checksum;
            }

            $completeCardNumber = $baseNumber . $checksum;
            $formattedCardNumber = chunk_split($completeCardNumber, 4, ' ');
            // Suppression de l'espace supplémentaire à la fin
            $formattedCardNumber = rtrim($formattedCardNumber);

            // Generate expiration date one year from now
            $currentYear = date('Y');
            $currentMonth = date('m');
            $expirationYear = $currentYear + 1;
            $expirationDate = $currentMonth . '/' . substr($expirationYear, 2); 


            session()->put('formattedCardNumber', $formattedCardNumber);
            session()->put('nom', $verif->nom);
            session()->put('expirationDate', $expirationDate);
            session()->put('qrCode', $qrCode);
            session()->put('clientCode', $verif->client_id);

            return view('pages.cartes.carte_generer')
            ->with('formattedCardNumber', $formattedCardNumber)
            ->with('expirationDate', $expirationDate)
            ->with('qrCode', $qrCode)
            ->with('title', $title)
            ->with('verif', $verif);

        }else{

            $request->session()->flash('msg_error', 'Ce numéro de compte n\'est pas dans le système!');
            return back();

        }
    }

    
    public function CartePrint()
    {

        $dompdf = new Dompdf();

        $code = session('clientCode');
        $imgqrcode = QrCode::format('png')
        ->size(250)
        ->generate($code, 'assets/images/carte_bancaire/qrcode/qr-code.png');

        $qrCodeBase64 = base64_encode(file_get_contents('assets/images/carte_bancaire/qrcode/qr-code.png'));

        //dd($qrCodeBase64);

        $data = [
            'formattedCardNumber' => session('formattedCardNumber'),
            'nom' => session('nom'),
            'qrCode' => session('qrCode'),
            'expirationDate' => session('expirationDate'),
            'formattedCardNumber' => session('formattedCardNumber'),
            'qrCodeBase64' => $qrCodeBase64,
        ];
        
        //dd($data);

        // Récupérer la vue à convertir en PDF
        $html = view('pages.cartes.print', $data)->render();

        // Convertir la vue en PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); 

        $dompdf->render();

        // Générer le fichier PDF
        $output = $dompdf->output();
        

        // Enregistrer le fichier PDF
        $filename = rand(90000, 999999).''.date('dmY').'-carte.pdf';
        file_put_contents(public_path('assets/docs/cartes/'.$filename), $output);
        
        //$dompdf->stream();

        // Retourner une réponse avec le nom de fichier pour le téléchargement
       // return response()->loadView($filename);
        return $dompdf->stream($filename, ['Attachment' => false]);
        //return view('pages.caisses.print_close_caisse');
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
        $demande = Credit::Join('accounts', 'accounts.number_account', '=', 'credits.num_account')
       ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'credits.num_dossier')
       ->Join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.code_client')
       ->Select('credits.*', 'clients.nom', 'clients.prenom', 'type_credits.name', 'type_credits.id as typeCreditId')
       ->OrderBy('credits.date_demande', 'DESC')
       ->Where('analyste_demandes.analyste', Auth::user()->id)
       ->Where('credits.num_dossier', $id)
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
        $dossier = $request->dossier;

        //dd($dossier);
        $date = $request->date_deboursement;
        $dateObj = \DateTime::createFromFormat('Y-m-d', $date);
        $date = $dateObj->format('d/m/Y');

        $amount_frais = $request->amount_frais;
        $periode = $request->periode;
        $type_credit = $request->type_credit;

        $amount = intval(str_replace(' ', '', $request->amount));
        $amount_commission = intval($request->amount_commission);
        $amount_assurances = intval($request->amount_assurances);


        $taux_interet = $request->taux_interet;
        $description = $request->description;


        /**Client**/
        $accountClient = Account::join('clients', 'clients.code_client', '=', 'accounts.client_id')
        ->Where('accounts.number_account', $request->num_account)
        ->first();

        //dd($accountClient);
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
        
        //dd($duree);

        $interet_total = 0;
        
        for ($i=1; $i <= $duree; $i++) { 
            $interet_total = $interet_mensuel + $interet_total;
        }
        $interet_solde_total = $interet_total;

        return view('pages.credits.result_simulation')
        ->with('duree', $duree)
        ->with('dossier', $dossier)
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

        $simulation = Simulation::create([
            'dossier' => $request->dossier,
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
            'nbr_jr' => $request->nbr_jr,
            'user_id' => Auth::user()->id
            
        ]);

        foreach ($request->numero as $key => $value) {
            DB::table('dossier_simulations')
            ->insert([
                'dossier' => $request->dossier,
                'numero' => $value,
                'date' => $request->date[$key],
                'cap_att' => $request->cap[$key],
                'int_att' => $request->int_att[$key],
                //'pen_att' => $request->pen_att[$key],
                'gar_att' => $request->gar_att[$key],
                'total_att' => $request->total_att[$key],
                'cap_sold' => $request->cap_sold[$key],
                'int_sold' => $request->int_sold[$key],
                'gar_sold' => $request->gar_sold[$key],
                'total_sold' => $request->tot_sold[$key],
                'simulation_id' => $simulation->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        
        $dossier = $simulation->id;
        $request->session()->flash('msg_success', 'Vous avez enregistrer cette simulation avec succes!');

        return redirect()->route('simulation-succes', $dossier);

    }


    public function succes_simulation($dossier)
    {
        $dossier = $dossier;

        return view('pages.credits.succes_simulation')
        ->with('dossier', $dossier);

    }

    public function ListeSimulation()
    {
        $title = 'Liste des simulations de crédits';

        $simulations = Simulation::join('credits', 'credits.num_dossier', '=', 'simulations.dossier')
        ->join('type_credits', 'type_credits.id', '=', 'simulations.type_prod')
        ->join('accounts', 'accounts.number_account', '=', 'simulations.client_account')
        ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
        ->select('simulations.*', 'clients.nom', 'clients.prenom', 'type_credits.name')
        ->get();

        //dd($simulations);
        return view('pages.credits.liste_simulation')
        ->with('simulations', $simulations)
        ->with('title', $title);

    }
    public function Printsimulation($dossier)
    {

        $data = [
            'v' => Simulation::join('credits', 'credits.num_dossier', '=', 'simulations.dossier')
                ->join('users', 'users.id', '=', 'simulations.user_id')
                ->join('agences', 'agences.id', '=', 'users.agence_id')
                ->join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
                ->join('clients', 'clients.code_client', '=', 'credits.code_client')
                ->select('simulations.*', 'clients.nom', 'clients.prenom', 'type_credits.name', 'users.matricule', 'agences.name as nom_agence')
                ->where('simulations.id', $dossier)
                ->first()   
            ];


        //dd($data);
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.credits.print', $data)->render();

        // Convertir la vue en PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); 

        $dompdf->render();

        // Générer le fichier PDF
        $output = $dompdf->output();
        

        // Enregistrer le fichier PDF
        $filename = rand(9000, 999999).''.date('dmY').'-recu_simulation.pdf';
        file_put_contents(public_path('assets/docs/simulations/'.$filename), $output);
        
        // Retourner une réponse avec le nom de fichier pour le téléchargement
       // return response()->loadView($filename);
        return $dompdf->stream($filename, ['Attachment' => false]);
        //return view('pages.caisses.print_close_caisse');

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
        ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
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

        $accounts = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.code_client')
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

            $flash = trim($request->flash);

            if ( strlen($flash) >= 16 ) {
                $compte = DB::table('accounts')->where('number_account', $flash)->first();
            }else{
                $rechercheFormattee = str_pad($flash, 6, "0", STR_PAD_LEFT);
                $compte = DB::table('accounts')
                    ->where('number_account', 'LIKE', "001-{$rechercheFormattee}%-%%")
                    ->first();

            }
            //dd($compte);

          
            if ($compte) {
                
            

            $client = DB::table('clients')->Where('clients.code_client', $compte->client_id)
            ->first();

            

            $comptes = DB::table('accounts')->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('accounts.client_id', $compte->client_id)
            ->get();


            $versements = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
            ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
            ->select('operations.*', 'clients.nom', 'clients.prenom')
            ->Where('operations.date_op', date('d/m/Y'))
            ->Where('accounts.client_id', $compte->client_id)
            ->Where('operations.statut', 'valide')
            ->Where('operations.type_operation_id', 3)
            ->get();

            $cumulVersementJour = 0;

            foreach ($versements as $v) {
                $cumulVersementJour = $cumulVersementJour + $v->montant;
            }

                if ( $client ) {
                    
                    $billets = Billet::all();

                    return view('pages.versements.new')
                    ->with('cumulVersementJour', $cumulVersementJour)
                    ->with('billets', $billets)
                    ->with('client', $client)
                    ->with('comptes', $comptes)
                    ->with('title', $title);

                }else{
                    
                }

                }else{
                    $request->session()->flash('msg_error', 'Le numero du compte que vous avez saisi ne correspond a aucun compte. Merci de renseigner un bon numero de compte.');
                    return back()
                    ->with('title', $title);
                }

        }
       
    }

    public function versementNewValid(Request $request)
    {
        if (!Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        $title = "Faire un versement";
        $amount = $request->amount;

        // Validation du montant
        if (!isset($amount) || empty($amount)) {
            $request->session()->flash('msg_error', 'Vous devez saisir le montant à verser');
            return back();
        }

        if (intval($amount) !== intval($request->result_verif)) {
            $request->session()->flash('msg_error', 'Les deux montants ne correspondent pas, veuillez vérifier avant de lancer le versement !');
            return back();
        }

        $cumulVersementJour = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
            ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
            ->whereDate('operations.date_op', now())
            ->where('operations.account_id', $request->num_account)
            ->where('operations.statut', 'valide')
            ->where('operations.type_operation_id', 3)
            ->sum('operations.montant');

        $cumulVersementJourFinal = $cumulVersementJour + $amount;

        $mvmt = Mouvement::where('guichetier', Auth::user()->id)
            ->whereDate('date_mvmt', date('d/m/Y'))
            ->first();

        if (!$mvmt) {
            $request->session()->flash('msg_error', 'Vous devez attendre demain pour faire une operation. Car la caisse est fermée pour aujourd\'hui. Merci !');
            return back();
        }

        $type_op = Type_operation::find(3);
        $montant_limit = 20000000;

        $deposant = Deposant::create([
            'nom_deposant' => $request->nom_deposant,
            'tel_deposant' => $request->tel_deposant
        ]);

        $statutOperation = $cumulVersementJourFinal > $montant_limit ? 'invalid' : 'valide';

        $piece = mt_rand(111111, 999999);
        $pieceExist = Journal::Where('numero_piece', $piece)->first();

        while( $pieceExist ){
            $piece = mt_rand(111111, 999999);
            $pieceExist = Journal::Where('numero_piece', $piece)->first();
        }


        $operation = Operation::create([
            'ref' => "REF-VERS-" .$piece. date("Ymd"),
            'montant' => $amount,
            'type_operation_id' => $type_op->id,
            'account_id' => $request->num_account,
            'date_op' => now()->format('Y-m-d'),
            'heure_op' => now()->format('H:i:s'),
            'statut' => $statutOperation,
            'deposant_id' => $deposant->id,
            'motif' => $request->motif_versement,
            'compte_comptable_id' => '2.2.1.1',
            'user_id' => Auth::user()->id,
        ]);

        Operation_mouvement::create([
            'operation_id' => $operation->id,
            'mouvement_id' => $mvmt->id
        ]);

        $compteComptableDepot = Compte_comptable::where('numero', '2.2.1.1')->first();
        Journal::create([
            'date' => date('Y-m-d'),
            'numero_piece' => $piece,
            'compte' => '2.2.1.1',
            'intitule' => $compteComptableDepot->libelle,
            'credit' => $amount,
            'account_id' => $request->num_account,
            'user_id' => Auth::user()->id,
            'agence_id' => Auth::user()->agence_id,
        ]);

        $compteComptableGuichier = Compte_comptable::where('numero', Auth::user()->compte_comptable_id)->first();

        Journal::create([
            'date' => date('d/m/Y'),
            'numero_piece' => $piece,
            'fonction' => 'Dépôt',
            'reference' => "REF-VERS-" .$piece. date("Ymd"),
            'description' => $request->motif_versement,
            'compte' => Auth::user()->compte_comptable_id,
            'intitule' => $compteComptableGuichier->libelle,
            'debit' => $amount,
            'account_id' => $request->num_account,
            'user_id' => Auth::user()->id,
            'agence_id' => Auth::user()->agence_id,
        ]);

        $billets = Billet::all();

        foreach ($billets as $value) {
            $nombre = $request->{'nb_' . $value->montant} ?? 0;

            Billetage_operation::create([
                'billet' => $request->{'billet_id_' . $value->montant},
                'nombre' => $nombre,
                'operation' => $operation->id,
            ]);
        }

        if ($statutOperation === 'invalid') {
            $request->session()->flash('msg_info', 'Important: Vous avez lancé un retrait qui dépasse le grand seuil limite, donc le service des opérations et la Direction analyseront pour validation !');
            return back()->with(['attentes' => 'invalid', 'title' => $title]);
        }

        // Mise à jour des soldes si l'opération est valide
        $account = Account::where('number_account', $request->num_account)->first();
        $account->increment('solde', $amount);

        $mvmt->increment('solde_final', $amount);

        //$agence = Compte_comptable::find(Auth::user()->agence_id);
        //$agence->decrement('solde_principal', $amount);

        Main_account::create([
            'type_operation_id' => 3,
            'solde_operation' => $amount,
            'solde_final' => $amount,
            'account_id' => $request->num_account,
            'date_operation' => now()->format('d/m/Y'),
            'heure_operation' => now()->format('H:i:s'),
        ]);

        $request->session()->flash('msg_success', 'Vous avez effectué le versement avec succès!');
        return redirect()->route('versement-validate', strtolower($operation->ref));
    }




    public function versementHistorique()
    {
        if (! Gate::allows('is-caissier')) {
            return view('errors.403');
        }

        $title = "Historiques des versements";

        $versements = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
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

            'v' => Operation::join('accounts', 'accounts.number_account', '=', 'operations.account_id')
                ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->join('deposants', 'deposants.id', '=', 'operations.deposant_id')
                ->join('agences', 'agences.id', '=', 'users.agence_id')
                ->select('operations.*', 'clients.nom', 'clients.prenom', 'agences.name as nom_agence', 'users.matricule', 'accounts.solde', 'deposants.nom_deposant', 'deposants.tel_deposant')
                ->Where('operations.user_id', Auth::user()->id)
                ->Where('operations.type_operation_id', 3)
                ->Where('operations.ref', strtoupper($ref))
                ->first()   
            ];

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
        $filename = rand(9000, 999999).''.date('dmY').'-recu_versement.pdf';
        file_put_contents(public_path('assets/docs/recus/versements/'.$filename), $output);
        
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
        ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom')
        ->Where('operations.user_id', Auth::user()->id)
        ->Where('operations.date_op', date('d/m/Y'))
        ->Where('operations.type_operation_id', 2)
        ->OrderBy('operations.id', 'DESC')
        ->get();

        //dd($retraits);

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
        ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
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

        }elseif( !isset( $request->pin_code ) || empty($request->pin_code) ) {
            
            $request->session()->flash('msg_error', 'Vous devez saisir le client doit saisir le code secret de son compte!');

        }else{

            $flash = trim($request->flash);

            if ( strlen($flash) >= 16 ) {
                $compte = DB::table('accounts')->where('number_account', $flash)->first();
            }else{
                $rechercheFormattee = str_pad($flash, 6, "0", STR_PAD_LEFT);
                $compte = DB::table('accounts')
                    ->where('number_account', 'LIKE', "001-{$rechercheFormattee}%-%%")
                    ->first();

            }
            
            if ($compte) {
                
            
            $client = DB::table('clients')->Where('clients.code_client', $compte->client_id)
            ->first();

            if ( $client ) {

               $comptes = DB::table('accounts')->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                ->Where('accounts.client_id', $compte->client_id)
                ->where('accounts.pin_code', $request->pin_code)
                ->get(); 

                $mandataires = Mandataire::where('account_id', $flash)
                ->get(); 

                //dd($comptes);
            }else{
                $request->session()->flash('msg_error', 'Le numéro du compte que vous avez entré n\'existe pas dans cette base de données.');
                return back()
                ->with('title', $title);

            }
            
            


            /*$data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->where('accounts.number_account', $request->flash)
            ->where('accounts.pin_code', $request->pin_code)
            ->first();*/
            

            $retraits = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
            ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
            ->select('operations.*', 'clients.nom', 'clients.prenom')
            ->Where('accounts.client_id', $compte->client_id)
            ->Where('operations.date_op', date('d/m/Y'))
            ->Where('operations.type_operation_id', 2)
            ->get();

            $cumulRetraitJour = 0;

            foreach ($retraits as $r) {
                $cumulRetraitJour = $cumulRetraitJour + $r->montant;
            }

            $retraitMois = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
            ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
            ->select(DB::raw('SUM(operations.montant) as total_retraits'))
            ->Where('accounts.client_id', $compte->client_id)
            ->where('operations.type_operation_id', 2)
            ->whereRaw('MONTH(operations.date_op) = ?', [date('m')])
            ->get();

            $cumulRetraitMonth = 0;

            foreach ($retraitMois as $r) {
                $cumulRetraitMonth = $cumulRetraitMonth + $r->montant;
            }

            if ( $comptes->count() > 0 ) {

                $billets = Billet::all();
                return view('pages.retraits.new')
                ->with('billets', $billets)
                ->with('comptes', $comptes)
                ->with('mandataires', $mandataires)
                ->with('client', $client)
                ->with('cumulRetraitJour', $cumulRetraitJour)
                ->with('cumulRetraitMonth', $cumulRetraitMonth)
                ->with('title', $title);


            }else{
                $request->session()->flash('msg_error', 'Le numero du compte et le code secret ne sont pas associé. Merci de renseigner de bonnes informations.');
                return back()
                ->with('title', $title);
            }
            }else{
                $request->session()->flash('msg_error', 'Le numero du compte et le code secret ne sont pas associé. Merci de renseigner de bonnes informations.');
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

        $title = "Faire un retrait";

        $amount = intval($request->amount);



        if ( !isset($request->amount) || empty($request->amount) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le montant a retirer');
        }else{
            
            $mvmt = Mouvement::Where('guichetier', Auth::user()->id)
            ->Where('date_mvmt', date('d/m/Y'))
            ->first();

            

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

            $rand = mt_rand(111111, 999999);
            $codeExit = Journal::Where('numero_piece', $rand)->first();

            while ($codeExit) {
                // code...
                $rand = mt_rand(111111, 999999);
                $codeExit = Journal::Where('numero_piece', $rand)->first();
            }

            $date = date("Ymd");

            $code = $init.$rand.$date;

            $montant_limit_jour = 15000000;
            $montant_limit_mois = 100000000;
            $montant_limit_operation = 1000000;


            if ( $request->type_personne == 'porteur' ) {
                
                $limit_porteur = 500000;

                if ( $amount > $limit_porteur ) {
                    $request->session()->flash('msg_error', 'Un porteur de cheque ne peut pas effectuer une operation de plus de 500 000 BIF !');
                    return back();
                }else{
                    
                    $account = Account::Where('number_account', $request->num_account)->first();

                    if ( intval($account->solde) < intval($amount) ) {
                        $request->session()->flash('msg_error', 'Le montant que vous voulez retirer est superieur au solde du client, Veuillez réajuster !');
                        return back();
                    }


                    $frais = Type_frais::where('id', $request->frais)->first();
                    if ($frais) {
                        $frais = $frais->montant;
                    }else{
                        $frais = 0;
                    }

                    if ( intval($amount) != intval($request->result_verif) ) {
                        
                        $request->session()->flash('msg_error', 'Les deux montant ne correspondent pas, Veuillez refaire le retrait !');
                        return back();

                    }else{


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
                            'compte_comptable_id' => '2.2.1.1',
                            'date_op' => date('d/m/Y'),
                            'heure_op' => date('H:i:s'),
                            'user_id' => Auth::user()->id,
                        ]);
     

                        Operation_mouvement::create([
                            'operation_id' => $operation->id,
                            'mouvement_id' => $mvmt->id
                        ]);


                        
                        $compteComptableGuichier = Compte_comptable::where('numero', Auth::user()->compte_comptable_id)->first();

                        Journal::create([
                            'date' => date('d/m/Y'),
                            'numero_piece' => $rand,
                            'compte' => Auth::user()->compte_comptable_id,
                            'intitule' => $compteComptableGuichier->libelle,
                            'credit' => $amount,
                            'account_id' => $request->num_account,
                            'user_id' => Auth::user()->id,
                            'agence_id' => Auth::user()->agence_id,
                        ]);

                        //$guich_num_compte = User::Where('id', $request->guichetier)->first();

                        $compteComptableRetrait = Compte_comptable::where('numero', '2.2.1.1')->first();

                        Journal::create([
                            'date' => date('d/m/Y'),
                            'numero_piece' => $rand,
                            'fonction' => 'Retrait',
                            'reference' => $code,
                            'description' => 'Retrait cash',
                            'compte' => '2.2.1.1',
                            'intitule' => $compteComptableRetrait->libelle,
                            'debit' => $amount,
                            'account_id' => $request->num_account,
                            'user_id' => Auth::user()->id,
                            'agence_id' => Auth::user()->agence_id,
                        ]);
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
                                'billet' => $request->$monnaie,
                                'nombre' => $nombre,
                                'operation' => $operation->id,
                            ];

                            Billetage_operation::create($values);

                        }


                        Account::Where('number_account', $request->num_account)
                        ->update([
                            'solde' => intval($account->solde) - intval($amount+$frais),
                        ]);
                        /** Fin Mise a jour du compte client **/

                        /** Mise a jour de la caisse du guichetier **/
                    
                        Mouvement::Where('id', $mvmt->id)
                        ->update([
                            'solde_final' => intval($mvmt->solde_final) - $amount,
                        ]);
                        /** Fin Mise a jour de la caisse du guichetier **/


                        /**Mise a jour du solde principal**/
                        /*$agence = Agence::Where('id', Auth::user()->agence_id)
                        ->first();

                        Agence::Where('id', $agence->id)
                        ->update([
                            'solde_principal' => intval($agence->solde_principal) + intval($amount+$frais),
                        ]);*/

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

            }else{

                
                if ( ($cumulRetraitJourFinal > $montant_limit_jour) && ($cumulRetraitJourFinal < $montant_limit_mois) ) {
                    
                    $account = Account::Where('number_account', $request->num_account)->first();
                
                    if ( intval($account->solde) < intval($amount) ) {
                        $request->session()->flash('msg_error', 'Le montant que vous voulez retirer est superieur au solde du client, Veuillez réajuster !');
                        return back();
                    }


                    if ( intval($amount) != intval($request->result_verif) ) {
                        
                        $request->session()->flash('msg_error', 'Les deux montant ne correspondent pas, Veuillez refaire le retrait !');
                        return back();

                    }else{


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

                    $compteComptableGuichier = Compte_comptable::where('numero', Auth::user()->compte_comptable_id)->first();

                        Journal::create([
                            'date' => date('d/m/Y'),
                            'numero_piece' => $rand,
                            'compte' => Auth::user()->compte_comptable_id,
                            'intitule' => $compteComptableGuichier->libelle,
                            'credit' => $amount,
                            'account_id' => $request->num_account,
                            'user_id' => Auth::user()->id,
                            'agence_id' => Auth::user()->agence_id,
                        ]);

                        //$guich_num_compte = User::Where('id', $request->guichetier)->first();

                        $compteComptableRetrait = Compte_comptable::where('numero', '2.2.1.1')->first();

                        Journal::create([
                            'date' => date('d/m/Y'),
                            'numero_piece' => $rand,
                            'fonction' => 'Retrait',
                            'reference' => $code,
                            'description' => 'Retrait cash',
                            'compte' => '2.2.1.1',
                            'intitule' => $compteComptableRetrait->libelle,
                            'debit' => $amount,
                            'account_id' => $request->num_account,
                            'user_id' => Auth::user()->id,
                            'agence_id' => Auth::user()->agence_id,
                        ]);

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
                            'billet' => $request->$monnaie,
                            'nombre' => $nombre,
                            'operation' => $operation->id,
                        ];

                        Billetage_operation::create($values);

                    }

                    $request->session()->flash('msg_info', 'Important: Vous avez lancé un retrait qui depasse le grand seuil limite du jour, donc le service des operations et la Direction analyseront pour validation !');
                    return back()->with('title', $title);

                    }
                }
                elseif($cumulRetraitMonthFinal > $montant_limit_mois){

                    $account = Account::Where('number_account', $request->num_account)->first();
                
                    if ( intval($account->solde) < $amount ) {
                        $request->session()->flash('msg_error', 'Le montant que vous voulez retirer est superieur au solde du client, Veuillez réajuster !');
                        return back();
                    }

                    if ( intval($amount) != intval($request->result_verif) ) {
                        
                        $request->session()->flash('msg_error', 'Les deux montant ne correspondent pas, Veuillez refaire le retrait !');
                        return back();

                    }else{


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
                        'date_op' => date('d/m/Y'),
                        'heure_op' => date('H:i:s'),
                        'statut' => 'invalid',
                        'user_id' => Auth::user()->id,
                    ]);

                    Operation_mouvement::create([
                        'operation_id' => $operation->id,
                        'mouvement_id' => $mvmt->id
                    ]);

                    $compteComptableGuichier = Compte_comptable::where('numero', Auth::user()->compte_comptable_id)->first();

                        Journal::create([
                            'date' => date('d/m/Y'),
                            'numero_piece' => $rand,
                            'compte' => Auth::user()->compte_comptable_id,
                            'intitule' => $compteComptableGuichier->libelle,
                            'credit' => $amount,
                            'account_id' => $request->num_account,
                            'user_id' => Auth::user()->id,
                            'agence_id' => Auth::user()->agence_id,
                        ]);

                        //$guich_num_compte = User::Where('id', $request->guichetier)->first();

                        $compteComptableRetrait = Compte_comptable::where('numero', '2.2.1.1')->first();

                        Journal::create([
                            'date' => date('d/m/Y'),
                            'numero_piece' => $rand,
                            'fonction' => 'Retrait',
                            'reference' => $code,
                            'description' => 'Retrait cash',
                            'compte' => '2.2.1.1',
                            'intitule' => $compteComptableRetrait->libelle,
                            'debit' => $amount,
                            'account_id' => $request->num_account,
                            'user_id' => Auth::user()->id,
                            'agence_id' => Auth::user()->agence_id,
                        ]);

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
                            'billet' => $request->$monnaie,
                            'nombre' => $nombre,
                            'operation' => $operation->id,
                        ];

                        Billetage_operation::create($values);

                    }

                    $request->session()->flash('msg_info', 'Important: Vous avez lancé un retrait qui depasse le seuil du mois, donc le service des operations analysera pour validation !');
                    return back()->with('title', $title);
                    }

                }elseif(($amount > $montant_limit_operation) && ($amount < $cumulRetraitJourFinal)){


                    $account = Account::Where('number_account', $request->num_account)->first();
                
                    if ( intval($account->solde) < $amount ) {
                        $request->session()->flash('msg_error', 'Le montant que vous voulez retirer est superieur au solde du client, Veuillez réajuster !');
                        return back();
                    }

                    if ( intval($amount) != intval($request->result_verif) ) {
                        
                        $request->session()->flash('msg_error', 'Les deux montant ne correspondent pas, Veuillez refaire le retrait !');
                        return back();

                    }else{

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
                        'date_op' => date('d/m/Y'),
                        'heure_op' => date('H:i:s'),
                        'statut' => 'invalid',
                        'user_id' => Auth::user()->id,
                    ]);

                    Operation_mouvement::create([
                        'operation_id' => $operation->id,
                        'mouvement_id' => $mvmt->id
                    ]);

                    $compteComptableGuichier = Compte_comptable::where('numero', Auth::user()->compte_comptable_id)->first();

                        Journal::create([
                            'date' => date('d/m/Y'),
                            'numero_piece' => $rand,
                            'compte' => Auth::user()->compte_comptable_id,
                            'intitule' => $compteComptableGuichier->libelle,
                            'credit' => $amount,
                            'account_id' => $request->num_account,
                            'user_id' => Auth::user()->id,
                            'agence_id' => Auth::user()->agence_id,
                        ]);

                        //$guich_num_compte = User::Where('id', $request->guichetier)->first();

                        $compteComptableRetrait = Compte_comptable::where('numero', '2.2.1.1')->first();

                        Journal::create([
                            'date' => date('d/m/Y'),
                            'numero_piece' => $rand,
                            'fonction' => 'Retrait',
                            'reference' => $code,
                            'description' => 'Retrait cash',
                            'compte' => '2.2.1.1',
                            'intitule' => $compteComptableRetrait->libelle,
                            'debit' => $amount,
                            'account_id' => $request->num_account,
                            'user_id' => Auth::user()->id,
                            'agence_id' => Auth::user()->agence_id,
                        ]);

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
                            'billet' => $request->$monnaie,
                            'nombre' => $nombre,
                            'operation' => $operation->id,
                        ];

                        Billetage_operation::create($values);

                    }

                    $request->session()->flash('msg_info', 'Important: Vous avez lancé un retrait qui depasse le seuil d\'une operation, donc le service des operations analysera pour validation !');
                    return back()->with('title', $title);

                    }

                }else{

                        //Cumul du solde
                        /** Mise a jour du compte client **/
                        $account = Account::Where('number_account', $request->num_account)->first();
                        
                        if ( intval($account->solde) < $amount ) {
                            $request->session()->flash('msg_error', 'Le montant que vous voulez retirer est superieur au solde du client, Veuillez réajuster !');
                            return back();
                        }
                        

                        $frais = Type_frais::where('id', $request->frais)->first();

                        if ($frais) {
                            $frais = $frais->montant;
                        }else{
                            $frais = 0;
                        }

                        if ( intval($amount) != intval($request->result_verif) ) {
                        
                            $request->session()->flash('msg_error', 'Les deux montant ne correspondent pas, Veuillez refaire le retrait !');
                            return back();

                        }else{

                        

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
                            'date_op' => date('d/m/Y'),
                            'heure_op' => date('H:i:s'),
                            'user_id' => Auth::user()->id,
                        ]);

                        Operation_mouvement::create([
                            'operation_id' => $operation->id,
                            'mouvement_id' => $mvmt->id
                        ]);

                        $compteComptableGuichier = Compte_comptable::where('numero', Auth::user()->compte_comptable_id)->first();

                        Journal::create([
                            'date' => date('d/m/Y'),
                            'numero_piece' => $rand,
                            'compte' => Auth::user()->compte_comptable_id,
                            'intitule' => $compteComptableGuichier->libelle,
                            'credit' => $amount,
                            'account_id' => $request->num_account,
                            'user_id' => Auth::user()->id,
                            'agence_id' => Auth::user()->agence_id,
                        ]);

                        //$guich_num_compte = User::Where('id', $request->guichetier)->first();

                        $compteComptableRetrait = Compte_comptable::where('numero', '2.2.1.1')->first();

                        Journal::create([
                            'date' => date('d/m/Y'),
                            'numero_piece' => $rand,
                            'fonction' => 'Retrait',
                            'reference' => $code,
                            'description' => 'Retrait cash',
                            'compte' => '2.2.1.1',
                            'intitule' => $compteComptableRetrait->libelle,
                            'debit' => $amount,
                            'account_id' => $request->num_account,
                            'user_id' => Auth::user()->id,
                            'agence_id' => Auth::user()->agence_id,
                        ]);

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
                                'billet' => $request->$monnaie,
                                'nombre' => $nombre,
                                'operation' => $operation->id,
                            ];

                            Billetage_operation::create($values);

                        }

                        Account::Where('number_account', $request->num_account)
                        ->update([
                            'solde' => intval($account->solde) - intval($amount+$frais),
                        ]);
                        /** Fin Mise a jour du compte client **/

                        /** Mise a jour de la caisse du guichetier **/
                        

                        Mouvement::Where('id', $mvmt->id)
                        ->update([
                            'solde_final' => intval($mvmt->solde_final) - $amount,
                        ]);
                        /** Fin Mise a jour de la caisse du guichetier **/


                        /**Mise a jour du solde principal**/
                        /*$agence = Agence::Where('id', Auth::user()->agence_id)
                        ->first();

                        Agence::Where('id', $agence->id)
                        ->update([
                            'solde_principal' => intval($agence->solde_principal) + intval($amount+$frais),
                        ]);*/

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

        $options = [
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isJavascriptEnabled' => true,
        ];

        $data = [
            
            //'logo' => 'assets/images/logo/hopeFund.png',
            'v' => Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
                ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->join('agences', 'agences.id', '=', 'users.agence_id')
                //->join('type_frais', 'type_frais.id', '=', 'operations.frais')
                ->select('operations.*', 'clients.nom', 'clients.prenom', 'agences.name as nom_agence', 'users.matricule', 'accounts.solde')
                ->Where('operations.user_id', Auth::user()->id)
                ->Where('operations.type_operation_id', 2)
                ->Where('operations.ref', strtoupper($ref))
                ->first()
        ];
        
        //dd($data);
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.retraits.print', $data, [], $options)->render();

        // Convertir la vue en PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'portrait'); 

        $dompdf->render();

        // Générer le fichier PDF
        $output = $dompdf->output();
        

        $rand = rand(900, 999999);
        // Enregistrer le fichier PDF
        $filename = $rand.''.date('dmY').'-recu_retrait.pdf';
        file_put_contents(public_path('assets/docs/recus/retraits/'.$filename), $output);
        
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

    public function getTypeCreditByNumDossier($numDossier)
    {
        $credit = DB::table('credits')
                ->join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
                ->where('credits.num_dossier', $numDossier)
                ->select('type_credits.id as typeCreditId', 'type_credits.name as typeName', 'credits.num_account as num_account')
                ->first();


        if ($credit) {
            $response = [
                'typeCreditId' => $credit->typeCreditId,
                'typeName' => $credit->typeName,
                'numAccount' => $credit->num_account, 
            ];
        } else {
            // Si aucun crédit n'est trouvé, renvoyer une réponse vide ou avec des valeurs par défaut
            $response = [
                'typeCreditId' => null,
                'typeName' => null,
                'numAccount' => null,
            ];
        }

        return response()->json($response);
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
                

                $flash = trim($request->num_account);

                if ( strlen($flash) >= 16 ) {
                    $compte = DB::table('accounts')->where('number_account', $flash)->first();
                }else{
                    $rechercheFormattee = str_pad($flash, 6, "0", STR_PAD_LEFT);
                    $compte = DB::table('accounts')
                        ->where('number_account', 'LIKE', "001-{$rechercheFormattee}%-%%")
                        ->first();

                }

                if ($compte) {
                    
                
                $info_accounts = DB::table('accounts')->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                ->Where('accounts.client_id', $compte->client_id)
                ->get();

                $verif = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.code_client')
                ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                ->Where('accounts.client_id', $compte->client_id)
                ->first();

                $credits = Credit::join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
                ->Where('credits.code_client', $compte->client_id)
                ->Where('credits.statut', 'valide')
                ->get();

                if (!$verif) {
                    $request->session()->flash('msg_error', 'Ce numero de compte n\'existe pas dans le systeme!');
                    return back();
                }

                $versements = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
                ->Where('accounts.client_id', $compte->client_id)
                ->Where('operations.type_operation_id', 3)
                ->Where('operations.date_op', date('d/m/Y'))
                ->get();

                /*$operations = Journal::join('fonctions', 'fonctions.code_fonction', '=', 'journals.fonction')
                ->where('journals.client_id', $compte->client_id)
                ->select('journals.*')
                ->groupBy('journals.reference')
                ->get();*/
               
                /*$operations = Journal::where('client_id', $compte->client_id)
                ->select('reference')
                ->groupBy('reference')
                ->get();*/

                // Première étape : Obtenir les IDs représentatifs pour chaque référence
                $uniqueIds = Journal::selectRaw('MIN(id) as id')
                                ->where('client_id', $compte->client_id)
                                ->groupBy('reference')
                                ->pluck('id');

                // Deuxième étape : Utiliser les IDs obtenus pour récupérer les entrées complètes
                $operations = Journal::whereIn('journals.id', $uniqueIds)
                                ->join('fonctions', 'fonctions.code_fonction', '=', 'journals.fonction')
                                ->OrderBy('journals.date', 'DESC')
                                ->get();



                //dd($operations);

                //dd($versements);
                $som_versement = 0;
                foreach ($versements as $key => $value) {
                    $som_versement = $som_versement + $value->montant;
                }
                
                $retraits = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
                ->Where('accounts.client_id', $compte->client_id)                
                ->Where('operations.type_operation_id', 2)
                ->Where('operations.date_op', date('d/m/Y'))
                ->get();

                $som_retrait = 0;
                $som_frais = 0;
                foreach ($retraits as $key => $value) {
                    $som_retrait = $som_retrait + $value->montant;
                    $som_frais = $som_frais + $value->frais;
                }


                $chequiers = Chequier::Join('accounts', 'accounts.number_account', '=', 'chequiers.account_id')
                ->Where('accounts.client_id', $compte->client_id)
                ->Where('chequiers.date_order', date('d/m/Y'))
                ->get();

                $montant_total_commande = 0;
                foreach ($chequiers as $key => $value) {
                    $montant_total_commande = $montant_total_commande + $value->montant_total;
                }

                $detail_transaction = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->Where('accounts.client_id', $compte->client_id)
                ->select('operations.*', 'users.matricule')
                ->OrderBy('operations.date_op', 'DESC')
                ->get();
            }else{

                $request->session()->flash('msg_error', 'Ce numéro de compte que vous avez entré n\'existe pas!');
                return back();
            }

            }

            if (isset($request->email) || !empty($request->email)) {
                
                $verif = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.code_client')
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

                $uniqueIds = Journal::selectRaw('MIN(id) as id')
                                ->where('client_id', $compte->client_id)
                                ->groupBy('reference')
                                ->pluck('id');

                // Deuxième étape : Utiliser les IDs obtenus pour récupérer les entrées complètes
                $operations = Journal::whereIn('journals.id', $uniqueIds)
                                ->join('fonctions', 'fonctions.code_fonction', '=', 'journals.fonction')
                                ->OrderBy('journals.date', 'DESC')
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
                ->select('operations.*', 'users.matricule')
                ->OrderBy('operations.date_op', 'DESC')
                ->get();

            }

            
            if (isset($request->phone) || !empty($request->phone)) {
                
                $verif = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.code_client')
                ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                ->Where('clients.telephone', trim($request->phone))
                ->orWhere('clients.telephone2', trim($request->phone))
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

                //dd($verif->number_account);
                $uniqueIds = Journal::selectRaw('MIN(id) as id')
                                ->where('client_id', $compte->client_id)
                                ->groupBy('reference')
                                ->pluck('id');

                // Deuxième étape : Utiliser les IDs obtenus pour récupérer les entrées complètes
                $operations = Journal::whereIn('journals.id', $uniqueIds)
                                ->join('fonctions', 'fonctions.code_fonction', '=', 'journals.fonction')
                                ->OrderBy('journals.date', 'DESC')
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

                $chequiers = Chequier::Where('account_id', $verif->number_account)
                ->Where('date_order', date('d/m/Y'))
                ->get();

                $montant_total_commande = 0;
                foreach ($chequiers as $key => $value) {
                    $montant_total_commande = $montant_total_commande + $value->montant_total;
                }

                $detail_transaction = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->select('operations.*', 'users.matricule')
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
            ->with('credits', $credits)
            ->with('operations', $operations)
            ->with('info_accounts', $info_accounts)
            ->with('verif', $verif);
        }
        
    }

    public function DossierDetail($dossier)
    {
        
        $title = 'Détails du dossier '.$dossier;

        $credit = Credit::Where('num_dossier', $dossier)
        ->join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
        ->first();

        $echeances = DB::table('echeanciers')->where('dossier', $dossier)->get();

        $amount = intval(str_replace(' ', '', $credit->montant_octroye));
        $duree = $credit->duree;
        $date = $credit->date;

        $taux_interet = $credit->taux;
        $date = $credit->date;
        
        /**Calcul des capitaux mensuels a remboursé**/
        $capital = $amount / $duree;


        $montant_total_rembourse = intval(round($capital)) * $duree;
        $montant_dernier = intval(round($capital)) - ( $montant_total_rembourse - $amount );
        

        /**Fin Calcul des capitaux**/

        /*Calcul du taux d'interet*/


        /**Calcul des interets**/
        $interet_total = $amount * ($taux_interet / 100) * ($duree / 12);


        $interet_mensuel = $interet_total / $duree;



        $montant_total_rembourse = intval(round($capital)) * $duree;
        $montant_dernier = intval(round($capital)) - ( $montant_total_rembourse - $amount );

        /**Fin Calcul des interets**/
        
        $interet_cumuler = 0;
        
        for ($i=1; $i <= $duree; $i++) { 
            $interet_cumuler = $interet_mensuel + $interet_cumuler;
        }
        $interet_solde_total = $interet_cumuler;

        return view('pages.accounts.detail_dossier')
        ->with('duree', $duree)
        ->with('amount', $amount)
        ->with('echeances', $echeances)
        ->with('taux_interet', $taux_interet)
        ->with('date', $date)
        ->with('interet_solde_total', $interet_solde_total)
        ->with('title', $title)
        ->with('interet_mensuel', $interet_mensuel)
        ->with('date', $date)
        ->with('capital', $capital)
        ->with('dossier', $dossier)
        //->with('type_credit', $type_credit)
        ->with('montant_dernier', $montant_dernier);
    }

    public function accountsOperation($number_account)
    {
        if (! Gate::allows('is-caissier') && ! Gate::allows('is-service-operation') && ! Gate::allows('is-analyste-credit') && ! Gate::allows('is-chef-service-credit') ) {
            return view('errors.403');
        }

        // code...
        $title = "Opérations du compte ".$number_account;

                $info_accounts = DB::table('accounts')->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                ->Where('accounts.number_account', $number_account)
                ->get();

                $verif = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.code_client')
                ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                ->Where('accounts.number_account', $number_account)
                ->first();

                //dd($verif);
                $versements = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', $number_account)
                ->Where('operations.type_operation_id', 3)
                ->Where('operations.date_op', date('d/m/Y'))
                ->get();


                $som_versement = 0;
                foreach ($versements as $key => $value) {
                    $som_versement = $som_versement + $value->montant;
                }
                
                $retraits = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->Where('operations.account_id', $number_account)
                ->Where('operations.type_operation_id', 2)
                ->Where('operations.date_op', date('d/m/Y'))
                ->get();

                $som_retrait = 0;
                $som_frais = 0;
                foreach ($retraits as $key => $value) {
                    $som_retrait = $som_retrait + $value->montant;
                    $som_frais = $som_frais + $value->frais;
                }


                $chequiers = Chequier::Where('account_id', $number_account)
                ->Where('date_order', date('d/m/Y'))
                ->get();

                $montant_total_commande = 0;
                foreach ($chequiers as $key => $value) {
                    $montant_total_commande = $montant_total_commande + $value->montant_total;
                }

                $detail_transaction = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->Where('operations.account_id', $number_account)
                ->select('operations.*', 'users.matricule')
                ->OrderBy('operations.date_op', 'DESC')
                ->get();

                
        
                return view('pages.accounts.operations')
                ->with('detail_transaction', $detail_transaction)
                ->with('verif', $verif)
                ->with('chequiers', $chequiers)
                ->with('retraits', $retraits)
                ->with('versements', $versements)
                ->with('number_account', $number_account)
                ->with('info_accounts', $info_accounts)
                ->with('title', $title);
          

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

        $solde_principal = Compte_comptable::Where('numero', Auth::user()->compte_comptable_id)->first();

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

        /*$guichetiers = Compte_comptable::where('libelle', 'LIKE', 'Caisse%')
                                   ->orWhere('libelle', 'LIKE', 'CAISSE%')
                                   ->get();*/

        $mvts = Mouvement::join('users', 'users.id', '=', 'mouvements.guichetier')
        ->Where('mouvements.date_mvmt', date('d/m/Y'))
        ->Where('users.agence_id', Auth::user()->agence_id)
        ->WhereIn('mouvements.verify', ['ferme','yes','no', 'cancel'])
        ->select('mouvements.*', 'users.nom', 'users.prenom')
        ->OrderBy('mouvements.id', 'DESC')
        ->get();

        return view('pages.caisses.index')
        //->with('caisses', $caisses)
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

        /*if( !isset( $request->caisse ) || empty($request->caisse) ) {
            $request->session()->flash('msg_error', 'Vous devez selectionner une caisse');
        }else*/if( !isset( $request->montant ) || empty($request->montant) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le montant initial');
        }else{


        /*$_Single_caisse = Mouvement::join('users', 'users.id', '=', 'mouvements.guichetier')
        ->Where('mouvements.caisse_id', $request->caisse)
        ->Where('mouvements.date_mvmt', date('d/m/Y'))
        ->first();*/

        $_single_guichetier = Mouvement::join('users', 'users.id', '=', 'mouvements.guichetier')
        ->Where('mouvements.guichetier', $request->guichetier)
        ->Where('mouvements.date_mvmt', date('d/m/Y'))
        ->first();


        /*if ($_Single_caisse) {

           $guichetier = $_Single_caisse->nom.' '.$_Single_caisse->prenom;
           $request->session()->flash('msg_error', 'Cette caisse a déjà été attribuée au guichetier '.$guichetier);

        }else*/if($_single_guichetier){

            $guichetier = $_single_guichetier->nom.' '.$_single_guichetier->prenom;
           $request->session()->flash('msg_error', 'Une caisse a déjà été attribuée au guichetier '.$guichetier);

        }else{

            $solde_principal = Compte_comptable::Where('numero', Auth::user()->compte_comptable_id)->first();

            $caisses = Mouvement::join('users', 'users.id', '=', 'mouvements.guichetier')
            ->join('agences', 'agences.id', '=', 'users.agence_id')
            ->select('mouvements.*','users.nom', 'users.prenom')
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

                if ( intval($solde_principal->debiteur) < $amount ) {

                    $request->session()->flash('msg_error', 'Le montant attribué à l\'ensemble des caisses est superieur au solde principal disponible. Veuillez réajuster la repartition !');

                }else{

                    $piece = mt_rand(111111,88888888);
                    $refExist = Journal::Where('numero_piece', $piece)->first();

                    while ($refExist) {
                        $piece = mt_rand(111111,88888888);
                        $refExist = Mouvement::Where('numero_piece', $piece)->first();
                    }

                    $ref = 'REF-MVNT-'.$piece.'-'.date('Ymd');

                    Mouvement::create([
                        'solde_initial' => $amount,
                        'solde_final' => $amount,
                        'reference_mvt' => $ref,
                        'date_mvmt' => date('d/m/Y'),
                        'heure_mvmt' => date('H:i:s'),
                        'compte_comptable_id' => Auth::user()->compte_comptable_id,
                        'guichetier' => $request->guichetier,
                        'user_id' => Auth::user()->id,
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

        $solde_principal = Compte_comptable::Where('numero', $caisse->compte_comptable_id)->first();

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

            Compte_comptable::Where('numero', $caisse->compte_comptable_id)
            ->update([
            'debiteur' => intval($solde_principal->debiteur) - intval($caisse->solde_initial),
             ]);

            $piece = mt_rand(111111,88888888);
            $refExist = Journal::Where('numero_piece', $piece)->first();

            while ($refExist) {
                $piece = mt_rand(111111,88888888);
                $refExist = Mouvement::Where('numero_piece', $piece)->first();
            }

            $ref = 'REF-MVNT-'.$piece.'-'.date('Ymd');

            $compteComptablePrincipal = Compte_comptable::where('numero', $caisse->compte_comptable_id)->first();


            Journal::create([
                'date' => date('d/m/Y'),
                'numero_piece' => $piece,
                'compte' => Auth::user()->compte_comptable_id,
                'intitule' => $compteComptablePrincipal->libelle,
                'credit' => $caisse->solde_initial,
            ]);

            $guich_num_compte = User::Where('id', $caisse->guichetier)->first();

            $compteComptableGuichier = Compte_comptable::where('numero', $guich_num_compte->compte_comptable_id)->first();

            Journal::create([
                'date' => date('d/m/Y'),
                'numero_piece' => $piece,
                'fonction' => 'Rechargement de caisse',
                'reference' => $ref,
                'description' => 'Rechargement de caisse',
                'compte' => $compteComptableGuichier->numero,
                'intitule' => $compteComptableGuichier->libelle,
                'debit' => $caisse->solde_initial,
            ]);

            $request->session()->flash('msg_success', 'Bravo!!!');
            return back();

        }else{

            $request->session()->flash('msg_error', 'Votre montant ne correspond pas au montant qui vous a été attribué. Merci de verifier avec le caissier principal !');
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
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

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
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }
        $title = "Faire un virement";

        return view('pages.virement.new')
        ->with('title', $title);

    }

    public function VirementPrint($ref)
    {
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

        $title = "Imprimer recu";

        //dd($ref);

        $data = [
            
            'logo' => 'assets/images/logo/hopeFund.png',
            'v' => Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
                ->join('clients', 'clients.id', '=', 'accounts.client_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->join('agences', 'agences.id', '=', 'users.agence_id')
                ->join('type_frais', 'type_frais.id', '=', 'operations.frais')
                ->select('operations.*', 'clients.nom', 'clients.prenom', 'agences.name as nom_agence', 'users.matricule', 'type_frais.name as nom_frais', 'type_frais.montant as frais_montant')
                ->Where('operations.user_id', Auth::user()->id)
                ->Where('operations.type_operation_id', 1)
                ->Where('operations.ref', strtoupper($ref))
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
        $filename = rand(9000, 999999).''.date('dmY').'-recu_virement.pdf';
        file_put_contents(public_path('assets/docs/recus/virements/'.$filename), $output);
        
        //$dompdf->stream();

        // Retourner une réponse avec le nom de fichier pour le téléchargement
       // return response()->loadView($filename);
        return $dompdf->stream($filename, ['Attachment' => false]);
        //return view('pages.caisses.print_close_caisse');

    }

    public function VirementNew2(Request $request)
    {

        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

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
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

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


            $num_account_destinataire = trim($request->num_account);
            $num_account_expeditaire = trim($request->num_account_exp);
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
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

        $title ='Faire un Virement';

        $init = "REF-VIR-";
        $rand = rand(111111, 999999);
        $date = date("Ymd");

        $code = $init.$rand.$date;

        $montant_limit = 2000000;
        $montant_limit_start = 500001;

        $account = Account::Where('number_account', $request->num_account)
            ->first();

        $frais = Type_frais::where('id', 2)->first();


        $operation = Operation::create([
            'ref' => $code,
            'montant' => $request->amount,
            'type_operation_id' => 1,
            'account_id' => $request->num_account,
            'account_dest' => $request->num_account_dest,
            'motif_virement' => $request->motif_virement,
            'type_carte' => $request->type_carte,
            'frais' => $frais->id,
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
            'solde' => intval($solde_exp->solde) - intval($request->amount+$frais->montant) 
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
            'solde_principal' => intval($agence->solde_principal) + intval($frais->montant),
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
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

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
        
       if (! Gate::allows('is-direction') ) {
            return view('errors.403');
        }

       $title = 'Liste des demandes en attente d\'avis';


       $demande_attentes = Credit::Join('accounts', 'accounts.number_account', '=', 'credits.num_account')
       ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'credits.num_dossier')
       ->Join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.code_client')
       ->Select('credits.*', 'clients.nom', 'clients.prenom', 'type_credits.name')
       ->OrderBy('credits.date_demande', 'DESC')
       ->Where('credits.dossier_complete', 'oui')
       ->get();


       //dd($demande_attentes);

        return view('pages.credits.liste_demande_attente_avis')
        ->with('title', $title)
        ->with('demande_attentes', $demande_attentes);
    }

    public function DossierTraite()
    {
        $title = 'Dossier Traités';

        $demandes = Credit::Join('accounts', 'accounts.number_account', '=', 'credits.num_account')
       ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'credits.num_dossier')
       ->Join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.code_client')
       ->Select('credits.*', 'clients.nom', 'clients.prenom', 'type_credits.name')
       ->OrderBy('credits.date_demande', 'DESC')
       ->Where('analyste_demandes.analyste', Auth::user()->id)
       ->Where('credits.dossier_complete', 'oui')
       ->get();

        return view('pages.credits.liste_traite_dossier')
        ->with('title', $title)
        ->with('demandes', $demandes);

    }


    public function Avis_consulting($id)
    {
        
        if (! Gate::allows('is-direction') && ! Gate::allows('is-chef-service-credit') && ! Gate::allows('is-analyste-credit') ) {
            return view('errors.403');
        }

        $title = 'Avis sur le dossier numéro: '.$id;        

        if ( isset($id) ) {

           $credit = Credit::Where('num_dossier', $id)
            ->join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
            ->first();

            if ($credit) {
                
                $user = User::where('id', Auth::user()->id)->first();

                $avis = Credit::Join('avis', 'avis.dossier', '=', 'credits.num_dossier')
                ->join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
                ->join('users', 'users.id', '=', 'avis.user_id')
                ->where('credits.num_dossier', $id)
                ->where('avis.user_id', Auth::user()->id)
                ->first();


                return view('pages.credits.avis_consulting')
                ->with('id', $id)
                ->with('user', $user)
                ->with('avis', $avis)
                ->with('credit', $credit)
                ->with('title', $title);

            }else{
                return redirect()->route('liste-demandes-assign');
            }
            //dd($credit);
        }
        

        

        
    }
    public function SendAvis(Request $request)
    {
        
        Avis::create([

            "dossier" => $request->dossier,
            "avis" => $request->proposition_agent_credit,
            "montant_propose" => trim($request->montant_propose_agent_credit),
            "type_credit_avis" => trim($request->type_credit_agent_credit),
            "taux" => trim($request->taux),
            "nantissement_avis" => trim($request->nantissement_agent_credit),
            "garantie_avis" => trim($request->garantie_agent_credit),
            "assurance_avis" => trim($request->assurance_agent_credit),
            "versement_initial_avis" => trim($request->versement_initial_agent_credit),
            "duree_avis" => trim($request->duree_agent_credit),
            "periode_de_grace_avis" => trim($request->periode_de_grace_agent_credit),
            "commentaire_avis" => trim($request->commentaire_agent_credit),
            "date_avis" => date('d/m/Y'),
            "user_id" => Auth::user()->id,

        ]);

        $request->session()->flash('msg_success', 'Votre avis a été soumis avec succès !');
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

        $sexes = Sexes::OrderBy('name', 'ASC')->get();

        return view('pages.users.index')
        ->with('roles', $roles)
        ->with('sexes', $sexes)
        ->with('users', $users)
        ->with('agences', $agences)
        ->with('title', $title);
    }

    public function NewUser()
    {
        if (! Gate::allows('is-admin')) {
            return view('errors.403');
        }

        $title = "Nouvel utilisateur";
        $users = User::join('roles', 'roles.id', '=', 'users.role_id')
        ->join('agences', 'agences.id', '=', 'users.agence_id')
        ->select('users.*', 'agences.name as nom_agence', 'agences.id as id_agence', 'roles.name as role_name', 'roles.id as role_id')
        ->OrderBy('users.id', 'DESC')
        ->get();

        $agences = Agence::OrderBy('name', 'ASC')->get();

        $roles = Role::OrderBy('name', 'ASC')->get();

        $compteComptables = Compte_comptable::where('libelle', 'LIKE', 'Caisse%')
                                   ->orWhere('libelle', 'LIKE', 'CAISSE%')
                                   ->get();

        return view('pages.users.create')
        ->with('roles', $roles)
        ->with('users', $users)
        ->with('agences', $agences)
        ->with('compteComptables', $compteComptables)
        ->with('title', $title);
    }

        public function addUser(Request $request)
    {

        if (!isset($request->nom) || empty($request->nom)) {
                $request->session()->flash('msg_error', 'Vous devez saisir le nom');
            } elseif (!isset($request->prenom) || empty($request->prenom)) {
                $request->session()->flash('msg_error', 'Vous devez saisir le prénom');
            } elseif (!isset($request->date_naissannce) || empty($request->date_naissannce)) {
                $request->session()->flash('msg_error', 'Vous devez sélectionner une date de naissance');
            } elseif (!isset($request->lieu_naissance) || empty($request->lieu_naissance)) {
                $request->session()->flash('msg_error', 'Vous devez saisir le lieu de naissance');
            } elseif (!isset($request->sexe) || empty($request->sexe)) {
                $request->session()->flash('msg_error', 'Vous devez sélectionner le sexe');
            } elseif (!isset($request->type_piece) || empty($request->type_piece)) {
                $request->session()->flash('msg_error', 'Vous devez saisir le type de pièce');
            } elseif (!isset($request->numero_piece) || empty($request->numero_piece)) {
                $request->session()->flash('msg_error', 'Vous devez saisir le numéro de pièce d\'identité');
            } elseif (!isset($request->adresse) || empty($request->adresse)) {
                $request->session()->flash('msg_error', 'Vous devez saisir l\'adresse');
            } elseif (!isset($request->email) || empty($request->email)) {
                $request->session()->flash('msg_error', 'Vous devez saisir un email valide');
            } elseif (!isset($request->statut) || empty($request->statut)) {
                $request->session()->flash('msg_error', 'Vous devez sélectionner le statut');
            } elseif (!isset($request->role) || empty($request->role)) {
                $request->session()->flash('msg_error', 'Vous devez sélectionner le rôle');
            } elseif (!isset($request->gestionnaire) || empty($request->gestionnaire)) {
                $request->session()->flash('msg_error', 'Vous devez indiquer si l\'utilisateur est un gestionnaire');
            } else {


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
                        'date_naissance' => $request->date_naissannce,
                        'lieu_naissance' => $request->lieu_naissance,
                        'sexe' => $request->sexe,
                        'matricule' => $code,
                        'type_piece' => $request->type_piece,
                        'numero_piece' => $request->numero_piece,
                        'adresse' => $request->adresse,
                        'phone' => $request->telephone,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'date_creation' => $request->date_creation,
                        'user_create' => $request->user_create,
                        'statut' => $request->statut,
                        'superviseur' => $request->superviseur ? 1 : 0,
                        'agence_id' => $request->agence,
                        'role_id' => $request->role,
                        'gestionnaire' => $request->gestionnaire,
                    ]);

                }
             $request->session()->flash('msg_success', 'Vous avez crée cet utilisateur avec succès!');
            }
        }
        return back();
    }


    public function editbyUser($id)
    {
        if (! Gate::allows('is-admin')) {
            return view('errors.403');
        }

        $title = "Edit utilisateur";

        $user = User::where('id', $id)->first();
        $agences = Agence::OrderBy('name', 'ASC')->get();
        $roles = Role::OrderBy('name', 'ASC')->get();
        $compteComptables = Compte_comptable::where('libelle', 'LIKE', 'Caisse%')
                                   ->orWhere('libelle', 'LIKE', 'CAISSE%')
                                   ->get();

        return view('pages.users.edit')
        ->with('roles', $roles)
        ->with('user', $user)
        ->with('agences', $agences)
        ->with('compteComptables', $compteComptables)
        ->with('title', $title);
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
                'date_naissance' => $request->date_naissannce,
                'lieu_naissance' => $request->lieu_naissance,
                'sexe' => $request->sexe,
                'type_piece' => $request->type_piece,
                'numero_piece' => $request->numero_piece,
                'adresse' => $request->adresse,
                'phone' => $request->telephone,
                'email' => $request->email,
                'date_edit' => $request->date_edit,
                'user_edit' => $request->user_edit,
                'statut' => $request->statut,
                'superviseur' => $request->superviseur ? 1 : 0,
                'agence_id' => $request->agence,
                'role_id' => $request->role,
                'gestionnaire' => $request->gestionnaire,
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

    public function ProfilUser()
    {
        return view('pages.users.profil');
    }

    public function ProfilUserEdit(Request $request)
    {
        
        User::Where('id', Auth::user()->id)
        ->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'phone' => $request->telephone,
        ]);

        $request->session()->flash('msg_success', 'Vous avez modifié vos informations avec succès!');
        return back();

    }


    public function ChangePassword(Request $request)
    {


        if ( $request->password == $request->repassword ) {


            User::Where('id', Auth::user()->id)
            ->update([
                'password' => Hash::make($request->password)
            ]);  

            $request->session()->flash('msg_success', 'Vous avez modifié votre mot de passe avec succès!');

        }else{

            $request->session()->flash('msg_error', 'Les deux mot de passe ne correspondent pas, veuillez reprendre!');
        }

        
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

    public function indexCreate()
    {
        $title = "Ouverture de compte du ".date('d/m/Y');
        
        $etat_juridiques = DB::table('etat_juridiques')->get();
        
        return view('pages.accounts.indexCreate')
        ->with('etat_juridiques', $etat_juridiques)
        ->with('title', $title);
    }

    public function accountCreate($slug)
    {
        $title = "Ouverture de compte du ".date('d/m/Y');
        
        $type_accounts = Type_account::all();
        $etat_juridique = DB::table('etat_juridiques')->where('slug', $slug)->first();
        $sexes = DB::table('sexes')->get();
        
        return view('pages.accounts.create')
        ->with('sexes', $sexes)
        ->with('etat_juridique', $etat_juridique)
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


    /***OUVERTURE DE COMPTE ***/

        /**OUVERTURE DE COMPTE **/

        public function AccountOuverture($slug)
        {
            
            if ($slug == 'personne-morale') {
                
                $type_accounts = Type_account::whereIn('id', [18, 19])->OrderBy('name', 'ASC')->get();
                $etat_juridique = DB::table('etat_juridiques')->where('slug', $slug)->first();

                $sexes = DB::table('sexes')->OrderBy('id', 'ASC')->get();

                $codeLength = 6;

                do{

                    

                    $rander = mt_rand(10 ** ($codeLength - 1), 10 ** $codeLength - 1);
                    $clientExist = Client::Where('code_client', $rander)->first();

                    if ( !$clientExist ) {
                        break;
                    }

                    $codeLength++;

                    if ( $codeLength > 9 ) {
                        break;
                    }

                }while (true);

                $number_account = '001-'.$rander.'-00-'.rand(01, 99);

                //dd($rander);

                return view('pages.accounts.personne_moral')
                    ->with('number_account', $number_account)
                    ->with('rander', $rander)
                    ->with('etat_juridique', $etat_juridique)
                    ->with('type_accounts', $type_accounts);

            }elseif ($slug == 'personne-physique') {
                $start_number = "1284";
                $end_number = "001";
                $rand = rand(1111111, 9999999);

                while( strlen($rand) < 7 ){
                    $rand = rand(1111111, 9999999);
                }

                $number_account = $start_number.$rand.$end_number;

                //dd($number_account);


                $type_accounts = Type_account::whereIn('id', [18,19])->OrderBy('name', 'ASC')->get();

                //dd($type_accounts);

                $sexes = DB::table('sexes')->OrderBy('id', 'ASC')->get();

                $codeLength = 6;

                do{

                    $rander = mt_rand(10 ** ($codeLength - 1), 10 ** $codeLength - 1);
                    $clientExist = Client::Where('code_client', $rander)->first();

                    if ( !$clientExist ) {
                        break;
                    }

                    $codeLength++;

                    if ( $codeLength > 9 ) {
                        break;
                    }

                }while (true);


                $number_account = '001-'.$rander.'-00-'.rand(01, 99);

                //dd($number_account);

                $etat_juridique = DB::table('etat_juridiques')->where('slug', $slug)->first();
                $sexes = DB::table('sexes')->get();
                return view('pages.accounts.personne_physique')
                    ->with('type_accounts', $type_accounts)
                    ->with('rander', $rander)
                    ->with('number_account', $number_account)
                    ->with('etat_juridique', $etat_juridique)
                    ->with('sexes', $sexes);

            }elseif ($slug == 'groupe-informel') {
                $start_number = "1284";
                $end_number = "001";
                $rand = rand(1111111, 9999999);

                while( strlen($rand) < 7 ){
                    $rand = rand(1111111, 9999999);
                }

                $number_account = $start_number.$rand.$end_number;

                //dd($number_account);
                $type_accounts = Type_account::whereIn('id', [18,19])->OrderBy('name', 'ASC')->get();
                $etat_juridique = DB::table('etat_juridiques')->where('slug', $slug)->first();

                $sexes = DB::table('sexes')->OrderBy('id', 'ASC')->get();

                $codeLength = 6;

                do{

                    $rander = mt_rand(10 ** ($codeLength - 1), 10 ** $codeLength - 1);
                    $clientExist = Client::Where('code_client', $rander)->first();

                    if ( !$clientExist ) {
                        break;
                    }

                    $codeLength++;

                    if ( $codeLength > 9 ) {
                        break;
                    }

                }while (true);
                $number_account = '001-'.$rander.'-00-'.rand(01, 99);
                $type_compte = Type_account::all();
                return view('pages.accounts.groupe_formelle')
                    ->with('type_accounts', $type_accounts)
                    ->with('etat_juridique', $etat_juridique)
                    ->with('rander', $rander)
                    ->with('number_account', $number_account);
            }elseif ($slug == 'groupe-solidaire') {
                $start_number = "1284";
                $end_number = "001";
                $rand = rand(1111111, 9999999);

                while( strlen($rand) < 7 ){
                    $rand = rand(1111111, 9999999);
                }

                $number_account = $start_number.$rand.$end_number;

                //dd($number_account);
                $type_accounts = Type_account::whereIn('id', [18,19])->OrderBy('name', 'ASC')->get();
                $etat_juridique = DB::table('etat_juridiques')->where('slug', $slug)->first();

                $sexes = DB::table('sexes')->OrderBy('id', 'ASC')->get();

                $codeLength = 6;

                do{

                    $rander = mt_rand(10 ** ($codeLength - 1), 10 ** $codeLength - 1);
                    $clientExist = Client::Where('code_client', $rander)->first();

                    if ( !$clientExist ) {
                        break;
                    }

                    $codeLength++;

                    if ( $codeLength > 9 ) {
                        break;
                    }

                }while (true);

                $type_compte = Type_account::all();
                $number_account = '001-'.$rander.'-00-'.rand(01, 99);

                return view('pages.accounts.groupe_solidaire')
                    ->with('number_account', $number_account)
                    ->with('type_accounts', $type_accounts)
                    ->with('etat_juridique', $etat_juridique)
                    ->with('rander', $rander);
            }else{
                $title = "Ouverture de compte du ".date('d/m/Y');
        
                $etat_juridiques = DB::table('etat_juridiques')->get();
                
                return view('pages.accounts.indexCreate')
                ->with('etat_juridiques', $etat_juridiques)
                ->with('title', $title);
            }

        }
      

        public function ComptePersonneMoralValid(Request $request)
        {

            $juridique = $request->id_personne_moral;

            $clientMoral = new Clients();
            $clientMoralAccount = new Account();

            //dd($request->captured_signature_data, $request->captured_image_data);

            // Sauvegarder la signature capturée
                if ($request->filled('captured_signature_data')) {

                    $base64Signature = $request->captured_signature_data;

                    // Convertir la base64 en fichier image
                    $signatureData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Signature));

                    // Générer un nom de fichier unique
                    $signatureName = 'signature_' . time() . '.png';

                    // Enregistrer la signature sur le serveur
                    $signatureDirectory = public_path('assets/images/signature/');

                    if (!file_exists($signatureDirectory)) {

                        mkdir($signatureDirectory, 0755, true);
                    }

                    $signaturePath = $signatureDirectory . $signatureName;
                    file_put_contents($signaturePath, $signatureData);

                    //Page 3
                    $clientMoral->signature = $signatureName;

                }

                // Sauvegarder l'image capturée
                if ($request->filled('captured_image_data')) {

                    $base64Image = $request->captured_image_data;

                    // Convertir la base64 en fichier image
                    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

                    // Générer un nom de fichier unique
                    $imageName = 'captured_image_' . time() . '.png';

                    // Enregistrer l'image sur le serveur
                    $imageDirectory = public_path('assets/images/photo-profil/');

                    if (!file_exists($imageDirectory)) {

                        mkdir($imageDirectory, 0755, true);
                    }

                    $imagePath = $imageDirectory . $imageName;
                    file_put_contents($imagePath, $imageData);

                    //Page 3
                    $clientMoral->photo = $imageName;

                } 

                if ($request->hasFile('logo')) {
                    $ext = $request->logo->getClientOriginalExtension();
                    $name = time().'.'.$ext;
                    $request->logo->move(public_path().'/assets/images/logo/', $name);
                } else {
                    $name = null;
                }

                // Page 1
                $clientMoral->code_client = $request->numero_client;
                $clientMoral->ancien_numero_client = $request->ancien_numeroclient;
                $clientMoral->logo = $name;
                $clientMoral->lang = $request->langue_correspondance;
                //$clientMoral->signature = $request->signature;
                $clientMoral->raison_social = $request->raison_social;
                $clientMoral->abreviation = $request->abreviation;
                $clientMoral->adresse = $request->adresse;
                $clientMoral->code_postal = $request->code_postal;
                $clientMoral->ville = $request->ville;
                $clientMoral->pays = $request->pays;
                $clientMoral->telephone = $request->numero_telephone;

                // Page 2
                $clientMoral->email = $request->email;
                $clientMoral->localisation_1 = $request->localisation_1;
                $clientMoral->localisation_2 = $request->localisation_2;
                $clientMoral->localisation_3 = $request->localisation_3;
                $clientMoral->zone = $request->zone;
                $clientMoral->commetaire_client = $request->commetaire_client;
                $clientMoral->categorie_pm = $request->categorie_pm;
                $clientMoral->qualite = $request->qualite;
                $clientMoral->niveau_agence = $request->niveau_agence;
                $clientMoral->niveau_guichet = $request->niveau_guichet;
                $clientMoral->numero_carte_bancaire = $request->numero_carte_bancaire;
                $clientMoral->versement_initial = $request->versement_initial;
                $clientMoral->montant_epargne = $request->montant_epargne;
                $clientMoral->total_verse = $request->total_verse;
                $clientMoral->date_cloture_compte = $request->date_cloture_compte;
                $clientMoral->versement_final = $request->versement_final;


                // Définir le mot de passe par défaut
                $defaultPassword = bcrypt('Hbanking2023!');
                $clientMoral->password = $defaultPassword;

                //dd($clientMoral->captured_image_path);

                $clientMoral->agence_id = '1';
                $clientMoral->juridique = $juridique;

                //
                $clientMoral->save();

                //l'ID du client ajouter
                $clientId = $request->numero_client;

                // Générer un code PIN unique de 4 chiffres
                do {
                    $pinCode = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
                } while (Account::where('pin_code', $pinCode)->exists());


                $clientMoralAccount->number_account = $request->number_account;
                $clientMoralAccount->type_account_id = $request->type_compte;
                $clientMoralAccount->date_ouverture_compte = $request->date_ouverture_compte;
                $clientMoralAccount->client_id = $clientId;
                $clientMoralAccount->user_id = Auth::user()->id;
                $clientMoralAccount->solde_init = $request->versement_initial;
                //$clientMoralAccount->statut = "open";
                $clientMoralAccount->solde = $request->versement_initial + $request->montant_epargne;
                $clientMoralAccount->pouvoir_signataires = $request->pouvoir_signataires;
                $clientMoralAccount->date_cloture_compte = $request->date_cloture_compte;
                $clientMoralAccount->pin_code = $pinCode;
                $clientMoralAccount->monthly_maintenance_fee = $request->monthly_maintenance_fee;
                $clientMoralAccount->last_monthly_maintenance_date = $request->last_monthly_maintenance_date;
                
                $clientMoralAccount->save();
                //$request->session()->flash('code', $clientId);
                return redirect()->route('success_inscription', $clientId);
        }

        
        public function ComptePersonnePhysiqueValid(Request $request)
        {   

            $juridique = $request->id_personne_physique;

            $client = new Clients();
            $clientPhysiqueAccount = new Account();

            //dd($request->captured_signature_data, $request->captured_image_data);

            // Sauvegarder la signature capturée
            if ($request->filled('captured_signature_data')) {

                $base64Signature = $request->captured_signature_data;

                // Convertir la base64 en fichier image
                $signatureData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Signature));

                // Générer un nom de fichier unique
                $signatureName = 'signature_' . time() . '.png';

                // Enregistrer la signature sur le serveur
                $signatureDirectory = public_path('assets/images/signature/');

                if (!file_exists($signatureDirectory)) {

                    mkdir($signatureDirectory, 0755, true);
                }

                $signaturePath = $signatureDirectory . $signatureName;
                file_put_contents($signaturePath, $signatureData);

                //Page 3
                $client->signature = $signatureName;

            }

                // Sauvegarder l'image capturée
            if ($request->filled('captured_image_data')) {

                $base64Image = $request->captured_image_data;

                // Convertir la base64 en fichier image
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

                // Générer un nom de fichier unique
                $imageName = 'captured_image_' . time() . '.png';

                // Enregistrer l'image sur le serveur
                $imageDirectory = public_path('assets/images/photo-profil/');

                if (!file_exists($imageDirectory)) {

                    mkdir($imageDirectory, 0755, true);
                }

                $imagePath = $imageDirectory . $imageName;
                file_put_contents($imagePath, $imageData);

                //Page 3
                $client->photo = $imageName;

            }
            
            $client->code_client = $request->numero_client;
            $client->type_compte = $request->type_compte;
            //$client->date_ouverture_compte = $request->date_ouverture_compte;
            $client->lang = $request->lang;
            $client->matricule = $request->matricule;
            $client->nom = $request->nom;
            $client->prenom = $request->prenom;
            $client->date_naissance = $request->date_naissance;
            $client->lieu_naissance = $request->lieu_naissance;
            $client->pays_nationalite = $request->pays_nationalite;
            $client->pays_naissance = $request->pays_naissance;
            $client->sexe = $request->sexes;

            // page 2
            $client->type_piece = $request->type_piece;
            $client->numero_cni = $request->numero_cni;
            $client->etat_civil = $request->etat_civil;
            $client->nmbre_enfant = $request->nmbre_enfant;
            $client->adresse = $request->adresse;
            $client->ville = $request->ville;
            $client->code_postal = $request->code_postal;
            $client->pays = $request->pays;
            $client->telephone = $request->telephone;
            $client->email = $request->email;
            $client->employeur = $request->employeur;
            $client->fonction_employeur = $request->fonction_employeur;

            // Page 3
            $client->nom_conjoint = $request->nom_conjoint;
            $client->nom_prenom_signataire1 = $request->nom_prenom_signataire1;
            $client->cni_signataire1 = $request->cni_signataire1;
            $client->telephone_signataire1 = $request->telephone_signataire1;
            $client->nom_prenom_signataire2 = $request->nom_prenom_signataire2;
            $client->cni_signataire2 = $request->cni_signataire2;
            $client->telephone_signataire2 = $request->telephone_signataire2;
            $client->nom_prenom_signataire3 = $request->nom_prenom_signataire3;
            $client->cni_signataire3 = $request->cni_signataire3;
            $client->telephone_signataire3 = $request->telephone_signataire3;
            $client->pouvoir_signataires = $request->pouvoir_signataires;
            $client->nom_heritier1 = $request->nom_heritier1;
            $client->nom_heritier2 = $request->nom_heritier2;
            $client->nom_heritier3 = $request->nom_heritier3;

            // Page 4
            $client->nom_mandataire = $request->nom_mandataire;
            $client->cni_mandataire = $request->cni_mandataire;
            $client->telephone_mandataire = $request->telephone_mandataire;
            $client->qualite = $request->qualite;
            $client->niveau_agence = $request->niveau_agence;
            $client->niveau_guichet = $request->niveau_guichet;
            $client->versement_initial = $request->versement_initial;
            $client->montant_epargne = $request->montant_epargne;
            $client->total_verse = $request->total_verse;
            $client->date_cloture_compte = $request->date_cloture_compte;
            $client->versement_final = $request->versement_final;

            // Définir le mot de passe par défaut
            $defaultPassword = bcrypt('Hbanking2023!');
            $client->password = $defaultPassword;

            $client->agence_id = '1';
            $client->juridique = $juridique;

            $client->save();

            //l'ID du client ajouter
            $clientId = $request->numero_client;
            //dd($client);

            // Générer un code PIN unique de 4 chiffres
            do {
                $pinCode = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
            } while (Account::where('pin_code', $pinCode)->exists());


            //
            $clientPhysiqueAccount->number_account = $request->number_account;
            $clientPhysiqueAccount->date_ouverture_compte = $request->date_ouverture_compte;
            $clientPhysiqueAccount->type_account_id = $request->type_compte;
            $clientPhysiqueAccount->client_id = $clientId;
            $clientPhysiqueAccount->user_id = Auth::user()->id;
            $clientPhysiqueAccount->solde_init = $request->versement_initial;
            //$clientPhysiqueAccount->statut = $request->statut;
            $clientPhysiqueAccount->solde = $request->versement_initial + $request->montant_epargne;
            $clientPhysiqueAccount->pouvoir_signataires = $request->pouvoir_signataires;
            $clientPhysiqueAccount->date_cloture_compte = $request->date_cloture_compte;
            $clientPhysiqueAccount->pin_code = $pinCode;
            $clientPhysiqueAccount->monthly_maintenance_fee = $request->monthly_maintenance_fee;
            $clientPhysiqueAccount->last_monthly_maintenance_date = $request->last_monthly_maintenance_date;

            
            $clientPhysiqueAccount->save();
            //$request->session()->flash('code', $clientId);
            return redirect()->route('success_inscription', $clientId);
        
        }

        public function InsertionGroupeFormelle(Request $request)
        {

            $juridique = $request->id_groupe_formelle;

            $groupeFormelle = new Clients();
            $groupeFormelleAccount = new Account();

            //dd($request->captured_signature_data, $request->captured_image_data);

            // Sauvegarder la signature capturée
            if ($request->filled('captured_signature_data')) {

                $base64Signature = $request->captured_signature_data;

                // Convertir la base64 en fichier image
                $signatureData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Signature));

                // Générer un nom de fichier unique
                $signatureName = 'signature_' . time() . '.png';

                // Enregistrer la signature sur le serveur
                $signatureDirectory = public_path('assets/images/signature/');

                if (!file_exists($signatureDirectory)) {

                    mkdir($signatureDirectory, 0755, true);
                }

                $signaturePath = $signatureDirectory . $signatureName;
                file_put_contents($signaturePath, $signatureData);

                //Page 3
                $groupeFormelle->signature = $signatureName;

            }

                // Sauvegarder l'image capturée
            if ($request->filled('captured_image_data')) {

                $base64Image = $request->captured_image_data;

                // Convertir la base64 en fichier image
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

                // Générer un nom de fichier unique
                $imageName = 'captured_image_' . time() . '.png';

                // Enregistrer l'image sur le serveur
                $imageDirectory = public_path('assets/images/photo-profil/');

                if (!file_exists($imageDirectory)) {

                    mkdir($imageDirectory, 0755, true);
                }

                $imagePath = $imageDirectory . $imageName;
                file_put_contents($imagePath, $imageData);

                //Page 3
                $groupeFormelle->photo = $imageName;

            }

            if ($request->hasFile('logo')) {
                $ext = $request->logo->getClientOriginalExtension();
                $name = time().'.'.$ext;
                $request->logo->move(public_path().'/assets/images/logo/', $name);
            } else {
                $name = null;
            }

            $groupeFormelle->code_client = $request->numero_client;
            $groupeFormelle->logo = $name;
            $groupeFormelle->lang = $request->lang;
            $groupeFormelle->nom_groupe = $request->nom_groupe;
            $groupeFormelle->adresse = $request->adresse;
            $groupeFormelle->ville = $request->ville;
            $groupeFormelle->code_postal = $request->code_postal;
            $groupeFormelle->pays = $request->pays;
            $groupeFormelle->telephone = $request->telephone;
            $groupeFormelle->email = $request->email;
            $groupeFormelle->nombre_membres = $request->nombre_membres;
            $groupeFormelle->nombre_homme_group = $request->nombre_homme_group;
            $groupeFormelle->nombre_femme_group = $request->nombre_femme_group;

            // page 2
            $groupeFormelle->secteur_activite = $request->secteur_activite;
            $groupeFormelle->nombre_banques = $request->nombre_banques;
            $groupeFormelle->date_agrement = $request->date_agrement;
            $groupeFormelle->qualite = $request->qualite;
            $groupeFormelle->niveau_agence = $request->niveau_agence;
            $groupeFormelle->niveau_guichet = $request->niveau_guichet;
            $groupeFormelle->versement_initial = $request->versement_initial;
            $groupeFormelle->montant_epargne = $request->montant_epargne;
            $groupeFormelle->total_verse = $request->total_verse;
            $groupeFormelle->date_cloture_compte = $request->date_cloture_compte;
            $groupeFormelle->versement_final = $request->versement_final;

            // Définir le mot de passe par défaut
            $defaultPassword = bcrypt('Hbanking2023!');
            $groupeFormelle->password = $defaultPassword;

            $groupeFormelle->agence_id = '1';
            $groupeFormelle->juridique = $juridique;

            //dd($groupeFormelle);

            $groupeFormelle->save();

            //l'ID du client ajouter
            $clientId = $request->numero_client;

            // Générer un code PIN unique de 4 chiffres
            do {
                $pinCode = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
            } while (Account::where('pin_code', $pinCode)->exists());


            //
            $groupeFormelleAccount->date_ouverture_compte = $request->date_ouverture_compte;
            $groupeFormelleAccount->number_account = $request->number_account;
            $groupeFormelleAccount->type_account_id = $request->type_compte;
            $groupeFormelleAccount->client_id = $clientId;
            $groupeFormelleAccount->user_id =  Auth::user()->id;
            $groupeFormelleAccount->solde_init = $request->versement_initial;
            //$groupeFormelleAccount->statut = $request->statut;
            $groupeFormelleAccount->solde = $request->versement_initial + $request->montant_epargne;
            $groupeFormelleAccount->pouvoir_signataires = $request->pouvoir_signataires;
            $groupeFormelleAccount->date_cloture_compte = $request->date_cloture_compte;
            $groupeFormelleAccount->pin_code = $pinCode;
            $groupeFormelleAccount->monthly_maintenance_fee = $request->monthly_maintenance_fee;
            $groupeFormelleAccount->last_monthly_maintenance_date = $request->last_monthly_maintenance_date;

            //
            $groupeFormelleAccount->save();
            ///$request->session()->flash('code', $clientId);
            return redirect()->route('success_inscription', $clientId);
        }


        public function CompteGroupeSolidaireValid(Request $request)
        {

           $juridique = $request->id_groupe_solidaire;

           $groupeSolidaire = new Clients();
           $groupeSolidaireAccount = new Account();

            //dd($request->captured_signature_data, $request->captured_image_data);

            // Sauvegarder la signature capturée
            if ($request->filled('captured_signature_data')) {

                $base64Signature = $request->captured_signature_data;

                // Convertir la base64 en fichier image
                $signatureData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Signature));

                // Générer un nom de fichier unique
                $signatureName = 'signature_' . time() . '.png';

                // Enregistrer la signature sur le serveur
                $signatureDirectory = public_path('assets/images/signature/');

                if (!file_exists($signatureDirectory)) {

                    mkdir($signatureDirectory, 0755, true);
                }

                $signaturePath = $signatureDirectory . $signatureName;
                file_put_contents($signaturePath, $signatureData);

                //Page 3
                $groupeSolidaire->signature = $signatureName;

            }

                // Sauvegarder l'image capturée
            if ($request->filled('captured_image_data')) {

                $base64Image = $request->captured_image_data;

                // Convertir la base64 en fichier image
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

                // Générer un nom de fichier unique
                $imageName = 'captured_image_' . time() . '.png';

                // Enregistrer l'image sur le serveur
                $imageDirectory = public_path('assets/images/photo-profil/');

                if (!file_exists($imageDirectory)) {

                    mkdir($imageDirectory, 0755, true);
                }

                $imagePath = $imageDirectory . $imageName;
                file_put_contents($imagePath, $imageData);

                //Page 3
                $groupeSolidaire->photo = $imageName;

            }

            if ($request->hasFile('logo')) {
                $ext = $request->logo->getClientOriginalExtension();
                $name = time().'.'.$ext;
                $request->logo->move(public_path().'/assets/images/logo/', $name);
            } else {
                $name = null;
            }

            // Page 1 
            $groupeSolidaire->code_client = $request->numero_client;
            $groupeSolidaire->ancien_numero_client = $request->ancien_numero_client;
            $groupeSolidaire->logo = $name;
            $groupeSolidaire->lang = $request->langue_correspondance;
            $groupeSolidaire->nom_groupe = $request->nom_groupe;
            $groupeSolidaire->responsable_groupe = $request->responsable_groupe;
            $groupeSolidaire->adresse = $request->adresse;
            $groupeSolidaire->ville = $request->ville;
            $groupeSolidaire->code_postal = $request->code_postal;
            $groupeSolidaire->pays = $request->pays;
            $groupeSolidaire->telephone = $request->telephone;
            $groupeSolidaire->email = $request->email;

            // Page 2 
            $groupeSolidaire->nombre_imf = $request->nombre_imf;
            $groupeSolidaire->secteur_activite = $request->secteur_activite;
            $groupeSolidaire->nombre_banques = $request->nombre_banques;
            $groupeSolidaire->partenaires = $request->partenaires;
            $groupeSolidaire->gestionnaire = $request->gestionnaire;
            $groupeSolidaire->qualite = $request->qualite;
            $groupeSolidaire->membre1 = $request->membre1;
            $groupeSolidaire->membre2 = $request->membre2;
            $groupeSolidaire->membre3 = $request->membre3;
            $groupeSolidaire->niveau_agence = $request->niveau_agence;
            $groupeSolidaire->niveau_guichet = $request->niveau_guichet;
            $groupeSolidaire->numero_carte_bancaire = $request->numero_carte_bancaire;
            $groupeSolidaire->versement_initial = $request->versement_initial;
            $groupeSolidaire->montant_epargne = $request->montant_epargne;
            $groupeSolidaire->total_verse = $request->total_verse;
            $groupeSolidaire->date_cloture_compte = $request->date_cloture_compte;
            $groupeSolidaire->versement_final = $request->versement_final;

            // Définir le mot de passe par défaut
            $defaultPassword = bcrypt('Hbanking2023!');
            $groupeSolidaire->password = $defaultPassword;

            $groupeSolidaire->agence_id = '1';
            $groupeSolidaire->juridique = $juridique;


            $groupeSolidaire->save();

            //l'ID du client ajouter
            $clientId = $request->numero_client;
            // Générer un code PIN unique de 4 chiffres
            do {
                $pinCode = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
            } while (Account::where('pin_code', $pinCode)->exists());


            //
            $groupeSolidaireAccount->date_ouverture_compte = $request->date_ouverture_compte;
            $groupeSolidaireAccount->number_account = $request->number_account;
            $groupeSolidaireAccount->type_account_id = $request->type_compte;
            $groupeSolidaireAccount->client_id = $clientId;
            $groupeSolidaireAccount->user_id = Auth::user()->id;
            $groupeSolidaireAccount->solde_init = $request->versement_initial;
            //$groupeSolidaireAccount->statut = $request->statut;
            $groupeSolidaireAccount->solde = $request->versement_initial + $request->montant_epargne;
            $groupeSolidaireAccount->pouvoir_signataires = $request->pouvoir_signataires;
            $groupeSolidaireAccount->date_cloture_compte = $request->date_cloture_compte;
            $groupeSolidaireAccount->pin_code = $pinCode;
            $groupeSolidaireAccount->monthly_maintenance_fee = $request->monthly_maintenance_fee;
            $groupeSolidaireAccount->last_monthly_maintenance_date = $request->last_monthly_maintenance_date;

            //
           
            $groupeSolidaireAccount->save();

            return redirect()->route('success_inscription', $clientId);


        }

        public function SuccessInscription($code)
        {
            $code = $code;
            return view('pages.accounts.success_inscription')
            ->with('code', $code);

        }

        public function PrintInscription($code)
        {

            $data = [

                'i' => Clients::join('accounts', 'accounts.client_id', '=', 'clients.code_client')
                    ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
                    ->join('etat_juridiques', 'etat_juridiques.id', '=', 'clients.juridique')
                    ->join('users', 'users.id', '=', 'accounts.user_id')
                    ->join('agences', 'agences.id', '=', 'users.agence_id')
                    ->where('clients.code_client', $code)
                    ->select('clients.*', 'agences.name as nom_agence', 'users.matricule as matricule', 'accounts.number_account', 'accounts.date_ouverture_compte', 'etat_juridiques.name', 'etat_juridiques.id as id_juridique', 'type_accounts.name as type_compte')
                    ->first()   
                ];

            $dompdf = new Dompdf();

            // Récupérer la vue à convertir en PDF
            $html = view('pages.accounts.print', $data)->render();

            // Convertir la vue en PDF
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait'); 

            $dompdf->render();

            // Générer le fichier PDF
            $output = $dompdf->output();
            

            // Enregistrer le fichier PDF
            $filename = rand(9000, 999999).''.date('dmY').'-recu_inscription.pdf';
            file_put_contents(public_path('docs/fiche_inscriptions/'.$filename), $output);
            
            // Retourner une réponse avec le nom de fichier pour le téléchargement
           // return response()->loadView($filename);
            return $dompdf->stream($filename, ['Attachment' => false]);
            //return view('pages.caisses.print_close_caisse');
      

        }



    /***FIN OUVERTURE DE COMPTE***/

    /***FIN ACCOUNTS***/


    /***RECEPTION***/
    public function DemandeCredit()
    {
        if (! Gate::allows('is-receptioniste')) {
            return view('errors.403');
        }

        dd('Bonjour');
        $title = 'Liste des demandes de credits';

        $demandes = Credit::Join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
           ->Join('clients', 'accounts.client_id', '=', 'clients.code_client')
           ->Where('credits.statut', 'attente')
           //->Where('credits.user_id', Auth::user()->id)
           ->Select('credits.*', 'clients.nom', 'clients.prenom', 'type_credits.name')
           ->OrderBy('credits.created_at', 'DESC')
           ->paginate(50);

           dd($demandes);

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

            $flash = trim($request->flash);

            if ( strlen($flash) >= 16 ) {
                $compte = DB::table('accounts')->where('number_account', $flash)->first();
            }else{
                $rechercheFormattee = str_pad($flash, 6, "0", STR_PAD_LEFT);
                $compte = DB::table('accounts')
                    ->where('number_account', 'LIKE', "001-{$rechercheFormattee}%-%%")
                    ->first();

            }

            if ($compte) {
                
            
            $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.code_client')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('clients.code_client', $compte->client_id)
            ->first();

            if ( $data ) {

                $docs = Doc_credit::Where('client_id', $compte->client_id)->orderBy('id', 'DESC')->get();

                $type_credits = DB::table('type_credits')->latest()->get();
                $flash = $compte->number_account;

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

        
        $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.code_client')
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

            $request->session()->flash('msg_info', 'Vous avez ajouté un fichier avec succès !');
        }
        

        return back();
    }


    public function SendDemandeCredit(Request $request)
    {
        $rand = mt_rand(10000, 99999);
        $credit = Credit::Where('num_dossier', $rand)->first();

        while ($credit) {
            $rand = mt_rand(10000, 99999);
            $credit = Credit::Where('num_dossier', $rand)->first();
        }
        


        $send_demande = Credit::create([
            'code_client' => $request->codeClient,
            'num_dossier' => $rand,
            'num_account' => $request->num_account,
            'montant_demande' => $request->amount,
            'type_credit_id' => $request->type,
            'statut' => 'attente',
            'dossier_complete' => 'non',
            'date_demande' => date('d/m/Y'),
            'user_id' => Auth::user()->id,
        ]);

        
        Demande_credit_doc::create([
            'code_doc' => $request->code,
            'demande_credit_id' => $send_demande->num_dossier,
        ]);

        $dossier = $send_demande->num_dossier;

        $request->session()->flash('dossier', $dossier);

        return redirect()->route('dossier-success-credit');

    }

    public function DossierOuvertSuccess()
    {
        return view('pages.receptions.success_pret');
    }

    public function ListDemandes()
    {
       
       $title = 'Liste des demandes';

       $demandes = Credit::Join('accounts', 'accounts.number_account', '=', 'credits.num_account')
       ->Join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.code_client')
       ->Where('credits.statut', 'attente')
       ->Select('credits.*', 'clients.nom', 'clients.prenom', 'type_credits.name')
       ->OrderBy('credits.created_at', 'DESC')
       ->get();

       //dd($demandes);


       return view('pages.credits.view')
       ->with('title', $title)
       ->with('demandes', $demandes);

    }

    public function ProcessRemboursement(Request $request)
    {        

        $dossier = $request->dossier;
        $title = 'Remboursement du dossier '.$dossier;
        $num_account = $request->num_account;
        $type = $request->type;
        $modeRemboursement = $request->modeRemboursement;

        $credit = Credit::where('num_dossier', $dossier)->first();

        //dd($request->all());

        $echeancier = DB::table('echeanciers')
        ->where('dossier', $dossier)
        ->where('statut_paiement', 'en cours')
        ->first();

        $numero_echeances = DB::table('echeanciers')
        ->where('dossier', $dossier)
        ->where('statut_paiement', 'en cours')
        ->get();

        $account = Account::Where('number_account', $credit->num_account)->first();
        //dd($echeancier);

        return view('pages.credits.remboursement')
        ->with('account', $account)
        ->with('numero_echeances', $numero_echeances)
        ->with('credit', $credit)
        ->with('echeancier', $echeancier)
        ->with('title', $title);
    }

    public function ProcessRemboursementValid(Request $request)
    {
        

        $date_remboursement = $request->date_remboursement;
        $montant_du = $request->montant_du;
        $numero_dossier = $request->numero_dossier;

        $numero_lie = $request->numero_lie;
        $solde = $request->solde;
        $capital_attendu = $request->capital_attendu;
        $interet_attendu = $request->interet_attendu;
        $num_echeance = $request->num_echeance;
        $garantie_du = $request->garantie_du;
        $penalite_du = $request->penalite_du;
        $montant_remboursement = $request->montant_remboursement;

        $credit = DB::table('credits')->where('num_dossier', $numero_dossier)->first();

        if ( $montant_remboursement == $montant_du ) {

            DB::table('echeanciers')
            ->where('dossier', $numero_dossier)
            ->where('numero', $num_echeance)
            ->update([
                'echeance_cloture' => 'oui',
                'statut_paiement' => 'paye',
                'capital_remb' => $capital_attendu,
                'interet_remb' => $interet_attendu,
                'penalite_remb' => $penalite_du,
                'montant_total_remb' => $garantie_du + $penalite_du + $capital_attendu + $interet_attendu,
                'date_remb' => $date_remboursement,
                'heure_echeance' => date('H:i'),
            ]);

            DB::table('credits')->where('num_dossier', $numero_dossier)
            ->update([

                'capital_rembourse' => $credit->capital_rembourse + $capital_attendu,
                'interet_rembourse' => $credit->interet_rembourse + $interet_attendu,
                'penalite_rembourse' => $credit->penalite_rembourse + $penalite_du,
                'total_rembourse' => $credit->total_rembourse + $garantie_du + $penalite_du + $capital_attendu + $interet_attendu,
                'capital_du' => $credit->montant_octroye - ( $credit->capital_rembourse + $capital_attendu),
                'interet_restant_du' => $credit->montant_octroye - ( $credit->interet_rembourse + $interet_attendu),

            ]);


        }else{

            DB::table('echeanciers')
            ->where('dossier', $numero_dossier)
            ->where('numero', $num_echeance)
            ->update([
                'echeance_cloture' => 'non',
                'statut_paiement' => 'impaye',
                'capital_remb' => $montant_remboursement,
                'interet_remb' => $interet_attendu,
                'penalite_remb' => $penalite_du,
                'montant_total_remb' => $garantie_du + $penalite_du + $montant_remboursement + $interet_attendu,
                'date_remb' => $date_remboursement,
                'heure_echeance' => date('H:i'),
            ]);

            DB::table('credits')->where('num_dossier', $numero_dossier)
            ->update([

                'capital_rembourse' => $credit->capital_rembourse + $montant_remboursement,
                'interet_rembourse' => $credit->interet_rembourse + $interet_attendu,
                'penalite_rembourse' => $credit->penalite_rembourse + $penalite_du,
                'total_rembourse' => $credit->total_rembourse + $garantie_du + $penalite_du + $montant_remboursement + $interet_attendu,
                'capital_du' => $credit->montant_octroye - ( $credit->capital_rembourse + $montant_remboursement),
                'interet_restant_du' => $credit->montant_octroye - ( $credit->interet_rembourse + $interet_attendu),

            ]);

        }

        $request->session()->flash('msg_success', 'Vous avez effectué un remboursement pour le dossier numéro '.$numero_dossier);
        return back();


    }

    public function ListDemandesAssign()
    {
       
       $title = 'Liste des demandes';

       //dd('bonjour');
       $demandes = Credit::Join('accounts', 'accounts.number_account', '=', 'credits.num_account')
       ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'credits.num_dossier')
       ->Join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
       ->Join('clients', 'accounts.client_id', '=', 'clients.code_client')
       ->Select('credits.*', 'clients.nom', 'clients.prenom', 'type_credits.name')
       ->OrderBy('credits.date_demande', 'DESC')
       ->Where('analyste_demandes.analyste', Auth::user()->id)
       ->Where('credits.dossier_complete', 'non')
       ->get();
       
       return view('pages.credits.list_assign')
       ->with('title', $title)
       ->with('demandes', $demandes);

    }

    public function ListCredits()
    {

        $title = "Liste des crédits";

        $credits = Credit::join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
        ->join('etat_credits', 'etat_credits.id', '=', 'credits.etat_credit')
        ->orderBy('credits.id', 'ASC')->paginate(50);


        //dd($credits);

       return view('pages.credits.credit_octroye')
       ->with('title', $title)
       ->with('credits', $credits);

    }


    public function CompleteDemandes($id)
    {
        $title = "Completer la demande du dossier: ".$id;
        

        $demande = Credit::Join('accounts', 'accounts.number_account', '=', 'credits.num_account')
       ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'credits.num_dossier')
       ->Join('clients', 'accounts.client_id', '=', 'clients.code_client')
       ->Join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
       ->Select('credits.*', 'clients.nom', 'clients.prenom', 'type_credits.name')
       ->OrderBy('credits.date_demande', 'DESC')
       ->Where('credits.num_dossier', $id)
       ->first();

       //dd($demande);

       $type_credits = DB::table('type_credits')->latest()->get();
       $taux = DB::table('taux_interets')->latest()->get();
       $objets = DB::table('objet_demandes')->OrderBy('libelle', 'ASC')->get();
       $biens = DB::table('type_biens')->OrderBy('libelle', 'ASC')->get();


        return view('pages.credits.complete_info')
        ->with('title', $title)
        ->with('taux', $taux)
        ->with('objets', $objets)
        ->with('biens', $biens)
        ->with('demande_id', $id)
        ->with('type_credits', $type_credits)
        ->with('demande', $demande);
    }

    public function CompleteDemandesValid(Request $request)
    {
        // 

        if ( intval($request->mnt_garantie) >= intval($request->garantie_attendue)) {
            
        
            Credit::where('num_dossier', $request->dossier)
            ->update([
                'date_deblocage' => $request->date_deblocage,
                'duree' => $request->duree,
                'duree_restant' => $request->duree,
                'date_deblocage' => $request->date_deblocage,
                'obj_dem' => $request->objet,
                'prelev_auto' => $request->preleve_auto,
                'commission' => $request->commission,
                'assurance' => $request->assurance,
                'garantie_attendu' => $request->garantie_attendue,
                'detail_obj_dem' => $request->detail_demande,
                'type_garantie' => $request->type_garantie,
                'gar_tot_mobilise' => $request->mnt_garantie,
                'type_bien_id' => $request->type_bien,
                'gar_materielle' => $request->client_garant,
                'etat_gar' => $request->etat_gar,
                'description_gar_mobilise' => $request->description,
                'dossier_complete' => 'oui',
                'date_complete_demande' => date('d/m/Y'),
                'user_complete_dossier' => Auth()->user()->id
            ]);

            return redirect()->route('success-complete', $request->dossier);

        }else{
            $request->session()->flash('msg_error', 'Le montant de la garantie ne doit pas être inférieur du montant attendu. Merci de revoir la garantie');
        }

    }

    public function SuccessComplete($dossier)
    {
        
        $client = Credit::Join('clients', 'clients.code_client', '=', 'credits.code_client')
            ->Where('credits.num_dossier', $dossier)
            ->first();

        return view('pages.credits.succes_complete_demande')
        ->with('client', $client)
        ->with('dossier', $dossier);

    }

    public function CompleteDemandesStep2(Request $request, $id)
    {

        $title = "Completer la demande";

        $demande = Credit::Join('accounts', 'accounts.number_account', '=', 'credits.num_account')
       ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'credits.num_dossier')
       ->Join('clients', 'accounts.client_id', '=', 'clients.code_client')
       ->Select('credits.*', 'clients.nom', 'clients.prenom')
       ->OrderBy('credits.date_demande', 'DESC')
       ->Where('credits.num_dossier', $id)
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

        $demande = Credit::Join('accounts', 'accounts.number_account', '=', 'credits.num_account')
       ->Join('analyste_demandes', 'analyste_demandes.demande', '=', 'credits.num_dossier')
       ->Join('clients', 'accounts.client_id', '=', 'clients.code_client')
       ->Select('demande_credits.*', 'clients.nom', 'clients.prenom')
       ->OrderBy('credits.date_demande', 'DESC')
       ->Where('credits.num_dossier', $id)
       ->first();

       $request->session()->put('data_step_3', $request->all());

        return view('pages.credits.complete_info_3')
        ->with('demande', $demande)
        ->with('title', $title);
    }

    public function DetailDemandes($dossier)
    {
        
        $title = 'Détails de la demande';
        $demande = Credit::join('accounts', 'accounts.number_account', '=', 'credits.num_account')
           ->join('demande_credit_docs', 'credits.num_dossier', '=', 'demande_credit_docs.demande_credit_id')
           ->join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
           ->join('clients', 'accounts.client_id', '=', 'clients.code_client')
           ->select('credits.*', 'clients.nom', 'clients.prenom', 'type_credits.name', 'demande_credit_docs.code_doc')
           ->where('credits.num_dossier', $dossier)->first();

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

    public function sendDemandeAnalyste($dossier)
    {
        
        $title = 'Envoyer cette demande à l\'un des analyste';

        //dd('send');
        $demande = Credit::join('accounts', 'accounts.number_account', '=', 'credits.num_account')
           ->join('demande_credit_docs', 'credits.num_dossier', '=', 'demande_credit_docs.demande_credit_id')
           ->join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
           ->join('clients', 'accounts.client_id', '=', 'clients.code_client')
           ->select('credits.*', 'clients.nom', 'clients.prenom', 'type_credits.name', 'demande_credit_docs.code_doc')
           ->where('credits.num_dossier', $dossier)->first();

           //dd($demande);

        $analystes = User::Where('role_id', 7)
        ->Where('agence_id', Auth::user()->agence_id)
        ->get();

        $assign = Analyste_demande::Where('demande', $demande->num_dossier)->first();
 
        //dd($assign);

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

    public function correspondances()
    {
        
        $title = 'Correspondances';

        $correspondances = Correspondance::OrderBy('id', 'DESC')->get();
        return view('pages.receptions.correspondance')
        ->with('title', $title)
        ->with('correspondances', $correspondances);
    }

    public function correspondanceNew()
    {
        $title = 'Ajouter Correspondance';

        return view('pages.receptions.add_correspondance')
        ->with('title', $title);
    }

    public function correspondanceNewValid(Request $request)
    {
        

        Correspondance::create([
            'date' =>$request->date, 
            'heure' =>$request->hour,
            'nature' =>$request->nature,
            'quantite' =>$request->qte,
            'auteur_livraison' =>$request->auteur,
            'expediteur' =>$request->expediteur,
            'destinataire' =>$request->destinataire,
            'description' =>$request->description,
            'user_id' =>Auth::user()->id,
        ]);

        $request->session()->flash('msg_success', 'Vous avez ajouter une correspondance avec succès !');

        return back();
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

     public function CoffreFort()
    {
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

        $title = 'Coffres Forts';
        $agences = Agence::latest()->get();

        $coffreforts = Coffrefort::join('agences', 'agences.id', '=', 'coffreforts.agence_id')
        ->select('coffreforts.*', 'agences.name as agence', 'agences.ville')
        ->get();

        $total_coffrefort = 0;
        foreach ($coffreforts as $key => $value) {
            // code...
            $total_coffrefort = $total_coffrefort + $value->montant;
        }


        $banquexternes = Banquexterne::latest()->get();

        $caissier_p = User::where('role_id', 5)->get();

        $compteComptable = Compte_comptable::where('libelle', 'LIKE', 'Caisse%')
                                   ->orWhere('libelle', 'LIKE', 'CAISSE%')
                                   ->get();
        $coffre = Compte_global::Where('id', 1)->first();

        return view('pages.agences.depot_agence')
        ->with('caissier_p', $caissier_p)
        ->with('compteComptable', $compteComptable)
        ->with('agences', $agences)
        ->with('coffreforts', $coffreforts)
        ->with('total_coffrefort', $total_coffrefort)
        ->with('banquexternes', $banquexternes)
        ->with('coffre', $coffre)
        ->with('title', $title);

    }

    public function BankToCoffre(Request $request)
    {
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

        // code...
        $banque = $request->banque;
        $coffre = $request->coffre;


        $amount = intval($request->amount);

    
        $banquexterne = Banquexterne::where('compte_comptable_id', $banque)->first();

        if ( $banquexterne->montant < $amount ) {

            $request->session()->flash('msg_error', 'Le solde de cette banque est insufisant!');

            //return back();
        }else{


            $newNumber = mt_rand(10000, 999999);

            $numerPieceExist = Journal::Where('numero_piece', $newNumber)->first();

            while ( $numerPieceExist ) {
                $newNumber = mt_rand(10000, 999999);
                $numerPieceExist = Journal::Where('numero_piece', $newNumber)->first();
            }

            $compteComptableCoffre = Compte_comptable::where('numero', $coffre)->first();


            $CoffreExist = Coffrefort::where('compte_comptable_id', $coffre)->first();


            Coffrefort::Where('compte_comptable_id', $coffre)
            ->update([
                'montant' => $CoffreExist->montant + $amount,
            ]);

            $BanqueExist = Banquexterne::where('compte_comptable_id', $banque)->first();
            Banquexterne::Where('compte_comptable_id', $banque)
            ->update([
                'montant' => $BanqueExist->montant - $amount,
            ]);

            $compteComptable = Compte_comptable::where('numero', $banque)->first();

            Journal::create([
                'date' => date('d/m/Y'),
                'numero_piece' => $newNumber,
                'compte' => $banque,
                'intitule' => $compteComptable->libelle,
                'credit' => $amount,
            ]);

            $ref = 'BANKCOF-'.$newNumber.date('Ymd');
            Journal::create([
                'date' => date('d/m/Y'),
                'numero_piece' => $newNumber,
                'fonction' => 'Transfert',
                'reference' => $ref,
                'description' => 'Approvisionnement du coffre fort',
                'compte' => $coffre,
                'intitule' => $compteComptableCoffre->libelle,
                'debit' => $amount,
            ]);

        
            Compte_comptable::where('numero', $banque)
            ->update([
                'Debiteur' => $compteComptable->debiteur - $amount
            ]);

            Compte_comptable::where('numero', $coffre)
            ->update([
                'Debiteur' => $compteComptableCoffre->debiteur + $amount
            ]);

            $request->session()->flash('msg_success', 'Vous avez approvisionné le coffre de l\'agence de '.$compteComptableCoffre->libelle);

        }


        return back();
    }

    public function BankToBanque(Request $request)
    {
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

        // code...
        $banque = $request->banque;
        $coffre = $request->coffre;


        $amount = intval($request->amount);

    
        $banquexterne = Banquexterne::where('compte_comptable_id', $banque)->first();

        if ( $banquexterne->montant < $amount ) {

            $request->session()->flash('msg_error', 'Le solde de cette banque est insufisant!');

            //return back();
        }else{


            $newNumber = mt_rand(10000, 999999);

            $numerPieceExist = Journal::Where('numero_piece', $newNumber)->first();

            while ( $numerPieceExist ) {
                $newNumber = mt_rand(10000, 999999);
                $numerPieceExist = Journal::Where('numero_piece', $newNumber)->first();
            }

            $compteComptableCoffre = Compte_comptable::where('numero', $coffre)->first();


            $CoffreExist = Coffrefort::where('compte_comptable_id', $coffre)->first();


            Coffrefort::Where('compte_comptable_id', $coffre)
            ->update([
                'montant' => $CoffreExist->montant + $amount,
            ]);

            $BanqueExist = Banquexterne::where('compte_comptable_id', $banque)->first();
            Banquexterne::Where('compte_comptable_id', $banque)
            ->update([
                'montant' => $BanqueExist->montant + $amount,
            ]);

            $compteComptable = Compte_comptable::where('numero', $banque)->first();

            

            $ref = 'BANKCOF-'.$newNumber.date('Ymd');
            Journal::create([
                'date' => date('d/m/Y'),
                'numero_piece' => $newNumber,
                'compte' => $banque,
                'intitule' => $compteComptable->libelle,
                'credit' => $amount,
            ]);

            Journal::create([
                'date' => date('d/m/Y'),
                'numero_piece' => $newNumber,
                'fonction' => 'Transfert',
                'reference' => $ref,
                'description' => 'Approvisionnement de la banque',
                'compte' => $coffre,
                'intitule' => $compteComptableCoffre->libelle,
                'debit' => $amount,
            ]);

            

            Compte_comptable::where('numero', $banque)
            ->update([
                'Debiteur' => $compteComptable->debiteur + $amount
            ]);

            Compte_comptable::where('numero', $coffre)
            ->update([
                'Debiteur' => $compteComptableCoffre->debiteur - $amount
            ]);

            $request->session()->flash('msg_success', 'Vous avez approvisionné le coffre de l\'agence de '.$compteComptableCoffre->libelle);

        }


        return back();
    }

    public function CoffreToCoffre(Request $request)
    {
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

        // code...
        $coffre_exp = $request->coffre_exp;
        $coffre_dest = $request->coffre_dest;


        $amount = intval($request->amount);

    
        $coffreExpediteur = Coffrefort::where('compte_comptable_id', $coffre_exp)->first();

        if ( $coffreExpediteur->montant < $amount ) {

            $request->session()->flash('msg_error', 'Le solde de ce coffre fort est insufisant!');

        }elseif ( $coffre_exp == $coffre_dest ) {

            $request->session()->flash('msg_error', 'Vous tentez d\'envoyer l\'argent au même compte coffre fort!');

        }else{

            $newNumber = mt_rand(10000, 999999);
            $numerPieceExist = Journal::Where('numero_piece', $newNumber)->first();
            while ( $numerPieceExist ) {
                $newNumber = mt_rand(10000, 999999);
                $numerPieceExist = Journal::Where('numero_piece', $newNumber)->first();
            }



            $compteComptableCoffreExp = Compte_comptable::where('numero', $coffre_exp)->first();

            $CoffreFortExpediteur = Coffrefort::where('compte_comptable_id', $coffre_exp)->first();


            Coffrefort::Where('compte_comptable_id', $coffre_exp)
            ->update([
                'montant' => $CoffreFortExpediteur->montant - $amount,
            ]);


            $CoffreFortDestinataire = Coffrefort::where('compte_comptable_id', $coffre_dest)->first();

            Coffrefort::Where('compte_comptable_id', $coffre_dest)
            ->update([
                'montant' => $CoffreFortDestinataire->montant + $amount,
            ]);

            
            $compteComptableCoffreDest = Compte_comptable::where('numero', $coffre_dest)->first();


            Journal::create([
                'date' => date('d/m/Y'),
                'numero_piece' => $newNumber,
                'compte' => $coffre_dest,
                'intitule' => $compteComptableCoffreDest->libelle,
                'credit' => $amount,
            ]);

            $ref = 'COFTOCOF-'.$newNumber.date('Ymd');
            Journal::create([
                'date' => date('d/m/Y'),
                'numero_piece' => $newNumber,
                'fonction' => 'Transfert',
                'reference' => $ref,
                'description' => 'Approvisionnement du coffre fort',
                'compte' => $coffre_exp,
                'intitule' => $compteComptableCoffreExp->libelle,
                'debit' => $amount,
            ]);

            


            Compte_comptable::where('numero', $coffre_exp)
            ->update([
                'Debiteur' => $compteComptableCoffreExp->debiteur - $amount
            ]);

            Compte_comptable::where('numero', $coffre_dest)
            ->update([
                'Debiteur' => $compteComptableCoffreDest->debiteur + $amount
            ]);

            $request->session()->flash('msg_success', 'Vous avez approvisionné le coffre de l\'agence de '.$compteComptableCoffreDest->libelle);

        }


        return back();
    }
   
    public function CoffreToPrincipal(Request $request)
    {
        // code...

        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

        //dd($request->amount);

        $amount = intval($request->amount);
        $montant = intval($request->montant);


        if ( !isset( $request->amount ) || empty($request->amount) ) {
            
            $request->session()->flash('msg_error', 'Vous devez saisir le montant a transferer');
            return back();

        }elseif ( $montant < $amount ) {

            $request->session()->flash('msg_error', 'Le solde de ce coffre fort est insufisant!');

        }else{


            //dd($request->all());
            $newNumber = mt_rand(10000, 999999);
            $numerPieceExist = Journal::Where('numero_piece', $newNumber)->first();
            while ( $numerPieceExist ) {
                $newNumber = mt_rand(10000, 999999);
                $numerPieceExist = Journal::Where('numero_piece', $newNumber)->first();
            }

            


            $compteComptableCaisse = Compte_comptable::where('numero', $request->caissier_principal)->first();
            Compte_comptable::where('numero', $request->caissier_principal)
            ->update([
                'debiteur' => $compteComptableCaisse->debiteur + $amount
            ]);


            $compteComptableCoffre = Compte_comptable::where('numero', $request->compte_id)->first();

            Compte_comptable::where('numero', $request->compte_id)
            ->update([
                'debiteur' => $compteComptableCoffre->debiteur - $amount
            ]);

            $coffrefort = Coffrefort::where('compte_comptable_id', $request->compte_id)->first();

            Coffrefort::where('compte_comptable_id', $request->compte_id)
            ->update([
                'montant' => $coffrefort->montant - $amount
            ]);

            Journal::create([
                'date' => date('d/m/Y'),
                'numero_piece' => $newNumber,
                'compte' => $request->compte_id,
                'intitule' => $compteComptableCoffre->libelle,
                'credit' => $amount,
            ]);

            $ref = 'COFTOCP-'.$newNumber.date('Ymd');
            Journal::create([
                'date' => date('d/m/Y'),
                'numero_piece' => $newNumber,
                'fonction' => 'Approvisionnement',
                'reference' => $ref,
                'description' => 'Approvisionnement caisse principale',
                'compte' => $request->caissier_principal,
                'intitule' => $compteComptableCaisse->libelle,
                'debit' => $amount,
            ]);

            $request->session()->flash('msg_success', 'Vous avez approvisionné la caisse principale '.$compteComptableCaisse->libelle);

        }

        return back();
    }

    public function TransfertVersAgenceValid(Request $request)
    {
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

        //dd($request->amount);

        if ( !isset( $request->amount ) || empty($request->amount) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le montant a transferer');
            return back();
        }else{

            Agence::Where('id', $request->agence_id)
            ->update([
                'solde_principal' => $request->amount,
                'de_numer_compte' => '1.0.1.1.1',
                'vers_numero_compte' => $request->caissier_principal,
                'user_id' => Auth::user()->id
            ]);


            $coffre = Compte_global::Where('id', 1)->first();


            Compte_global::Where('id', 1)
            ->update([
                'montant' => $coffre->montant - $request->amount, 
            ]);

         $request->session()->flash('msg_success', 'Vous avez transferer le montant de '.$request->amount.' BIF vers l\'agence '.$request->name);

          return back();  
        }
    }

    public function TransfertVersAgenceValidEdit(Request $request)
    {
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

        //dd($request->amount);

        if ( !isset( $request->amount ) || empty($request->amount) ) {
            $request->session()->flash('msg_error', 'Vous devez saisir le montant a transferer');
            return back();
        }else{

            Agence::Where('id', $request->agence_id)
            ->update([
                'solde_principal' => $request->amount,
                'de_numer_compte' => '1.0.1.1.1',
                'vers_numero_compte' => $request->caissier_principal,
                'user_id' => Auth::user()->id
            ]);


            $coffre = Compte_global::Where('id', 1)->first();


            Compte_global::Where('id', 1)
            ->update([
                'montant' => $coffre->montant - $request->amount, 
            ]);

         $request->session()->flash('msg_success', 'Vous avez édité le montant de '.$request->amount.' BIF vers l\'agence '.$request->name);

          return back();  
        }
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

            $flash = trim($request->flash);
            if ( strlen($flash) >= 16 ) {
                $compte = DB::table('accounts')->where('number_account', $flash)->first();
            }else{
                $rechercheFormattee = str_pad($flash, 6, "0", STR_PAD_LEFT);
                $compte = DB::table('accounts')
                    ->where('number_account', 'LIKE', "001-{$rechercheFormattee}%-%%")
                    ->first();
            }

            if ($compte) {

            $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.code_client')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('clients.code_client', $compte->client_id)
            ->first();

            //dd($data);

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

            $flash = trim($request->flash);
            if ( strlen($flash) >= 16 ) {
                
                $compte = DB::table('accounts')->where('number_account', $flash)->first();

            }else{

                $rechercheFormattee = str_pad($flash, 6, "0", STR_PAD_LEFT);
                $compte = DB::table('accounts')
                    ->where('number_account', 'LIKE', "001-{$rechercheFormattee}%-%%")
                    ->first();

            }

            if ($compte) {
                
            
            $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.code_client')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('clients.code_client', $compte->client_id)
            ->first();


            if ( $data ) {

                $operations = Operation::join('type_operations', 'type_operations.id', '=', 'operations.type_operation_id')
                ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
                //->join('clients', 'clients.code_client', '=', 'accounts.client_id')
                ->Where('accounts.number_account', $compte->number_account)
                ->select('operations.*', 'type_operations.name', 'accounts.solde')
                ->get();

                //dd($operations);
                $account_num = $compte->number_account;
        

                $client = Account::join('clients', 'clients.code_client', '=', 'accounts.client_id')
                        ->Where('accounts.number_account', $account_num)
                        ->first();

                $number_account = $compte->number_account;

                $datas = [
                    
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

    /**FRAIS**/

    public function frais()
    {
       
       $title = 'Frais';

       $frais = Type_frais::OrderBy('id', 'DESC')->get();

       $comptes = DB::table('type_accounts')->WhereIn('id', [18, 19])->get();
 
       //dd($comptes);
       return view('pages.frais.frais')
       ->with('title', $title)
       ->with('comptes', $comptes)
       ->with('frais', $frais);
    }

    public function fraisNewValid(Request $request)
    {
       
       $init = "REF-FRAI-";
        $rand = rand(111111, 999999);
        $date = date("Ymd");

        $code = $init.$rand.$date;


       Type_frais::create([

            'reference' => $code, 
            'name' => $request->type_frais, 
            'montant' => $request->amount, 
            'type_compte_id' => $request->compte, 
            'frequence' => $request->frequence, 
            'description' => $request->description, 
            'user_id' => Auth::user()->id

       ]);

       $request->session()->flash('msg_success', 'Vous avez ajouté un type de frais avec succès! ');
       return back();

    }

    public function fraisEdit($id)
    {
        // code...
        $title = 'Edit Frais';

        $frais = Type_frais::OrderBy('id', 'DESC')->get();
        $edit_f = Type_frais::Where('id', $id)->first();

        $comptes = DB::table('type_accounts')->WhereIn('id', [18, 19])->get();
 
        return view('pages.frais.edit')
        ->with('title', $title)
        ->with('comptes', $comptes)
        ->with('edit_f', $edit_f)
        ->with('frais', $frais);

    }

    public function fraisEditValid(Request $request)
    {
       
       Type_frais::Where('id', $request->frais_id)->update([
            'name' => $request->type_frais, 
            'montant' => $request->amount, 
            'type_compte_id' => $request->compte, 
            'frequence' => $request->frequence, 
            'description' => $request->description, 
            'user_id' => Auth::user()->id

       ]);

       $request->session()->flash('msg_success', 'Vous avez modifié un type de frais avec succès! ');
       return back();

    }
    /**FIN FRAIS**/


    /**COMPTABILITE**/
    public function RapportVersements()
    {

        if (! Gate::allows('is-comptable')) {
            return view('errors.403');
        }

        $title = 'Rapport des versements';
        $versements = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.code_client', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom')
        ->Where('operations.type_operation_id', 3)
        ->Where('operations.statut', 'valide')
        ->OrderBy('operations.id', 'DESC')
        ->get();


        return view('pages.transactions.rapportVersement')
        ->with('title', $title)
        ->with('versements', $versements);
    }

    public function RapportRetraits()
    {

        if (! Gate::allows('is-comptable')) {
            return view('errors.403');
        }

        $title = 'Rapport des retraits';

        $retraits = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom')
        ->Where('operations.type_operation_id', 2)
        ->OrderBy('operations.id', 'DESC')
        ->get();

        return view('pages.transactions.rapportRetrait')
        ->with('title', $title)
        ->with('retraits', $retraits);
    }

    public function RapportVirements()
    {
        if (! Gate::allows('is-comptable')) {
            return view('errors.403');
        }
        
        $title = "Rapport de Virements";

        $virements = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*', 'clients.nom', 'clients.prenom')
        ->Where('operations.type_operation_id', 1)
        ->OrderBy('operations.id', 'DESC')
        ->get();

        return view('pages.transactions.rapportVirement')
        ->with('title', $title)
        ->with('virements', $virements);
    }


    public function RapportChequiers()
    {

        if (! Gate::allows('is-comptable')) {
            return view('errors.403');
        }

        $title = 'Rapports de commande de chequiers';

        $chequiers = Chequier::join('accounts', 'accounts.id', '=', 'chequiers.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->OrderBy('chequiers.id', 'DESC')
        ->get();

        return view('pages.transactions.rapportChequiers')
        ->with('title', $title)
        ->with('chequiers', $chequiers);

    }
    /**FIN COMPTABILITE**/


    /**SEUIL**/
    public function Seuil()
    {
        $title = "Définition des seuils";

        $seuil_vers = Seuil::where('type_operation_id', 3)->latest()->get();
        $seuils = Seuil::where('type_operation_id', 2)->latest()->get();

        return view('pages.seuils.index')
        ->with('seuil_vers', $seuil_vers)
        ->with('seuils', $seuils)
        ->with('title', $title);
    }

    public function SeuilValidVersement(Request $request)
    {

        if ( !isset($request->periode) || empty($request->periode) ) {
            
            $request->session()->flash('msg_error', 'Vous devez selectionner la periode');
        }elseif (!isset($request->amount) || empty($request->amount)) {
            $request->session()->flash('msg_error', 'Vous devez saisir le montant');
        }else{

            Seuil::create([
                'type_operation_id' => 3, 
                'periode' => $request->periode, 
                'montant_limite' => $request->amount,
            ]);

            $request->session()->flash('msg_success', 'Vous avez ajouté le seuil avec succès!');
        }
        return back();
    }

    public function SeuilValidRetrait(Request $request)
    {

        if ( !isset($request->periode) || empty($request->periode) ) {
            
            $request->session()->flash('msg_error', 'Vous devez selectionner la periode');
        }elseif (!isset($request->amount) || empty($request->amount)) {
            $request->session()->flash('msg_error', 'Vous devez saisir le montant');
        }else{

            Seuil::create([
                'type_operation_id' => 2, 
                'periode' => $request->periode, 
                'montant_limite' => $request->amount,
            ]);

            $request->session()->flash('msg_success', 'Vous avez ajouté le seuil avec succès!');
        }
        return back();
    }

    public function SeuilEditRetrait($id)
    {
        $title = "Editer la définition des seuils";
        $seuil = Seuil::where('id', $id)->where('type_operation_id', 2)->first();
        $seuil_vers = Seuil::where('type_operation_id', 3)->latest()->get();
        $seuils = Seuil::where('type_operation_id', 2)->latest()->get();

        return view('pages.seuils.edit')
        ->with('seuils', $seuils)
        ->with('seuil_vers', $seuil_vers)
        ->with('seuil', $seuil)
        ->with('title', $title);
    }

    public function SeuilEditVersement($id)
    {
        $title = "Editer la définition des seuils";
        $seuil = Seuil::where('id', $id)->where('type_operation_id', 3)->first();
        $seuil_vers = Seuil::where('type_operation_id', 3)->latest()->get();
        $seuils = Seuil::where('type_operation_id', 2)->latest()->get();

        return view('pages.seuils.edit_vers')
        ->with('seuils', $seuils)
        ->with('seuil_vers', $seuil_vers)
        ->with('seuil', $seuil)
        ->with('title', $title);
    }

    public function SeuilEditRetraitValid(Request $request)
    {

        if ( !isset($request->periode) || empty($request->periode) ) {
            $request->session()->flash('msg_error', 'Vous devez selectionner la periode');
        }elseif (!isset($request->amount) || empty($request->amount)) {
            $request->session()->flash('msg_error', 'Vous devez saisir le montant');
        }else{

            Seuil::where('id', $request->id)
            ->update([
                'periode' => $request->periode, 
                'montant_limite' => $request->amount,
            ]);

            $request->session()->flash('msg_success', 'Vous avez modifié le seuil avec succès!');
        }
        return back();
    }

    public function SeuilEditVersementValid(Request $request)
    {

        if ( !isset($request->periode) || empty($request->periode) ) {
            $request->session()->flash('msg_error', 'Vous devez selectionner la periode');
        }elseif (!isset($request->amount) || empty($request->amount)) {
            $request->session()->flash('msg_error', 'Vous devez saisir le montant');
        }else{

            Seuil::where('id', $request->id)
            ->update([
                'periode' => $request->periode, 
                'montant_limite' => $request->amount,
            ]);

            $request->session()->flash('msg_success', 'Vous avez modifié le seuil avec succès!');
        }
        return back();
    }
    /**FIN SEUIL**/

    /**GRAND LIVRE**/
    public function GrandLivre()
    {
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

        // code...
        $title = 'Personnalisation du Grand Livre';

        $compteComptables = Compte_comptable::all();

        return view('pages.grand_livres.index')
        ->with('compteComptables', $compteComptables)
        ->with('title', $title);
    }

    public function GrandLivreSearchPeriode(Request $request)
    {
        // code...

        $title = 'Grand Livre';
        $compteComptables = Compte_comptable::all();

        $periode = $request->periode;
        $affichage = $request->affichage;


        return view('pages.grand_livres.resultat_grand_livre')
        ->with('compteComptables', $compteComptables)
        ->with('periode', $periode)
        ->with('affichage', $affichage)
        ->with('title', $title);
    }

    public function GrandLivreSearchDateIntervalle(Request $request)
    {
        // code...

        $title = 'Grand Livre';
        $compteComptables = Compte_comptable::all();

        $date_debut = $request->date_debut;
        $date_fin = $request->date_fin;
        $affichage = $request->affichage;


        return view('pages.grand_livres.resultat_grand_livre')
        ->with('compteComptables', $compteComptables)
        ->with('date_debut', $date_debut)
        ->with('date_fin', $date_fin)
        ->with('affichage', $affichage)
        ->with('title', $title);
    }

    public function GrandLivreSearchCompteIntervalle(Request $request)
    {
        // code...

        $title = 'Grand Livre';
        $compteComptables = Compte_comptable::all();

        $du_compte = $request->du_compte;
        $au_compte = $request->au_compte;
        $affichage = $request->affichage;


        return view('pages.grand_livres.resultat_grand_livre')
        ->with('compteComptables', $compteComptables)
        ->with('au_compte', $au_compte)
        ->with('du_compte', $du_compte)
        ->with('affichage', $affichage)
        ->with('title', $title);
    }

    public function pdfGrandLivre()
    {
        
        //dd('Print le monde');
        $data = [

            'v' => Compte_comptable::all()

            ];
        
        //dd($data);
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.grand_livres.printPDF', $data)->render();

        // Convertir la vue en PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'portrait'); 

        $dompdf->render();

        // Générer le fichier PDF
        $output = $dompdf->output();
        

        // Enregistrer le fichier PDF
        $filename = rand(9000, 999999).''.date('dmY').'-grand-livre.pdf';
        //file_put_contents(public_path('assets/docs/recus/versements/'.$filename), $output);
        
        //$dompdf->stream();

        // Retourner une réponse avec le nom de fichier pour le téléchargement
        //return response()->loadView($filename);
        return $dompdf->stream($filename, ['Attachment' => false]);
        //return view('pages.caisses.print_close_caisse');
        return back();
    }


    public function GestionComptable()
    {
        // code...
        $title = "Gestion du plan comptable";

        $gestion_comptables = Compte_comptable::all();
        return view('pages.grand_livres.gestion_comptable')
        ->with('gestion_comptables', $gestion_comptables)
        ->with('title', $title);
    }

    public function GestionComptableEdit($numero)
    {
        // code...
        // code...
        $title = "Editer du compte ".$numero;

        $gestion_comptable = Compte_comptable::where('numero', $numero)->first();
        return view('pages.grand_livres.edit_gestion_comptable')
        ->with('gestion_comptable', $gestion_comptable)
        ->with('title', $title);

    }

    public function GestionComptableEditValid(Request $request)
    {
        Compte_comptable::where('numero', $request->numero)
        ->update([
            'libelle' => $request->libelle,
            'compartiment' => $request->compartiment,
            'sens' => $request->sens,
        ]);

        $request->session()->flash("msg_success", "Modification du compte comptable effectuée avec succès!");

        return back();

    }

    public function DepenseRevenus()
    {
        if (! Gate::allows('is-comptable')) {

            return view('errors.403');

        }

        // code...
        $title = "Dépenses et Revenus";

        $depensesRevenus = Depense_revenue::latest()->get();
        $gestion_comptables = Compte_comptable::all();

        return view('pages.depense_revenus.index')
        ->with('depensesRevenus', $depensesRevenus)
        ->with('gestion_comptables', $gestion_comptables)
        ->with('title', $title);
    }

    public function DepenseRevenusValid(Request $request)
    {

        Depense_revenue::create([
            'libelle' => $request->libelle,
            'sens' => $request->sens,
            'type_mouvement' => $request->type_mouvement,
            'compte_comptable_id' => $request->compte,
        ]);

        $request->session()->flash('msg_success', 'Ajout de dépense ou revenus effectuée avec succès!');
        return back();
    }

    public function DepenseRevenusEdit($id)
    {
        // code...
        $title = "Edition de dépense ou revenus";

        $depensesRevenu = Depense_revenue::where('id', $id)->first();
        $gestion_comptables = Compte_comptable::all();
        $depensesRevenus = Depense_revenue::latest()->get();

        return view('pages.depense_revenus.edit')
        ->with('depensesRevenus', $depensesRevenus)
        ->with('depensesRevenu', $depensesRevenu)
        ->with('gestion_comptables', $gestion_comptables)
        ->with('title', $title);

    }
    /**FIN GRAND LIVRE**/


    /**JOURNAL**/

    public function journal()
    {
        if (! Gate::allows('is-comptable')) {
            return view('errors.403');
        }

        $title = "Journal";

        $journals = DB::table('journals')
                    ->select('*')
                    ->orderBy('numero_piece', 'ASC')
                    ->orderBy('date', 'ASC')
                    ->get()
                    ->groupBy('numero_piece');

        return view('pages.journals.index')
        ->with('title', $title)
        ->with('journals', $journals);

    }

    public function journalStart()
    {
        if (! Gate::allows('is-comptable')) {
            return view('errors.403');
        }

        // code...
        $title = "Personalisation du Journal";

        return view('pages.journals.start')
        ->with('title', $title);

    }

    public function JournalSearchDateIntervalle(Request $request)
    {

        if (! Gate::allows('is-comptable')) {
            return view('errors.403');
        }

        $title = 'Journal';
        $date_debut = $request->date_debut;
        $date_fin = $request->date_fin;
        $compteComptables = Compte_comptable::all();

        $operations = DB::table('journals');
          //->join('users', 'users.id', '=', 'journals.user_id')
          //->join('agences', 'agences.id', '=', 'users.agence_id');

        $affichage = $request->affichage;

                    

            if ( isset($date_debut) && isset($date_fin) ) {
                    
               $journals = Journal::Join('fonctions', 'fonctions.code_fonction', '=', 'journals.fonction')->whereBetween('journals.date', [$date_debut, $date_fin])
                       ->select('journals.numero_piece', 'journals.date', 'journals.description', 'journals.client_id', 'journals.compte', 'journals.credit', 'journals.debit', 'journals.reference', 'fonctions.libelle')
                       ->simplePaginate(100)
                       ->appends(request()->all());
            
              }else {
                $journals = collect();
            }
          
          

          //dd($journals);

        return view('pages.journals.index', compact('compteComptables', 'journals', 'affichage', 'title'));
    }

    public function JournalSearchPeriode(Request $request)
    {

        if (! Gate::allows('is-comptable')) {
            return view('errors.403');
        }

        $title = 'Journal';
        $periode = $request->periode;
        $compteComptables = Compte_comptable::all();

        $operations = DB::table('journals');
          //->join('users', 'users.id', '=', 'journals.user_id')
          //->join('agences', 'agences.id', '=', 'users.agence_id');

        $affichage = $request->affichage;

        if ( $periode == "day" ) {

              $NomPeriode = "d'Ajourd'hui";
              $date = date('Y-m-d');
              //$journals = $operations->Where('date', $date)
              //->orderBy('journals.id', 'DESC')->paginate(50);

              $journals = Cache::remember('journals_'.$date, 60, function () use ($date) {
                return Journal::Join('fonctions', 'fonctions.code_fonction', '=', 'journals.fonction')->where('journals.date', $date)
                   ->orderBy('journals.id', 'DESC')
                   ->paginate(50)
                   ->appends(request()->all());
               });


          }else if( $periode == "month" ){

              $NomPeriode = "du Mois";
              //$date = date('Y-m-d');
              $debut = date('Y').'-'.date('m').'-01';    
              $fin = date('Y').'-'.date('m').'-31';    
              //$journals = $operations->whereBetween('date', [$debut, $fin])
              //->orderBy('journals.id', 'DESC')->paginate(50);

              $journals = Cache::remember('journals_'.$debut.'_'.$fin, 60, function () use ($debut, $fin) {
                return Journal::Join('fonctions', 'fonctions.code_fonction', '=', 'journals.fonction')->whereBetween('journals.date', [$debut, $fin])
                   ->orderBy('journals.id', 'DESC')
                   ->paginate(50)
                   ->appends(request()->all());
               });

          }else{

              $NomPeriode = "de la Semaine";
              $date = date('Y-m-d');
              $debut = date('Y-m-d', strtotime($date.'-7 days'));

              //dd($debut, $date);
              //$journals = $operations->whereBetween('date', [$debut, $date])
              //->orderBy('journals.id', 'DESC')->paginate(50);

                $journals = Cache::remember('journals_'.$debut.'_'.$date, 60, function () use ($debut, $date) {
                return Journal::Join('fonctions', 'fonctions.code_fonction', '=', 'journals.fonction')->whereBetween('journals.date', [$debut, $date])
                   ->orderBy('journals.id', 'DESC')
                   ->paginate(50)
                   ->appends(request()->all());
               });
          }

        return view('pages.journals.index')
        ->with('compteComptables', $compteComptables)
        ->with('periode', $periode)
        ->with('journals', $journals)
        ->with('affichage', $affichage)
        ->with('title', $title);
    }
    /**FIN JOURNAL**/


    /**BALANCE**/
    public function balance()
    {
        // code...
        $title = 'Balance';

        return view('pages.balances.index')
        ->with('title', $title);
    }

    public function balancePeriode(Request $request)
    {
        // code...
        $title = 'Balance par période';

        $periode = $request->periode;
        $compteComptables = Compte_comptable::all();

        return view('pages.balances.resultat_balance')
        ->with('compteComptables', $compteComptables)
        ->with('periode', $periode)
        ->with('title', $title);
    }

    public function balanceDateIntervalle(Request $request)
    {
        // code...
        $title = 'Balance par intervalle de date';

        $dateDebut = trim($request->date_debut);
        $dateFin = trim($request->date_fin);

        $compteComptables = Compte_comptable::all();

        return view('pages.balances.resultat_balance')
        ->with('compteComptables', $compteComptables)
        ->with('dateDebut', $dateDebut)
        ->with('dateFin', $dateFin)
        ->with('title', $title);
    }
    /**FIN BALANCE**/


    /**ECRITURE COMPTABLE**/
    public function EcritureMannuelle()
    {
        // code...

        $title = 'Ecritures manuelles';
        $compteComptables = Compte_comptable::all();
        $agences = Agence::all();
        $clients = Client::all();
        $guichetiers = User::Where('role_id', 4)->get();

        return view('pages.ecriture_mannuelles.index')
        ->with('compteComptables', $compteComptables)
        ->with('agences', $agences)
        ->with('clients', $clients)
        ->with('guichetiers', $guichetiers)
        ->with('title', $title);
    }

    public function EcritureMannuelleSave(Request $request)
    {

        $libelle = $request->libelle;
        $nombre = $request->nombre;

        $date = $request->date;
        //$date = date_create($date);
        //$date = date_format($date, 'd/m/Y');

        $libelle = $request->nombre;
        

        $piece = mt_rand(1111111, 999999999);
        $pieceExist = Journal::Where('numero_piece', $piece)->first();

        while($pieceExist){
            $piece = mt_rand(1111111, 999999999);
            $pieceExist = Journal::Where('numero_piece', $piece)->first();
        }


        for ($i = 0; $i < $nombre; $i++) {
            
                $compteSelect = Compte_comptable::where('numero', $request->input('compte.'.$i))->first();

                if ( !is_null($request->input('debit.'.$i)) && $request->input('debit.'.$i) != '') {
                      Journal::create([
                        'date' => $date,
                        'numero_piece' => $piece,
                        'fonction' => 'Batch',
                        'reference' => "REF-ECRMAN-" .$piece. date("Ymd"),
                        'description' => $request->libelle,
                        'compte' => $request->input('compte.'.$i),
                        'intitule' => $compteSelect->libelle,
                        'debit' => $request->input('debit.'.$i),
                    ]);  
                }else{
                    Journal::create([
                        'date' => $date,
                        'numero_piece' => $piece,
                        'compte' => $request->input('compte.'.$i),
                        'intitule' => $compteSelect->libelle,
                        'credit' => $request->input('credit.'.$i),
                    ]);  
                }
                
                

        }

        $request->session()->flash('msg_success', 'Votre opération a été crée avec succès !');
        return back();
    }
    /**FIN ECRITURE COMPTABLE**/


    /**BILLETS**/

        public function billets()
        {
            $title = "Listes des billets";
            $billets = Billet::OrderBy('montant', 'ASC')->get();
            return view('pages.billets.index')
            ->with('billets', $billets)
            ->with('title', $title);
        }

        public function billetsCreate(Request $request)
        {
            
            $title = "Listes des billets";

            if ( !isset($request->montant) || empty($request->montant) ) {
                $request->session()->flash('msg_error', 'Vous devez saisir le montant du billet');

                }else{

                    Billet::create([
                    'montant' => $request->montant,
                    ]);

                    $request->session()->flash('msg_success', 'Vous avez ajouté un billet avec succès!');
                
                }

            return back();
        }

        
        public function billetsEdit($id)
        {
            $title = "Modifier cet billet";
            $billet = Billet::Where('id', $id)->first();

            $billets = Billet::latest()->get();
            return view('pages.billets.edit')
            ->with('billet', $billet)
            ->with('billets', $billets)
            ->with('title', $title);
        }

        public function billetsEditValid(Request $request)
        {
            
            $title = "Listes des billets";

            if ( !isset($request->montant) || empty($request->montant) ) {
                $request->session()->flash('msg_error', 'Vous devez saisir le montant du billet');
            }else{
                Billet::Where('id', $request->billet_id)
                ->update([
                    'montant' => $request->montant,
                ]);

                $request->session()->flash('msg_success', 'Vous avez modifié cet billet avec succès!');
            }

            return back();
        }

        public function billetsDel(Request $request)
        {
            
            Billet::findOrFail($request->id)->delete();
            $request->session()->flash('msg_error', 'Vous avez supprimé cet billets avec succès!');

            return back();
        }


    /**FIN BILLETS**/


    /* REGLAGE SYSTEME */
    

    /**TYPES CREDITS**/

        public function types_credits()
        {
            $title = "Listes des types de crédits";
            $types_credits = Type_credits::OrderBy('name', 'ASC')->get();
            return view('pages.users.reglage_systeme.types_credits.index')
            ->with('types_credits', $types_credits)
            ->with('title', $title);
        }

        public function TypesCreditsCreate()
        {
            $title = "Créer un type de crédit";
            return view('pages.users.reglage_systeme.types_credits.create')
            ->with('title', $title);
        }

        public function TypesCreditsCreateValid(Request $request)
        {
            
            $title = "Listes des types de crédits";

            if ( !isset($request->name) || empty($request->name) ) {
                $request->session()->flash('msg_error', 'Vous devez saisir le nom du type de crédit');

                }else{

                    Type_credits::create([
                        'name' => $request->name,
                        'taux' => $request->taux,
                        'mnt_min' => $request->montant_min,
                        'mnt_max' => $request->montant_max,
                        'duree_min_mois' => $request->duree_mois_min,
                        'duree_max_mois' => $request->duree_mois_max,
                        'periodicite' => $request->periodicite,
                        'mnt_frais' => $request->montant_frais,
                        'mnt_commission' => $request->montant_commission,
                        'mnt_assurance' => $request->montant_assurance,
                        'prc_commission' => $request->pourcentage_commission,
                        'prc_assurance' => $request->pourcentage_assurance,
                        'delai_grace_jour' => $request->delai_grace_jour,
                        'differe_jours_max' => $request->differe_jour_max,
                    ]);


                    $request->session()->flash('msg_success', 'Vous avez ajouté un type de crédit avec succès!');
                
                }

            return back();
        }

        
        public function TypesCreditsEdit($id)
        {
            $title = "Modifier cet type de crédit";
            $types_credit = Type_credits::Where('id', $id)->first();

            $types_credits = Type_credits::latest()->get();
            return view('pages.users.reglage_systeme.types_credits.edit')
            ->with('types_credit', $types_credit)
            ->with('types_credits', $types_credits)
            ->with('title', $title);
        }

        public function TypesCreditsEditValid(Request $request)
        {
            
            $title = "Listes des billets";

            if ( !isset($request->name) || empty($request->name) ) {
                $request->session()->flash('msg_error', 'Vous devez saisir le nom du type de crédit');
            }else{
                Type_credits::Where('id', $request->types_credit_id)
                ->update([
                    'name' => $request->name,
                    'taux' => $request->taux,
                    'mnt_min' => $request->montant_min,
                    'mnt_max' => $request->montant_max,
                    'duree_min_mois' => $request->duree_mois_min,
                    'duree_max_mois' => $request->duree_mois_max,
                    'periodicite' => $request->periodicite,
                    'mnt_frais' => $request->montant_frais,
                    'mnt_commission' => $request->montant_commission,
                    'mnt_assurance' => $request->montant_assurance,
                    'prc_commission' => $request->pourcentage_commission,
                    'prc_assurance' => $request->pourcentage_assurance,
                    'delai_grace_jour' => $request->delai_grace_jour,
                    'differe_jours_max' => $request->differe_jour_max,
                ]);

                $request->session()->flash('msg_success', 'Vous avez modifié cet type de crédit avec succès!');
            }

            return back();
        }

        public function TypesCreditsDel(Request $request)
        {
            
            Type_credits::findOrFail($request->id)->delete();
            $request->session()->flash('msg_error', 'Vous avez supprimé cet type de crédit avec succès!');

            return back();
        }


        /**FIN TYPES CREDITS**/


        /*CHANGE-PASSWORD*/



            public function ChangeAutreMotPasse()
            {
                // Récupérer la liste des utilisateurs depuis la base de données
                $users = User::all();
                
                return view('pages.users.reglage_systeme.change_password', compact('users'));
            }

            public function UpdatePassword(Request $request)
            {               

                $user = User::find($request->selected_user);

                if ($user) {

                    $user->password = Hash::make($request->new_password);
                    $user->save();

                    $request->session()->flash('msg', 'Le mot de passe a été changé avec succès!');


                } else {
                    $request->session()->flash('msg_error', 'Utilisateur non trouvé!');
                }

                return back();
            }


        /*FIN CHANGE-PASSWORD*/

        public function AddFraisDossier()
        {
            return view('pages.users.reglage_systeme.ajout_frais_dossier');
        }

        public function AddFraisDossierValid(Request $request)
        {
            $request->validate([
                'amount' => 'required|numeric',
            ]);


            DB::table('frais-dossier')->insert([
                'amount' => $request->input('amount'),
            ]);

            $request->session()->flash('msg', 'Frais de dossier ajouté avec succès');

            return back();
        }


        public function TypeCreditUpdate()
        {
            return view('pages.users.reglage_systeme.change_type_credit');
        }


    /**FIN REGLAGE SYSTEME **/


    /* TAUX */


        public function taux()
        {
            $taux = Taux::latest()->get();
            return view('pages.taux.index')
            ->with('taux', $taux);
        }

        public function TauxCreate()
        {

            return view('pages.taux.create');
            
        }

        public function TauxCreateValid(Request $request)
        {
            
            if (!$request->filled('taux_commission') && !$request->filled('taux_interet') && !$request->filled('taux_assurance') && !$request->filled('frais_de_dossier')) {

                return back()->with('msg_error', 'Au moins un champ doit être saisi.');

            }else{

                $taux = new Taux;

                $taux->taux_commission = $request->input('taux_commission');
                $taux->taux_interet = $request->input('taux_interet');
                $taux->taux_assurance = $request->input('taux_assurance');
                $taux->frais_de_dossier = $request->input('frais_de_dossier');

                $taux->save();

                return back()->with('msg_success', 'Taux créé avec succès!');
            }
        }

        
        public function TauxEdit($id)
        {
            $taux = Taux::Where('id', $id)->first();

            return view('pages.taux.edit')
            ->with('taux', $taux);
        }

        public function TauxEditValid(Request $request)
        {

            if (!$request->filled('taux_commission') && !$request->filled('taux_interet') && !$request->filled('taux_assurance') && !$request->filled('frais_de_dossier')) {
                return back()->with('msg_error', 'Au moins un champ doit être saisi.');
            }else{

                    $taux = Taux::find($request->input('taux_id'));

                    $taux->taux_commission = $request->input('taux_commission');
                    $taux->taux_interet = $request->input('taux_interet');
                    $taux->taux_assurance = $request->input('taux_assurance');
                    $taux->frais_de_dossier = $request->input('frais_de_dossier');

                    $taux->save();

                    return back()->with('msg_success', 'Taux modifié avec succès!');
            }

                
        }

        public function TauxDel(Request $request)
        {
            
            Taux::findOrFail($request->id)->delete();
            $request->session()->flash('msg_error', 'Vous avez supprimé cet taux avec succès!');

            return back();
        }


    /* FIN TAUX */

    /**TYPE BIENS ET OBJECT DEMANDE**/

        public function type_biens_objet_demande()
        {
            $title = "Listes des types biens et objet de demande";
            $type_biens = Type_biens::OrderBy('libelle', 'ASC')->get();
            $objet_demandes = Objet_demandes::OrderBy('libelle', 'ASC')->get();
            return view('pages.biens-demande.index')
            ->with('type_biens', $type_biens)
            ->with('objet_demandes', $objet_demandes)
            ->with('title', $title);
        }

        public function type_biensCreate(Request $request)
        {
            
            $title = "Listes des types biens";

            if ( !isset($request->libelle) || empty($request->libelle) ) {
                $request->session()->flash('msg_error', 'Vous devez saisir le libelle du type de bien');

                }else{

                    Type_biens::create([
                    'libelle' => $request->libelle,
                    'description' => $request->description,
                    ]);

                    $request->session()->flash('msg_success', 'Vous avez ajouté un type de bien avec succès!');
                
                }

            return back();
        }

        
        public function type_biensEdit($id)
        {
            $title = "Modifier cet billet";
            $type_bien = Type_biens::Where('id', $id)->first();

            $type_biens = Type_biens::latest()->get();
            return view('pages.biens-demande.edit')
            ->with('type_bien', $type_bien)
            ->with('type_biens', $type_biens)
            ->with('title', $title);
        }

        public function type_biensEditValid(Request $request)
        {
            
            $title = "Listes des types biens";

            if ( !isset($request->libelle) || empty($request->libelle) ) {
                $request->session()->flash('msg_error', 'Vous devez saisir le libelle du type de bien');
            }else{
                Type_biens::Where('id', $request->type_bien_id)
                ->update([
                    'libelle' => $request->libelle,
                    'description' => $request->description,
                ]);

                $request->session()->flash('msg_success', 'Vous avez modifié cet type de bien avec succès!');
            }

            return back();
        }

        public function type_biensDel(Request $request)
        {
            
            Type_biens::findOrFail($request->id)->delete();
            $request->session()->flash('msg_error', 'Vous avez supprimé cet type de bien avec succès!');

            return back();
        }

        //

        public function objet_demandeCreate(Request $request)
        {
            
            $title = "Listes des objets de demandes";

            if ( !isset($request->libelle) || empty($request->libelle) ) {
                $request->session()->flash('msg_error_objet', 'Vous devez saisir le libelle de l\'objet de demande');

                }else{

                    Objet_demandes::create([
                    'libelle' => $request->libelle,
                    'description' => $request->description,
                    ]);

                    $request->session()->flash('msg_success_objet', 'Vous avez ajouté un objet de demande avec succès!');
                
                }

            return back();
        }

        
        public function objet_demandeEdit($id)
        {
            $title = "Modifier cet d'objet de demandes";
            $objet_demande = Objet_demandes::Where('id', $id)->first();

            $objet_demandes = Objet_demandes::latest()->get();
            return view('pages.biens-demande.edit_demande')
            ->with('objet_demande', $objet_demande)
            ->with('objet_demandes', $objet_demandes)
            ->with('title', $title);
        }

        public function objet_demandeEditValid(Request $request)
        {
            
            $title = "Listes des objets de demandes";

            if ( !isset($request->libelle) || empty($request->libelle) ) {
                $request->session()->flash('msg_error_objet', 'Vous devez saisir le libelle de l\'objet de demande');
            }else{
                Objet_demandes::Where('id', $request->objet_demande_id)
                ->update([
                    'libelle' => $request->libelle,
                    'description' => $request->description,
                ]);

                $request->session()->flash('msg_success_objet', 'Vous avez modifié cet d\'objet de demande avec succès!');
            }

            return back();
        }

        public function objet_demandeDel(Request $request)
        {
            
            Objet_demandes::findOrFail($request->id)->delete();
            $request->session()->flash('msg_error_objet', 'Vous avez supprimé cet d\'objet de demande avec succès!');

            return back();
        }



    /**FIN TYPE BIENS ET OBJECT DEMANDE**/

    /* ETAT CREDIT */


        public function etat_credit()
        {
            $etat_credit = Etat_credits::latest()->get();
            return view('pages.etat_credit.index')
            ->with('etat_credit', $etat_credit);
        }

        public function EtatCreditCreate()
        {
            return view('pages.etat_credit.create');
        }

        public function EtatCreditCreateValid(Request $request)
        {
            
            if ( !isset($request->libelle) || empty($request->libelle) ) {
                $request->session()->flash('msg_error', 'Vous devez saisir le libelle de l\'état du crédit');

            }else{

                $etat_credit = new Etat_credits;

                $etat_credit->libelle = $request->input('libelle');
                $etat_credit->nbre_jours = $request->input('nbre_jours');
                $etat_credit->id_ag = Auth::user()->agence_id;
                $etat_credit->provisionne = $request->input('provisionne');
                $etat_credit->taux = $request->input('taux');
                $etat_credit->taux_prov_decouvert = $request->input('taux_prov_decouvert');
                $etat_credit->taux_prov_reechelonne = $request->input('taux_prov_reechelonne');

                $etat_credit->save();

               $request->session()->flash('msg_success', 'Etat credit créé avec succès!');
            }

            return back();
        }

        
        public function EtatCreditEdit($id)
        {
            $etat_credit = Etat_credits::Where('id', $id)->first();

            return view('pages.etat_credit.edit')
            ->with('etat_credit', $etat_credit);
        }

        public function EtatCreditEditValid(Request $request)
        {


            if ( !isset($request->libelle) || empty($request->libelle) ) {
                $request->session()->flash('msg_error', 'Vous devez saisir le libelle de l\'état du crédit');

            }else{

                Etat_credits::Where('id', $request->etat_credit_id)
                ->update([
                    'libelle' => $request->libelle,
                    'nbre_jours' => $request->nbre_jours,
                    'id_etat_prec' => $request->id_etat_prec,
                    'id_ag' => Auth::user()->agence_id,
                    'provisionne' => $request->provisionne,
                    'taux_prov_reechelonne' => $request->taux_prov_reechelonne,
                    'taux' => $request->taux,
                    'taux_prov_decouvert' => $request->taux_prov_decouvert,
                ]);

                    $request->session()->flash('msg_success', 'Etat de credit modifié avec succès!');
            }

            return back();

                
        }

        public function EtatCreditDel(Request $request)
        {
            
            Etat_credits::findOrFail($request->id)->delete();
            $request->session()->flash('msg_error', 'Vous avez supprimé cet état de crédit avec succès!');

            return back();
        }


    /* FIN ETAT CREDIT */

    /** GESTON DES PLAFLONDS **/


        public function plafonds()
        {
            $plafonds = Plafonds::join('type_operations', 'type_operations.id', '=', 'plafonds.type_operation')
            ->select('plafonds.*', 'type_operations.name')
            ->get();
            return view('pages.plafonds.index')
            ->with('plafonds', $plafonds);
        }

        public function PlafondCreate()
        {
            $type_operations = Type_operation::latest()->get();
            return view('pages.plafonds.create')
            ->with('type_operations', $type_operations);
        }

        public function PlafondCreateValid(Request $request)
        {
            
            if ( !isset($request->type_operation) || empty($request->type_operation) ) {
                $request->session()->flash('msg_error', 'Vous devez saisir le type d\'operation');

            }else{

                $plafonds = new Plafonds;

                $plafonds->type_operation = $request->input('type_operation');
                $plafonds->montant_min = $request->input('montant_min');
                $plafonds->montant_max = $request->input('montant_max');

                $plafonds->save();

               $request->session()->flash('msg_success', 'Plafond créé avec succès!');
            }

            return back();
        }

        
        public function PlafondEdit($id)
        {
            $plafonds = Plafonds::Where('id', $id)->first();
            $type_operations = Type_operation::first()->get();

            return view('pages.plafonds.edit')
            ->with('plafonds', $plafonds)
            ->with('type_operations', $type_operations);
        }

        public function PlafondEditValid(Request $request)
        {

            if ( !isset($request->type_operation) || empty($request->type_operation) ) {
                $request->session()->flash('msg_error', 'Vous devez saisir le type d\'operation');

            }else{

                Plafonds::Where('id', $request->plafonds_id)
                ->update([
                    'type_operation' => $request->type_operation,
                    'montant_min' => $request->montant_min,
                    'montant_max' => $request->montant_max,
                ]);

                    $request->session()->flash('msg_success', 'Plafonds modifié avec succès!');
            }

            return back();

                
        }

        public function PlafondDel(Request $request)
        {
            
            Plafonds::findOrFail($request->id)->delete();
            $request->session()->flash('msg_error', 'Vous avez supprimé cet plafond avec succès!');

            return back();
        }


    /**FIN GESTON DES PLAFLONDS **/

    /**BANQUES EXTERNES**/

        public function banquexternes()
        {
            $title = "Listes des banques externes";
            $banquexternes = Banquexternes::OrderBy('name', 'ASC')->get();
            return view('pages.banquexternes.index')
            ->with('banquexternes', $banquexternes)
            ->with('title', $title);
        }

        public function BanquexternesCreate()
        {
            $title = "Créer une banque externe";

            $compte_comptable = DB::table('compte_comptables')
                ->select('compte_comptables.*')
                ->get();

            return view('pages.banquexternes.create', compact('title', 'compte_comptable'));

        }

        public function BanquexternesCreateValid(Request $request)
        {
            
            $title = "Listes des types de crédits";

            if ( !isset($request->name) || empty($request->name) ) {
                $request->session()->flash('msg_error', 'Vous devez saisir le nom de la banque');

                }else{

                    Banquexternes::create([
                        'name' => $request->name,
                        'adresse' => $request->adresse,
                        'pays' => $request->pays,
                        'montant' => $request->montant,
                        'compte_comptable_id' => $request->compte_comptable_id,
                        ]);


                    $request->session()->flash('msg_success', 'Vous avez ajouté une banque externe avec succès!');
                
                }

            return back();
        }

        
        public function BanquexternesEdit($id)
        {
            $title = "Modifier cette banque externe";
            $banquexternes = Banquexternes::Where('id', $id)->first();

            $compte_comptable = DB::table('compte_comptables')
                ->select('compte_comptables.*')
                ->get();
            return view('pages.banquexternes.edit')
            ->with('banquexternes', $banquexternes)
            ->with('compte_comptable', $compte_comptable)
            ->with('title', $title);
        }

        public function BanquexternesEditValid(Request $request)
        {
            
            $title = "Listes des banques externes";

            if ( !isset($request->name) || empty($request->name) ) {
                $request->session()->flash('msg_error', 'Vous devez saisir le nom de la banque externe');
            }else{
                Banquexternes::Where('id', $request->banquexternes_id)
                ->update([
                    'name' => $request->name,
                    'adresse' => $request->adresse,
                    'pays' => $request->pays,
                    'montant' => $request->montant,
                    'compte_comptable_id' => $request->compte_comptable_id,
                ]);

                $request->session()->flash('msg_success', 'Vous avez modifié cette banque externe avec succès!');
            }

            return back();
        }

        public function BanquexternesDel(Request $request)
        {
            
            Banquexternes::findOrFail($request->id)->delete();
            $request->session()->flash('msg_error', 'Vous avez supprimé cette banque externe avec succès!');

            return back();
        }


        /**FIN BANQUES EXTERNES**/
}
