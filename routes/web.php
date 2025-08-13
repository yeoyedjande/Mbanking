<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [
    HomeController::class, 
    'dashboard'
])->name('dashboard');



/**ADMIN**/
Route::get('/frais', [
    HomeController::class, 
    'frais'
])->name('frais');

Route::post('/frais/new/valid', [
    HomeController::class, 
    'fraisNewValid'
])->name('frais-new-valid');

Route::get('/frais/edit/{id}', [
    HomeController::class, 
    'fraisEdit'
])->name('frais-edit');

Route::post('/frais/edit/valid', [
    HomeController::class, 
    'fraisEditValid'
])->name('frais-edit-valid');


/**FIN ADMIN**/


/**CLIENT**/

Route::get('/client', [
    LoginController::class, 
    'showClientLoginForm'
])->name('auth-client');

Route::post('/client/auth', [
    LoginController::class, 
    'clientLogin'
])->name('auth-client-verif');

Route::get('/client/dashboard', [
    LoginController::class, 
    'clientDashboard'
])->name('auth-client-dashboard');

/**FIN CLIENT**/

Route::get('/users', [
    HomeController::class, 
    'users'
])->name('users');
Route::get('/user/new', [
    HomeController::class, 
    'NewUser'
])->name('NewUser');

Route::post('/users/add-new', [
    HomeController::class, 
    'addUser'
])->name('addUser');

Route::get('/users/edit/{id}', [
    HomeController::class, 
    'editbyUser'
])->name('editbyUser');

Route::post('/users/edit', [
    HomeController::class, 
    'editUser'
])->name('editUser');

Route::post('/users/del', [
    HomeController::class, 
    'delUser'
])->name('delUser');


Route::get('/users/profil', [
    HomeController::class, 
    'ProfilUser'
])->name('profil-user');

Route::post('/users/profil/edit', [
    HomeController::class, 
    'ProfilUserEdit'
])->name('profil-user-edit');

Route::post('/users/profil/change_pwd', [
    HomeController::class, 
    'ChangePassword'
])->name('profil-change-password');


/***ROLES***/
Route::get('/roles', [
    HomeController::class, 
    'roles'
])->name('roles');

Route::post('/roles/create', [
    HomeController::class, 
    'roleAdd'
])->name('role-create-valid');

Route::post('/roles/edit', [
    HomeController::class, 
    'roleEdit'
])->name('role-edit-valid');

Route::post('/roles/del', [
    HomeController::class, 
    'roleDel'
])->name('role-del-valid');


/***FIN ROLES***/

/***PERMISSIONS***/
Route::get('/permissions', [
    HomeController::class, 
    'permissions'
])->name('permissions');

Route::get('/permission_role/{id}', [
    HomeController::class, 
    'permissionRole'
])->name('permission-role');

Route::post('/mutilple_assign/valid', [
    HomeController::class, 
    'mutilple_assign'
])->name('permission-assign');

Route::get('/permission/create', [
    HomeController::class, 
    'permissionCreate'
])->name('permission-create');

Route::get('/permission/edit/{id}', [
    HomeController::class, 
    'permissionEdit'
])->name('permission-edit');

Route::post('/permission/create/valide', [
    HomeController::class, 
    'permissionCreateValid'
])->name('permission-create-valid');

Route::post('/permission/edit/valide', [
    HomeController::class, 
    'permissionEditValid'
])->name('permission-edit-valid');

/***FIN PERMISSIONS***/

/***RETRAIT***/
Route::get('/retraits', [
    HomeController::class, 
    'retraits'
])->name('retraits');

Route::get('/retrait/start', [
    HomeController::class, 
    'retraitStart'
])->name('retrait-start');

Route::get('/retrait/new', [
    HomeController::class, 
    'retraitNew'
])->name('retrait-new');

Route::get('/retrait/new-2', [
    HomeController::class, 
    'retraitSearchAccount'
])->name('retrait-new-search-account');


Route::post('/retrait/new/valid', [
    HomeController::class, 
    'retraitNewValid'
])->name('retrait-new-valid');

Route::get('/retrait/historique', [
    HomeController::class, 
    'retraitHistorique'
])->name('retrait-historique');

Route::get('/retrait/{ref}/success', [
    HomeController::class, 
    'RetraitValidate'
])->name('retrait-validate');

Route::get('/retrait/{ref}/print', [
    HomeController::class, 
    'RetraitPrint'
])->name('retrait-print');

/***FIN RETRAIT***/

