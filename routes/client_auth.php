<?php 

	use App\Http\Controllers\Auth\LoginController;
	use App\Http\Controllers\ClientController;



	Route::get('/client',[LoginController::class,'showClientLoginForm'])->name('client.login-view');
	Route::post('/client',[LoginController::class,'clientLogin'])->name('client.login');
	Route::get('/client/dashboard', [ClientController::class, 'index'])->name('home');
	

	Route::get('/client/versements', [ClientController::class, 'versements'])->name('client-versements');
	Route::get('/client/retraits', [ClientController::class, 'retraits'])->name('client-retraits');
	

	Route::get('/client/virements', [ClientController::class, 'virements'])->name('client-virements');

	Route::get('/client/virements/{ref}/print', [ClientController::class, 'virementPrint'])->name('client-virement-print');
	Route::get('/client/versements/{ref}/print', [ClientController::class, 'versementPrint'])->name('client-versement-print');
	Route::get('/client/retraits/{ref}/print', [ClientController::class, 'retraitPrint'])->name('client-retrait-print');


	Route::get('/client/virement/step-1', [ClientController::class, 'virementNew'])->name('client-virements-new');

	Route::get('/client/virement/step-2', [ClientController::class, 'virementSearch'])->name('client-virements-search');
	Route::post('/client/virement/valid', [ClientController::class, 'virementValid'])->name('client-virements-valid');
	Route::get('/client/virement/{ref}/success', [ClientController::class, 'virementSuccess'])->name('client-virements-success');


	Route::get('/profil', [
		ClientController::class, 
	    'profil'
	])->name('profil.index');


	Route::get('/virements/vers-un-compte/hope-fund', [
        ClientController::class, 
        'CompteHopefund'
    ])->name('compte-hopefund');

    Route::get('/virements/vers-un-numero/mobile-money', [
        ClientController::class, 
        'NumeroMobileMoney'
    ])->name('numero-mobile-money');

    Route::get('/paiement/effectuer-paiement', [
        ClientController::class, 
        'EffectuerPaiement'
    ])->name('effectuer-paiement');

    Route::post('/paiement/effectuer-paiement/valid', [
        ClientController::class, 
        'EffectuerPaiementValid'
    ])->name('effectuer-paiement-valid');

    Route::get('/paiement/demander-paiement', [
        ClientController::class, 
        'DemanderPaiement'
    ])->name('demander-paiement');

    Route::post('/paiement/demander-paiement/valid', [
        ClientController::class, 
        'DemanderPaiementValid'
    ])->name('demander-paiement-valid');


    // Gestion compte 
        Route::get('/gestion/compte/credit', [ 
            ClientController::class,
            'client_credit'
        ])->name('client_credit');

        Route::post('/gestion/compte/credit/submit', [ 
            ClientController::class,
            'submitClientCreditForm'
        ])->name('client_credit.submit');

        Route::get('/gestion/compte/chequier', [ 
            ClientController::class,
            'client_chequier'
        ])->name('client_chequier');

        Route::post('/gestion/compte/chequier/submit', [ 
            ClientController::class,
            'SubmitClientChequier'
        ])->name('submit.client.chequier');

        Route::get('/gestion/compte/releve', [ 
            ClientController::class,
            'client_relevecompe'
        ])->name('client_relevecompe');


        // CARTE HFP

        Route::get('/ma-carte-hfb/code-qr', [ 
            ClientController::class,
            'affichecodeqr'
        ])->name('affiche.codeqr');

        Route::get('/ma-carte-hfb/code-pin', [ 
            ClientController::class,
            'codepin'
        ])->name('codepin');

        Route::post('/ma-carte-hfb/code-pin/submit', [
            ClientController::class,
             'submitCodePinForm'
        ])->name('codepin.submit');

        // Route::get('/ma-carte-hfb/commander-cartes', [ 
        //     ClientController::class,
        //     'commandecarte'
        // ])->name('commande.carte');

        Route::get('/ma-carte-hfb/commander-cartes', [ 
            ClientController::class,
            'CommandeCarte'
        ])->name('commande.carte');

        Route::post('/ma-carte-hfb/commander-cartes/submit', [
            ClientController::class,
             'SubmitCommandeForm'
        ])->name('commande.carte.submit');

            
        Route::get('/ma-carte-hfb/suspendre-carte', [ 
            ClientController::class,
            'annulercarte'
        ])->name('annuler.carte');

        Route::post('/ma-carte-hfb/suspendre-carte/submit', [
            ClientController::class,
             'submitAnnulationForm'
         ])->name('annuler.carte.submit');


        Route::get('/client/contactez-nous', [ 
            ClientController::class,
            'contact'
        ])->name('contact');

        Route::post('/client/contactez-nous/valid', [ 
            ClientController::class,
            'SubmitContactForm'
        ])->name('submit.contact.form');


        /***HISTORIQUE***/
        Route::get('/historique/frais', [
            ClientController::class, 
            'HistoriqueFrais'
        ])->name('historique.frais');
        /***FIN HISTORIQUE***/

        // Changer le mot de passe Admin

        Route::get('/password', [
            ClientController::class, 
            'ChangePassword'
        ])->name('ChangePass');

        Route::post('/password/update', [
            ClientController::class, 
            'UpdatePassword'
        ])->name('password.update');


	/*

	Route::get('/client/dashboard',function(){

	    return view('client');

	})->middleware('auth:client');*/