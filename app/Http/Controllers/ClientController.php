<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Devise;
use App\Models\Analyse;
use App\Models\Type_account;
use App\Models\Account;
use App\Models\Chequier;
use App\Models\Monnaie_billet;
use App\Models\Agence;
use App\Models\Operation;
use App\Models\Billet;
use App\Models\Mouvement;
use App\Models\Caisse;
use App\Models\Type_operation;
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
use App\Models\TypeCredit;
use App\Models\Commandes;
use App\Models\Suspension;
use App\Models\DemandeCredit;
use App\Models\CodePin;
use App\Models\User;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Dompdf\Dompdf;


use Auth;

use DB;



class ClientController extends Controller

{

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('auth:client');

    }



    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Contracts\Support\Renderable

     */

    public function index()
    {

        $soldeClient = Account::Where('client_id', Auth::user()->id)
        ->first();
        return view('pages.clients.dashboard')
        ->with('soldeClient', $soldeClient);

    }

    public function versements()
    {

        $title = "Mes versements";

        //dd(Auth::user()->id);

        $versements = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->Where('clients.id', Auth::user()->id)
        ->Where('operations.statut', 'valide')
        ->Where('operations.type_operation_id', 3)
        ->OrderBy('operations.id', 'DESC')
        ->get();
        
        //dd($versements);

        return view('pages.clients.versements')
        ->with('versements', $versements)
        ->with('title', $title);

    }



    public function retraits()
    {

        $title = "Mes retraits";

        $retraits = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->Where('clients.id', Auth::user()->id)
        ->Where('operations.type_operation_id', 2)
        ->OrderBy('operations.id', 'DESC')
        ->get();

        return view('pages.clients.retraits')
        ->with('retraits', $retraits)
        ->with('title', $title);

    }

    public function virements()
    {

        $title = "Mes virements";

        $virements = Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
        ->join('clients', 'clients.id', '=', 'accounts.client_id')
        ->select('operations.*')
        ->Where('clients.id', Auth::user()->id)
        ->Where('operations.type_operation_id', 1)
        ->OrderBy('operations.id', 'DESC')
        ->get();

        return view('pages.clients.virements')
        ->with('virements', $virements)
        ->with('title', $title);

    }

    public function virementNew()
    {
        $title = "Faire un retrait"; 
        $soldeClient = Account::Where('client_id', Auth::user()->id)
        ->first();

        return view('pages.clients.new_virement_1')
        ->with('soldeClient', $soldeClient)
        ->with('title', $title);
    }


    public function virementSearch(Request $request)
    {
        
        $title = "Faire un retrait";

        if ( !isset( $request->flash ) || empty($request->flash) ) {
            
            $request->session()->flash('msg_error', 'Vous devez saisir le numéro de compte du destinataire');

        }else{

            $data = DB::table('clients')->join('accounts', 'accounts.client_id', '=', 'clients.id')
            ->join('type_accounts', 'type_accounts.id', '=', 'accounts.type_account_id')
            ->Where('accounts.number_account', $request->flash)
            ->first();

            if ( $data ) {

                $soldeClient = Account::Where('client_id', Auth::user()->id)
                ->first();

                return view('pages.clients.new_virement_2')
                ->with('soldeClient', $soldeClient)
                ->with('data', $data)
                ->with('title', $title);
            }else{
                $request->session()->flash('msg_error', 'Nous ne trouvons pas de destinataire associé à ce compte!');
                return back()
                ->with('title', $title);
            }

        }
    }

    public function virementValid(Request $request)
    {
        $title = 'Faire un virement';

        //dd(Auth::user()->id);
        $init = "REF-VIR-";
        $rand = rand(111111, 999999);
        $date = date("Ymd");

        $code = $init.$rand.$date;

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
            'expediteur_virement_id' => Auth::user()->id,
        ]);


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

        $request->session()->flash('msg_success', 'Virement passé avec succès !');

        return redirect()->route('client-virements-success', strtolower($code));

    }

    public function virementSuccess($ref)
    {
        $ref = $ref;


        return view('pages.clients.virement_success')
        ->with('ref', $ref);
    }


    public function virementPrint($ref)
    {
        
        $title = "Imprimer recu";

        $detect_user_id = Operation::Where('ref', strtoupper($ref))->first();

        if( $detect_user_id->user_id == null ){
            
            $data = [
                'logo' => 'assets/images/logo/hopeFund.png',
                'v' => Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
                    ->join('clients', 'clients.id', '=', 'accounts.client_id')
                    ->select('operations.*', 'clients.nom', 'clients.prenom')
                    ->Where('clients.id', Auth::user()->id)
                    ->Where('operations.type_operation_id', 1)
                    ->Where('operations.ref', strtoupper($ref))
                    ->OrderBy('operations.id', 'DESC')
                    ->first()
            ];  

        }else{

            $data = [
                    
                    'logo' => 'assets/images/logo/hopeFund.png',
                    'v' => Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
                        ->join('clients', 'clients.id', '=', 'accounts.client_id')
                        ->join('users', 'users.id', '=', 'operations.user_id')
                        ->join('agences', 'agences.id', '=', 'users.agence_id')
                        ->select('operations.*', 'clients.nom', 'clients.prenom', 'agences.name as nom_agence', 'users.matricule')
                        ->Where('clients.id', Auth::user()->id)
                        ->Where('operations.type_operation_id', 1)
                        ->Where('operations.ref', strtoupper($ref))
                        ->OrderBy('operations.id', 'DESC')
                        ->first()
                ];
        }

        
        //dd($data);
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.clients.print._virement', $data)->render();

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


    public function versementPrint($ref)
    {
        $data = [
            
            'logo' => 'assets/images/logo/hopeFund.png',
            'v' => Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
                ->join('clients', 'clients.id', '=', 'accounts.client_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->join('agences', 'agences.id', '=', 'users.agence_id')
                ->select('operations.*', 'clients.nom', 'clients.prenom', 'agences.name as nom_agence', 'users.matricule')
                ->Where('clients.id', Auth::user()->id)
                ->Where('operations.type_operation_id', 3)
                ->Where('operations.ref', strtoupper($ref))
                ->OrderBy('operations.id', 'DESC')
                ->first()
        ];
        
        //dd($data);
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.clients.print._versement', $data)->render();

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


    public function retraitPrint($ref)
    {
        
        $data = [
            
            'logo' => 'assets/images/logo/hopeFund.png',
            'v' => Operation::leftjoin('accounts', 'accounts.number_account', '=', 'operations.account_id')
                ->join('clients', 'clients.id', '=', 'accounts.client_id')
                ->join('users', 'users.id', '=', 'operations.user_id')
                ->join('agences', 'agences.id', '=', 'users.agence_id')
                ->select('operations.*', 'clients.nom', 'clients.prenom', 'agences.name as nom_agence', 'users.matricule')
                ->Where('clients.id', Auth::user()->id)
                ->Where('operations.type_operation_id', 2)
                ->Where('operations.ref', strtoupper($ref))
                ->OrderBy('operations.id', 'DESC')
                ->first()
        ];
        
        //dd($data);
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Récupérer la vue à convertir en PDF
        $html = view('pages.clients.print._retrait', $data)->render();

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


    public function analyse(){
        
        return view('pages.clients.analyse.index');
    }

    public function CreateAnalyse()
    {
        return view('pages.clients.analyse.create');
    }

    public function mon_compte(){
        
        return view('pages.clients.profil.mon_compte');
    }
    public function CreateAnalyseValid()
    {
        
    }

    public function profil(){
        
        $client = Client::first()->get();
        return view('pages.clients.profil.index')
        ->with('client', $client);

        // $user = Auth::user();
        // return view('profile', ['user' => $user]);
    }

     public function editProfilValide(Request $request) {

            $values = array(

                // page 1
                "nom" => trim($request->nom),
                "prenom" => trim($request->prenom),
                "raison_social" => trim($request->raison_social),
                "nom_association" => trim($request->nom_association),
                "nombre_membres" => trim($request->nombre_membres),
                "nationalite" => trim($request->nationalite),
                "cni_client" => trim($request->cni_client),
                "date_naissance" => trim($request->date_naissance),
                "lieu_naissance" => trim($request->lieu_naissance),
                "etat_civil" => trim($request->etat_civil),

                // page 2
                "profession" => trim($request->profession),
                "employeur" => trim($request->employeur),
                "lieu_activite" => trim($request->lieu_activite),
                "quartier" => trim($request->quartier),
                "telephone" => trim($request->telephone),
                "commune" => trim($request->commune),
                "adresse" => trim($request->adresse),
                "ville" => trim($request->ville),
                "residence" => trim($request->residence),
                "nom_conjoint" => trim($request->nom_conjoint),
                "nom_heritier1" => trim($request->nom_heritier1),
                "nom_heritier2" => trim($request->nom_heritier2),
                "nom_heritier3" => trim($request->nom_heritier3),

            );

            $client = Client::find($id);
            $client->update($values);


            //dd($values);

            $request->session()->flash('msg', 'Le compte a été modifié avec succès!');
            return back();
    }



    public function CompteHopefund()
    {
        return view('pages.clients.virements.virements_compte_hope_fhund');
    }

    public function NumeroMobileMoney()
    {
        return view('pages.clients.virements.virements_mobile_money');
    }

    public function EffectuerPaiement()
    {

        return view('pages.clients.paiements.effectuer_paiement');
    }

    public function EffectuerPaiementValid(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'beneficiaire' => 'required|string',
        ]);

        DB::table('effectuer_paiement')->insert([
            'amount' => $validatedData['amount'],
            'beneficiaire' => $validatedData['beneficiaire'],
        ]);


        return redirect()->back()->with('msg_success', 'Paiement demandé avec succès');
    }


    public function DemanderPaiement()
    {
        return view('pages.clients.paiements.demander_paiement');
    }

    public function DemanderPaiementValid(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string',
        ]);

        DB::table('demande_paiement')->insert([
            'amount' => $validatedData['amount'],
            'description' => $validatedData['description'],
        ]);


        return redirect()->back()->with('msg_success', 'Paiement demandé avec succès');
    }

    public function client_credit()
    {
        $typeCredits = DB::table('type_credits')->whereIn('id', [18, 19])->get();
        return view('pages.clients.gestioncompte.clientDemande_credit', ['typeCredits' => $typeCredits]);
    }

    public function submitClientCreditForm(Request $request)
    {
        $request->validate([
            'montant_demande' => 'required',
            'raison_demande' => 'required|string',
            'type_credit' => 'required|', 
           // 'doc_demande' => 'required|file|mimes:pdf,doc,docx',
        ]);

        // Traitement de l'upload du fichier (si nécessaire)
        //$docPath = $request->file('doc_demande')->store('docs');

        // Enregistrement dans la base de données
        Demande_credit::create([
            //'client_id' =>
            'montant_demande' => $request->montant_demande,
            'raison_demande' => $request->raison_demande,
            'type_credit' => $request->type_credit,
            'doc_demande' => $request->doc_demande,
            'statut' => 'sent',
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'La demande de crédit a été soumise avec succès.');
    }

    public function client_chequier()
    {
        return view('pages.clients.gestioncompte.demande_chequier');
    }

    public function SubmitClientChequier(Request $request)
    {
        // Validation des données du formulaire
        $validation = $request->validate([
            'type_chequier' => 'required|string',
            'adresse_livraison' => 'required|string',
            'motif_demande' => 'required|string',
        ]);

        // Enregistrement dans la base de données
        if ($validation) {
            DB::table('demande_chequiers')->insert([
                'type_chequier' => $request->type_chequier,
                'adresse_livraison' => $request->adresse_livraison,
                'motif_demande' => $request->motif_demande,
            ]);

            return redirect()->back()->with('msg_success', 'Votre demande de chéquier a été soumise avec succès.');
        } else {
            return redirect()->back()->withErrors($validation)->withInput();
        }
    }

     public function client_relevecompe()
    {
        return view('pages.clients.gestioncompte.releve_compte');
    }


    //fin gestion compte 


    //debut ma carte 

     public function affichecodeqr()
    {
        return view('pages.clients.macartehfb.affichercode_qr');
    }

     public function codepin()
    {
        return view('pages.clients.macartehfb.code_pin');
    }

    public function submitCodePinForm(Request $request)
    {
        // Validation des données du formulaire
        $validation = $request->validate([
            //'ancien_codepin' => 'required|string',
            'nouveau_codepin' => 'required|string',
            'confirmer_codepin' => 'required|string|same:nouveau_codepin',
        ], [
            'confirmer_codepin.same' => 'Les champs du nouveau Code PIN doivent correspondre.',
        ]);

        // Enregistrement dans la base de données
        if ($validation) {
            CodePin::create(['nouveau_codepin' => $request->nouveau_codepin]);
            return redirect()->back()->with('success', 'Le changement de code PIN a été enregistré avec succès.');
        } else {
            return redirect()->route('codepin')->withErrors($validation)->withInput();
        }
    }


    // debut commande de carte 
        public function CommandeCarte()
        {
            return view('pages.clients.macartehfb.commander_carte');
        }

        public function SubmitCommandeForm(Request $request)
        {
            // Validation des données du formulaire
            $request->validate([
                'prix' => 'required',
            ]);

            // Enregistrement dans la base de données
            Commandes::create($request->all());

            // Redirection avec un message de succès
            return redirect()->back()->with('success', 'Votre commande a été enregistrée avec succès.');
        }

        public function annulercarte()
        {
            return view('pages.clients.macartehfb.suspendre_annulercarte');
        }

        public function submitAnnulationForm(Request $request)
        {
            // Validation des données du formulaire
            $request->validate([
                'numero_carte' => 'required|string',
                'raison' => 'required|string',
            ]);

            // Enregistrement dans la base de données
            Suspension::create($request->all());

            // Redirection avec un message de succès
            return redirect()->back()->with('success', 'La suspension a été enregistrée avec succès.');
        }


    // fin carte 

    // CONTACTEZ-NOUS

        public function contact()
        {
            return view('pages.clients.contactez_nous');
        }


        public function SubmitContactForm(Request $request)
        {
            // Validation des données du formulaire
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'message' => 'required|string',
            ]);

            // Enregistrement dans la base de données
            Contact::create($request->all());

            // Redirection avec un message de succès
            return redirect()->back()->with('success', 'Votre message a été envoyé avec succès.');
        }

    // FIN CONTACTEZ-NOUS


    public function HistoriqueFrais()
    {
        // code...

        $title = "Historique Frais";
        $account = Account::Where('client_id', Auth()->user()->code_client)->first();

        $frais = Operation::Where('account_id', $account->number_account)->get();

        //dd($frais);

        return view('pages.clients.historiques.frais')
        ->with('title', $title)
        ->with('frais', $frais);
    }

    /*CHANGE-PASSWORD*/



    public function ChangePassword()

    {

        return view('pages.clients.change_password.index');

    }



    public function updatePassword(Request $request)
{
    $validateData = $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:8',
        'conf_password' => 'required|same:new_password',
    ]);

    $user = Client::find(Auth::id());

    if (!$user) {
        abort(404); // Ajoutez une gestion appropriée si l'utilisateur n'est pas trouvé
    }

    $hashedPassword = $user->password;
    if (Hash::check($request->old_password, $hashedPassword)) {

    // Mise à jour du mot de passe sans vérification de l'ancien mot de passe
    $user->update(['password' => Hash::make($request->new_password)]);

    $request->session()->flash('msg', 'Le mot de passe a été changé avec succès!');

    } else {
        $request->session()->flash('msg_error', 'L\'ancien mot de passe n\'est pas correct!');
    }

    return back();
}

       

       /*FIN CHANGE-PASSWORD*/


}