/***VERSEMENT***/
Route::get('/versements', [
    HomeController::class, 
    'versements'
])->name('versements');

Route::get('/versement/new', [
    HomeController::class, 
    'versementNew'
])->name('versement-new');

Route::get('/versement/start', [
    HomeController::class, 
    'versementStart'
])->name('versement-start');

Route::get('/versement/search', [
    HomeController::class, 
    'versementSearchAccount'
])->name('versement-new-search-account');


Route::post('/versement/new/valid', [
    HomeController::class, 
    'versementNewValid'
])->name('versement-new-valid');

Route::get('/versement/historique', [
    HomeController::class, 
    'versementHistorique'
])->name('versement-historique');

Route::get('/versement/{ref}/success', [
    HomeController::class, 
    'VersementValidate'
])->name('versement-validate');

Route::get('/versement/{ref}/print', [
    HomeController::class, 
    'VersementPrint'
])->name('versement-print');

/***FIN VERSEMENT***/

Route::get('/transaction/attente', [
    HomeController::class, 
    'transactionAttente'
])->name('transaction-attente');

Route::post('/transaction/attente/valid', [
    HomeController::class, 
    'transactionAttenteValid'
])->name('transaction-attente-valid');



/***SEUIL***/
Route::get('/seuils', [
    HomeController::class, 
    'Seuil'
])->name('seuil');

Route::post('/seuil/valide/versement', [
    HomeController::class, 
    'SeuilValidVersement'
])->name('seuil-valid-versement');

Route::post('/seuil/valide/retrait', [
    HomeController::class, 
    'SeuilValidRetrait'
])->name('seuil-valid-retrait');

Route::get('/seuil/edit/retrait/{id}', [
    HomeController::class, 
    'SeuilEditRetrait'
])->name('seuil-edit-retrait');

Route::post('/seuil/edit/retrait/valid', [
    HomeController::class, 
    'SeuilEditRetraitValid'
])->name('seuil-edit-retrait-valid');

Route::get('/seuil/edit/versement/{id}', [
    HomeController::class, 
    'SeuilEditVersement'
])->name('seuil-edit-versement');

Route::post('/seuil/edit/versement/valid', [
    HomeController::class, 
    'SeuilEditVersementValid'
])->name('seuil-edit-versement-valid');

/***FIN SEUIL***/

Route::get('/balance', [
    HomeController::class, 
    'balance'
])->name('balance');

Route::post('/balance/periode', [
    HomeController::class, 
    'balancePeriode'
])->name('balance-periode');

Route::post('/balance/date-intervalle', [
    HomeController::class, 
    'balanceDateIntervalle'
])->name('balance-date-intervalle');


Route::get('/grand-livre', [
    HomeController::class, 
    'GrandLivre'
])->name('grand-livre');

Route::post('/grand-livre/periode', [
    HomeController::class, 
    'GrandLivreSearchPeriode'
])->name('grand-livre-search-periode');

Route::post('/grand-livre/date-intervalle', [
    HomeController::class, 
    'GrandLivreSearchDateIntervalle'
])->name('grand-livre-search-date-intervalle');

Route::post('/grand-livre/compte-intervalle', [
    HomeController::class, 
    'GrandLivreSearchCompteIntervalle'
])->name('grand-livre-search-compte-intervalle');

Route::get('/grand-livre/export-pdf', [
    HomeController::class, 
    'pdfGrandLivre'
])->name('grand-livre-pdf');


Route::get('/gestion-plan-comptable', [
    HomeController::class, 
    'GestionComptable'
])->name('gestion-comptable');


Route::get('/gestion-plan-comptable/{numero}/compte', [
    HomeController::class, 
    'GestionComptableEdit'
])->name('gestion-comptable-edit');

Route::post('/gestion-plan-comptable/edit/valid', [
    HomeController::class, 
    'GestionComptableEditValid'
])->name('gestion-comptable-valid');

Route::get('/ecritures-mannuelles', [
    HomeController::class, 
    'EcritureMannuelle'
])->name('ecritures-mannuelles');

Route::post('/ecritures-mannuelles/save', [
    HomeController::class, 
    'EcritureMannuelleSave'
])->name('ecritures-mannuelle-save');


Route::get('/depenses-revenus', [
    HomeController::class, 
    'DepenseRevenus'
])->name('depenses-revenus');

Route::post('/depenses-revenus/valid', [
    HomeController::class, 
    'DepenseRevenusValid'
])->name('depenses-revenus-valid');

