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

Route::post('/users/add-new', [
    HomeController::class, 
    'addUser'
])->name('addUser');

Route::post('/users/edit', [
    HomeController::class, 
    'editUser'
])->name('editUser');

Route::post('/users/del', [
    HomeController::class, 
    'delUser'
])->name('delUser');


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

/**Fin consultation**/


Route::get('/account/create', [
    HomeController::class, 
    'accountCreate'
])->name('account-create');

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

/***FIN ACCOUNTS***/


/***RECEPTION****/
    Route::get('/demande-credit', [
        HomeController::class, 
        'DemandeCredit'
    ])->name('demande-credit');

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

    Route::get('/liste-demandes', [
        HomeController::class, 
        'ListDemandes'
    ])->name('liste-demandes');

    Route::get('/liste-demandes/assign', [
        HomeController::class, 
        'ListDemandesAssign'
    ])->name('liste-demandes-assign');


    Route::get('/complete-demandes/{id}', [
        HomeController::class, 
        'CompleteDemandes'
    ])->name('complete-demandes');

    Route::get('/faire-simulation/{id}', [
        HomeController::class, 
        'simulation_new'
    ])->name('simulation-new');

    Route::get('/simulation/succes', [
        HomeController::class, 
        'succes_simulation'
    ])->name('simulation-succes');

    Route::post('/complete-demandes/{id}/step-2', [
        HomeController::class, 
        'CompleteDemandesStep2'
    ])->name('complete-demandes-step-2');

    Route::post('/complete-demandes/{id}/step-3', [
        HomeController::class, 
        'CompleteDemandesStep3'
    ])->name('complete-demandes-step-3');

    Route::get('/demandes/details/{id}', [
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

    Route::get('/demandes/send/{id}', [
        HomeController::class, 
        'sendDemandeAnalyste'
    ])->name('send-demande-envoyer');

    Route::post('/demandes/send/valide', [
        HomeController::class, 
        'sendDemandeAnalysteValide'
    ])->name('send-demande-envoyer-valide');

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


require 'client_auth.php';