Route::get('/depenses-revenus/edit/{id}', [
    HomeController::class, 
    'DepenseRevenusEdit'
])->name('depenses-revenus-edit');

/***JOURNAL ***/
Route::get('/journal', [
    HomeController::class, 
    'Journal'
])->name('journal');

Route::get('/journal/start', [
    HomeController::class, 
    'JournalStart'
])->name('journal-start');

Route::get('/journal/periode', [
    HomeController::class, 
    'JournalSearchPeriode'
])->name('journal-search-periode');

Route::get('/journal/date-intervalle', [
    HomeController::class, 
    'JournalSearchDateIntervalle'
])->name('journal-search-date-intervalle');


/***FIN JOURNAL***/

Route::get('/all-operations', [
    HomeController::class, 
    'allTransactions'
])->name('all-operations');

/***AGENCE***/

Route::get('/agences', [
    HomeController::class, 
    'agences'
])->name('agences');

Route::post('/agences/create', [
    HomeController::class, 
    'agenceCreate'
])->name('agence-create');

Route::get('/agence/{id}/edit', [
    HomeController::class, 
    'agenceEdit'
])->name('agence-edit');

Route::post('/agence/edit/valide', [
    HomeController::class, 
    'agenceEditValid'
])->name('agence-edit-valid');


Route::get('/coffres-forts', [
    HomeController::class, 
    'CoffreFort'
])->name('coffre-fort');

Route::post('/send/banktocoffre', [
    HomeController::class, 
    'BankToCoffre'
])->name('bank-to-coffre');

Route::post('/send/coffretocoffre', [
    HomeController::class, 
    'CoffreToCoffre'
])->name('coffre-to-coffre');

Route::post('/send/coffretobanque', [
    HomeController::class, 
    'CoffreToBanque'
])->name('coffre-to-banque');

Route::post('/send/coffretoprincipal', [
    HomeController::class, 
    'CoffreToPrincipal'
])->name('coffre-to-principal');


Route::post('/agence/transfert/valid', [
    HomeController::class, 
    'TransfertVersAgenceValid'
])->name('transfert-vers-agence-valid');

Route::post('/agence/transfert/edit', [
    HomeController::class, 
    'TransfertVersAgenceValidEdit'
])->name('transfert-vers-agence-edit');

/***FIN AGENCE***/


/***DEVISES***/
Route::get('/devises', [
    HomeController::class, 
    'devises'
])->name('devises');

Route::post('/devises/create', [
    HomeController::class, 
    'deviseAdd'
])->name('devise-create-valid');

/***FIN DEVISES***/

/***ACCOUNTS***/
Route::get('/accounts', [
    HomeController::class, 
    'accounts'
])->name('accounts');

/**Consultation**/
Route::get('/accounts/consultation', [
    HomeController::class, 
    'accountsConsultation'
])->name('accounts-consultation');

Route::post('/accounts/consultation/verif', [
    HomeController::class, 
    'accountsConsultationVerif'
])->name('accounts-consultation-verif');

Route::get('/accounts/solde', [
    HomeController::class, 
    'accountsSolde'
])->name('accounts-solde');

Route::get('/accounts/operations/{number_account}', [
    HomeController::class, 
    'accountsOperation'
])->name('accounts-operation');

Route::get('/accounts/dossier/{id}', [
    HomeController::class, 
    'DossierDetail'
])->name('detail-dossier');
/**Fin consultation**/

Route::get('/account/ouvertures', [
    HomeController::class, 
    'indexCreate'
])->name('account-index');

Route::get('/account/ouverture/{slug}', [
    HomeController::class, 
    'AccountOuverture'
])->name('account-create');

Route::get('/account/print/carte', [
    HomeController::class, 
    'CartePrint'
])->name('account-print-carte');

Route::post('/account/create/valid', [
    HomeController::class, 
    'accountCreateValid'
])->name('account-create-valid');

Route::get('/account/types', [
    HomeController::class, 
    'type'
])->name('account-type');

Route::post('/account/types/create', [
    HomeController::class, 
    'typeCreate'
])->name('account-type-create');

Route::get('/account/success/{code}', [
    HomeController::class, 
    'SuccessInscription'
])->name('success_inscription');

Route::get('/account/{code}/print', [
    HomeController::class, 
    'PrintInscription'
])->name('account-print');

/***FIN ACCOUNTS***/

/*** CARTE BANCAIRE ***/
Route::get('/edition/bancaire', [
    HomeController::class, 
    'carteBancaire'
])->name('editions-bancaire');

Route::get('/edition/bancaire/check', [
    HomeController::class, 
    'carteBancaireCheck'
])->name('editions-bancaire-check');


/*** FIN CARTE BANCAIRE ***/

/***RECEPTION****/

    Route::get('/get-type-credit-by-num-dossier/{numDossier}', [
        HomeController::class, 
        'getTypeCreditByNumDossier'
    ])->name('get-type-dossier-credit');

    Route::get('/process/remboursement', [
        HomeController::class, 
        'ProcessRemboursement'
    ])->name('process-remboursement');

    Route::post('/process/remboursement/valid', [
        HomeController::class, 
        'ProcessRemboursementValid'
    ])->name('process-remboursement-valid');

    Route::get('/demande-credit', [
        HomeController::class, 
        'DemandeCredit'
    ])->name('demande-credit');

    Route::get('/remboursement-credit', [
        HomeController::class, 
        'RemboursementCredit'
    ])->name('remboursement-credit');

    Route::get('/demande-credit-step-2', [
        HomeController::class, 
        'DemandeCredit2'
    ])->name('demande-credit-2');

    Route::get('/demande-credit-step-1', [
        HomeController::class, 
        'DemandeCreditStep2'
    ])->name('demande-credit-step-2');

    Route::post('/demande-credits/add-file', [
        HomeController::class, 
        'AddFilesCredit'
    ])->name('add-files-credit');

    Route::post('/demande-credits/send', [
        HomeController::class, 
        'SendDemandeCredit'
    ])->name('send-demande-credit');

    Route::get('/dossier-credit/ouvert/success', [
        HomeController::class, 
        'DossierOuvertSuccess'
    ])->name('dossier-success-credit');

    Route::get('/liste-demandes', [
        HomeController::class, 
        'ListDemandes'
    ])->name('liste-demandes');

    Route::get('/credits-octroyes', [
        HomeController::class, 
        'ListCredits'
    ])->name('liste-credits');

    Route::get('/liste-demandes/assign', [
        HomeController::class, 
        'ListDemandesAssign'
    ])->name('liste-demandes-assign');


    Route::get('/{id}/complete-demandes', [
        HomeController::class, 
        'CompleteDemandes'
    ])->name('complete-demandes');

    Route::post('/complete-demande/valid', [
        HomeController::class, 
        'CompleteDemandesValid'
    ])->name('valid-credit-compete');

    Route::get('/{id}/faire-simulation', [
        HomeController::class, 
        'simulation_new'
    ])->name('simulation-new');

    Route::get('/success/complete/{dossier}', [
        HomeController::class, 
        'SuccessComplete'
    ])->name('success-complete');

    Route::get('/simulation/{dossier}/succes', [
        HomeController::class, 
        'succes_simulation'
    ])->name('simulation-succes');

    Route::get('/simulation/{dossier}/print', [
        HomeController::class, 
        'Printsimulation'
    ])->name('simulation-print');

    Route::get('/liste-simulations', [
        HomeController::class, 
        'ListeSimulation'
    ])->name('simulation-liste');

    Route::post('/complete-demandes/{id}/step-2', [
        HomeController::class, 
        'CompleteDemandesStep2'
    ])->name('complete-demandes-step-2');

    Route::post('/complete-demandes/{id}/step-3', [
        HomeController::class, 
        'CompleteDemandesStep3'
    ])->name('complete-demandes-step-3');

    Route::get('/demandes/details/{dossier}', [
        HomeController::class, 
        'DetailDemandes'
    ])->name('detail-demandes');

    Route::get('/taux-interets', [
        HomeController::class, 
        'TauxInterets'
    ])->name('taux-interets');

    Route::get('/taux-interet/{id}', [
        HomeController::class, 
        'TauxInteretGet'
    ])->name('taux-interet-get');

    Route::post('/taux-interet/create', [
        HomeController::class, 
        'TauxInteretCreate'
    ])->name('taux-interet-create');

    Route::post('/taux-interet/edit', [
        HomeController::class, 
        'TauxInteretEdit'
    ])->name('taux-interet-edit');

    Route::get('/demandes/send/{dossier}', [
        HomeController::class, 
        'sendDemandeAnalyste'
    ])->name('send-demande-envoyer');

    Route::post('/demandes/send/valide', [
        HomeController::class, 
        'sendDemandeAnalysteValide'
    ])->name('send-demande-envoyer-valide');

    Route::get('/correspondances', [
        HomeController::class, 
        'correspondances'
    ])->name('correspondances');

    Route::get('/correspondance/new', [
        HomeController::class, 
        'correspondanceNew'
    ])->name('correspondance-new');

    Route::post('/correspondance/new/valid', [
        HomeController::class, 
        'correspondanceNewValid'
    ])->name('correspondance-new-valid');

/***FIN RECEPTION***/


/***CAISSE***/
Route::get('/caisses', [
    HomeController::class, 
    'Caisse'
])->name('caisse');

Route::get('/caisse/create', [
    HomeController::class, 
    'CaisseCreate'
])->name('caisse-create');

Route::post('/caisse/create/valid', [
    HomeController::class, 
    'CaisseCreateValid'
])->name('caisse-create-valid');

Route::post('/caisse/edit', [
    HomeController::class, 
    'CaisseEditValid'
])->name('caisse-edit-valid');

Route::post('/caisse/del/valid', [
    HomeController::class, 
    'CaisseDelValid'
])->name('caisse-del-valid');

Route::get('/caisses/rechargement', [
    HomeController::class, 
    'CaisseRechargement'
])->name('caisse-rechargement');

Route::post('/caisses/rechargement/valid', [
    HomeController::class, 
    'CaisseRechargementValid'
])->name('caisse-rechargement-valid');

Route::get('/caisses/ouverture', [
    HomeController::class, 
    'CaisseOuverture'
])->name('caisse-ouverture');

Route::post('/caisses/ouverture/verif', [
    HomeController::class, 
    'CaisseOuvertureVerif'
])->name('caisse-ouverture-verif');

Route::post('/caisses/fermeture', [
    HomeController::class, 
    'CaisseFermeture'
])->name('caisse-fermeture');

Route::get('/caisses/reajustements', [
    HomeController::class, 
    'Reajustement'
])->name('caisse-reajustement');

Route::get('/caisses/{id}/reajustement', [
    HomeController::class, 
    'CaisseReajuster'
])->name('caisse-reajuster');

Route::post('/caisses/reajustement/step-1', [
    HomeController::class, 
    'CaisseReajusterValide'
])->name('caisse-reajuster-valide');

Route::get('/caisses/reajustement/step-2', [
    HomeController::class, 
    'CaisseReajuster2'
])->name('caisse-reajuster-2');

/*Route::post('/caisses/reajustement/step-1', [
    HomeController::class, 
    'CaisseReajusterValide'
])->name('caisse-reajuster-valide');*/

Route::post('/caisses/reajustement/end', [
    HomeController::class, 
    'CaisseReajusterValideEnd'
])->name('caisse-reajuster-valid-end');

Route::get('/caisses/reajustement/close', [
    HomeController::class, 
    'CaisseReajusterClose'
])->name('caisse-reajuster-close');

Route::get('/caisse/cloture', [
    HomeController::class, 
    'CaisseCloture'
])->name('caisse-cloture');

Route::post('/caisse/cloture/verif', [
    HomeController::class, 
    'CaisseClotureVerif'
])->name('caisse-cloture-verif');

Route::get('/caisse/cloture/close', [
    HomeController::class, 
    'CaisseClotureEnd'
])->name('caisse-cloture-End');

Route::get('/caisse/print/recu', [
    HomeController::class, 
    'CaissePrintClotureEnd'
])->name('caisse-cloture-print-End');

Route::get('/caisse/report/close', [
    HomeController::class, 
    'CaisseReportClose'
])->name('caisse-cloture-report-close');

Route::get('/caisse/echec/close', [
    HomeController::class, 
    'CaisseEchecClose'
])->name('caisse-cloture-echec-close');


Route::post('/caisses/annulation', [
    HomeController::class, 
    'CaisseAnnulation'
])->name('caisse-annulation');

Route::post('/credit/anlyste', [
    HomeController::class, 
    'AnalysteValid'
])->name('analyste-credit-validation');

Route::get('/demande/credit/attente', [
    HomeController::class, 
    'demande_attente'
])->name('demande_attente');

Route::get('/demande/avis/{id}/consulting', [
    HomeController::class, 
    'Avis_consulting'
])->name('avis-consulting');

Route::get('/dossier/traites', [
    HomeController::class, 
    'DossierTraite'
])->name('dossier-traite');

Route::post('/demande/avis/send', [
    HomeController::class, 
    'SendAvis'
])->name('avis-send');

Route::get('/agence/user/{id}', [
    HomeController::class, 
    'AgenceByUser'
])->name('agence-by-user');

Route::get('/caisses/report', [
    HomeController::class, 
    'RapportCaisse'
])->name('caisse-rapport');

Route::post('/caisses/reports', [
    HomeController::class, 
    'RapportCaisseResult'
])->name('caisse-rapport-result');

Route::get('/caisses/historiques', [
    HomeController::class, 
    'HistoriqueCaisse'
])->name('caisse-historique');

/***FIN CAISSE***/


/***VIREMENT***/
Route::get('/virements', [
    HomeController::class, 
    'virements'
])->name('virements');

Route::get('/virement/start', [
    HomeController::class, 
    'virementStart'
])->name('virement-start');

Route::get('/virement/new', [
    HomeController::class, 
    'VirementNew'
])->name('virement-new');

Route::get('/virement/news', [
    HomeController::class, 
    'VirementNew2'
])->name('virement-new-2');

Route::post('/virement/new/confirm', [
    HomeController::class, 
    'VirementNewConfirm'
])->name('virement-new-confirm');

Route::post('/virement/new/confirm/valid', [
    HomeController::class, 
    'VirementNewConfirmValid'
])->name('virement-new-confirm-valid');

Route::get('/virement/{ref}/succes', [
    HomeController::class, 
    'VirementSuccess'
])->name('virement-succes');

Route::get('/virement/{ref}/print', [
    HomeController::class, 
    'VirementPrint'
])->name('virement-print');

/***FIN VIREMENT***/


/***PRET***/

    Route::get('/pret', [
        HomeController::class, 
        'pret'
    ])->name('pret');

    Route::get('/pret/new', [
        HomeController::class, 
        'pretNew'
    ])->name('pret-new');

    Route::post('/pret/new-2', [
        HomeController::class, 
        'pretNew2'
    ])->name('pret-new-2');

    Route::get('/pret/simulation', [
        HomeController::class, 
        'pretSimualation'
    ])->name('pret-simulation');


    Route::post('/pret/new/valid', [
        HomeController::class, 
        'pretNewValid'
    ])->name('pret-new-valid');

    Route::post('/pret/simulation/validate', [
        HomeController::class, 
        'pretSimualationValidate'
    ])->name('pret-simulation-validate');


    Route::post('/pret/simulation/enregistrer', [
        HomeController::class, 
        'pretSimualationEnregistrer'
    ])->name('pret-simulation-enregistrer');

/***FIN PRET***/

/***CHEQUIERS***/
Route::get('/chequiers', [
    HomeController::class, 
    'chequiers'
])->name('chequiers');

Route::get('/chequiers/start', [
    HomeController::class, 
    'chequierStart'
])->name('chequiers-start');

Route::get('/chequiers/client', [
    HomeController::class, 
    'chequierSearch'
])->name('chequiers-search');

Route::post('/chequiers/order/valide', [
    HomeController::class, 
    'chequierValide'
])->name('chequiers-valide');

Route::get('/chequiers/{ref}/success', [
    HomeController::class, 
    'chequierSuccess'
])->name('chequiers-succes');

Route::get('/chequiers/{ref}/print', [
    HomeController::class, 
    'chequierPrint'
])->name('chequiers-print');

/***FIN CHEQUIERS***/

/***REVELES DE COMPTE***/
Route::get('/releves/start', [
    HomeController::class, 
    'releveStart'
])->name('releve-start');

Route::get('/releve', [
    HomeController::class, 
    'releveSearch'
])->name('releve-search');

Route::get('/releves', [
    HomeController::class, 
    'releveSearch2'
])->name('releve-search-2');

Route::get('/releves/{account}/apercu', [
    HomeController::class, 
    'releveApercu'
])->name('releve-apercu');

/*Route::get('/releves/{account}/print', [
    HomeController::class, 
    'relevePrint'
])->name('releve-print');*/

Route::post('/releves/print', [
    HomeController::class, 
    'relevePrint'
])->name('releve-print');

Route::get('/releves/{account}/{date_debut}/{date_fin}/prints', [
    HomeController::class, 
    'relevePrints'
])->name('releve-prints');

/*Route::get('/releves/{account}/{date_debut}/{date_fin}/print', [
    HomeController::class, 
    'relevePrints'
])->name('releve-print');*/


/***FIN REVELES DE COMPTE***/


/***COMPTABILITE***/
Route::get('/rapport/versements', [
    HomeController::class, 
    'RapportVersements'
])->name('rapport-versement');

Route::get('/rapport/retraits', [
    HomeController::class, 
    'RapportRetraits'
])->name('rapport-retrait');

Route::get('/rapport/virements', [
    HomeController::class, 
    'RapportVirements'
])->name('rapport-virement');

Route::get('/rapport/chequiers', [
    HomeController::class, 
    'RapportChequiers'
])->name('rapport-chequiers');

/***FIN COMPTABILITE***/

/**OUVERTURE DE COMPTE **/

Route::get('/ouverture/compte/{slug}', [ 
    HomeController::class,
    'ComptePersonneMoral'
])->name('ComptePersonneMoral');

Route::get('/ouverture/compte/personne/moral', [ 
    HomeController::class,
    'ComptePersonneMoral'
])->name('ComptePersonneMoral');

Route::post('/ouverture/compte/personne/moral/valid', [ 
    HomeController::class,
    'ComptePersonneMoralValid'
])->name('ComptePersonneMoralValid');

Route::get('/ouverture/compte/personne/physique', [ 
    HomeController::class,
    'ComptePersonnePhysique'
])->name('ComptePersonnePhysique');

Route::post('/ouverture/compte/personne/physique/valid', [ 
    HomeController::class,
    'ComptePersonnePhysiqueValid'
])->name('ComptePersonnePhysiqueValid');

Route::get('/ouverture/compte/groupe/formelle', [ 
    HomeController::class,
    'CompteGroupeFormelle'
])->name('CompteGroupeFormelle');

Route::post('/ouverture/compte/groupe/formelle/valid', [ 
    HomeController::class,
    'InsertionGroupeFormelle'
])->name('InsertionGroupeFormelle');

Route::get('/ouverture/compte/groupe/solidaire', [ 
    HomeController::class,
    'CompteGroupeSolidaire'
])->name('CompteGroupeSolidaire');

Route::post('/ouverture/compte/groupe/solidaire/valid', [ 
    HomeController::class,
    'CompteGroupeSolidaireValid'
])->name('CompteGroupeSolidaireValid');

/**FIN OUVERTURE DE COMPTE **/

/* REGLAGE SYSTEME */

Route::get('/change/mot-passe', [
    HomeController::class, 
    'ChangeAutreMotPasse'
])->name('change.autre.mot-passe');

Route::post('/change/mot-passe/update', [
    HomeController::class, 
    'UpdatePassword'
])->name('Change-Autre-Passe');

Route::get('/ajout/frais/dossier', [
    HomeController::class, 
    'AddFraisDossier'
])->name('ajout.frais.dossier');

Route::post('/ajout/frais/dossier/valid', [
    HomeController::class, 
    'AddFraisDossierValid'
])->name('ajout.frais.dossier.valid');



/**FIN REGLAGE SYSTEME **/

/* BILLETS */

Route::get('/billets', [
    HomeController::class, 
    'billets'
])->name('billets.index');

Route::post('/billets/create', [
    HomeController::class, 
    'billetsCreate'
])->name('billets-create');

Route::get('/billets/{id}/edit', [
    HomeController::class, 
    'billetsEdit'
])->name('billets-edit');

Route::post('/billets/edit/valide', [
    HomeController::class, 
    'billetsEditValid'
])->name('billets-edit-valid');

Route::post('/billets/delete', [
    HomeController::class, 
    'billetsDel'
])->name('billets-delete');

    

/**FIN BILLETS **/

/* TYPES DE CREDITS */

Route::get('/types/credits', [
    HomeController::class, 
    'types_credits'
])->name('types_credits.index');

Route::get('/types/credits/create', [
    HomeController::class, 
    'TypesCreditsCreate'
])->name('types_credits-create');

Route::post('/types/credits/create/valid', [
    HomeController::class, 
    'TypesCreditsCreateValid'
])->name('TypesCreditsCreateValid');

Route::get('/types/credits/{id}/edit', [
    HomeController::class, 
    'TypesCreditsEdit'
])->name('TypesCreditsEdit');

Route::post('/types/credits/edit/valide', [
    HomeController::class, 
    'TypesCreditsEditValid'
])->name('types_credits-edit-valid');

Route::post('/types/credits/delete', [
    HomeController::class, 
    'TypesCreditsDel'
])->name('types_credits-delete');

    
/**FIN TYPES DE CREDITS **/

/* TAUX */

Route::get('/taux', [
    HomeController::class, 
    'taux'
])->name('taux.index');

Route::get('/taux/create', [
    HomeController::class, 
    'TauxCreate'
])->name('taux-create');


Route::post('/taux/create/valide', [
    HomeController::class, 
    'TauxCreateValid'
])->name('taux-create-valid');


Route::get('/taux/{id}/edit', [
    HomeController::class, 
    'TauxEdit'
])->name('taux-edit');

Route::post('/taux/edit/valide', [
    HomeController::class, 
    'TauxEditValid'
])->name('taux-edit-valid');

Route::post('/taux/delete', [
    HomeController::class, 
    'TauxDel'
])->name('taux-delete');

    

/**FIN TAUX **/

/* TYPES DE BIENS ET OBJET DE DEMANDE */

Route::get('/type-biens/objet-demande', [
    HomeController::class,
    'type_biens_objet_demande'
])->name('type_biens.demande.index');

Route::post('/type/biens/create', [
    HomeController::class, 
    'type_biensCreate'
])->name('type_biens-create');

Route::get('/type/biens/{id}/edit', [
    HomeController::class, 
    'type_biensEdit'
])->name('type_biens-edit');

Route::post('/type/biens/edit/valide', [
    HomeController::class, 
    'type_biensEditValid'
])->name('type_biens-edit-valid');

Route::post('/type/biens/delete', [
    HomeController::class, 
    'type_biensDel'
])->name('type_biens-delete');

//

Route::post('/objet/demande/create', [
    HomeController::class, 
    'objet_demandeCreate'
])->name('objet_demande-create');

Route::get('/objet/demande/{id}/edit', [
    HomeController::class, 
    'objet_demandeEdit'
])->name('objet_demande-edit');

Route::post('/objet/demande/edit/valide', [
    HomeController::class, 
    'objet_demandeEditValid'
])->name('objet_demande-edit-valid');

Route::post('/objet/demande/delete', [
    HomeController::class, 
    'objet_demandeDel'
])->name('objet_demande-delete');
    

/**FIN TYPES DE BIENS ET OBJET DE DEMANDE **/


/* ETAT DE CREDIT */

Route::get('/etat-credit', [
    HomeController::class, 
    'etat_credit'
])->name('etat-credit-index');

Route::get('/etat-credit/create', [
    HomeController::class, 
    'EtatCreditCreate'
])->name('etat-credit-create');


Route::post('/etat-credit/create/valide', [
    HomeController::class, 
    'EtatCreditCreateValid'
])->name('etat-credit-create-valid');


Route::get('/etat-credit/{id}/edit', [
    HomeController::class, 
    'EtatCreditEdit'
])->name('etat-credit-edit');

Route::post('/etat-credit/edit/valide', [
    HomeController::class, 
    'EtatCreditEditValid'
])->name('etat-credit-edit-valid');

Route::post('/etat-credit/delete', [
    HomeController::class, 
    'EtatCreditDel'
])->name('etat-credit-delete');

    

/**FIN ETAT DE CREDI **/

/* GESTON DES PLAFLONDS */

Route::get('/plafonds', [
    HomeController::class, 
    'plafonds'
])->name('plafonds-index');

Route::get('/plafonds/create', [
    HomeController::class, 
    'PlafondCreate'
])->name('plafonds-create');


Route::post('/plafonds/create/valide', [
    HomeController::class, 
    'PlafondCreateValid'
])->name('plafonds-create-valid');


Route::get('/plafonds/{id}/edit', [
    HomeController::class, 
    'PlafondEdit'
])->name('plafonds-edit');

Route::post('/plafonds/edit/valide', [
    HomeController::class, 
    'PlafondEditValid'
])->name('plafonds-edit-valid');

Route::post('/plafonds/delete', [
    HomeController::class, 
    'PlafondDel'
])->name('plafonds-delete');
/**GESTON DES PLAFLONDS **/

/* BANQUES EXTERNES */

Route::get('/banque/externes', [
    HomeController::class, 
    'banquexternes'
])->name('banquexternes');

Route::get('/banque/externes/create', [
    HomeController::class, 
    'BanquexternesCreate'
])->name('BanquexternesCreate');

Route::post('/banque/externes/create/valid', [
    HomeController::class, 
    'BanquexternesCreateValid'
])->name('BanquexternesCreateValid');

Route::get('/banque/externes/{id}/edit', [
    HomeController::class, 
    'BanquexternesEdit'
])->name('BanquexternesEdit');

Route::post('/banque/externes/edit/valide', [
    HomeController::class, 
    'BanquexternesEditValid'
])->name('BanquexternesEditValid');

Route::post('/banque/externes/delete', [
    HomeController::class, 
    'BanquexternesDel'
])->name('BanquexternesDel');

    

/**FIN BANQUES EXTERNES **/

require 'client_auth.php';