<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Credit;
use App\Models\Client;
use App\Models\Type_frais;
use App\Models\Operation;
use App\Models\Journal;
use App\Models\CoffreFort;
use Carbon\Carbon;
use DB;

use Illuminate\Console\Command;

class DebitCreditCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */ 
    protected $signature = 'credit:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Je déclence le Cron Job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    
    public function handle()
    {

        dd();
        $today = now();

        $credits = \DB::table('credits')
        ->join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
        ->join('accounts', 'accounts.number_account', '=', 'credits.num_account')
        ->where('credits.date', '=', $today->day)
        ->get();

        foreach ($credits as $credit) {
            
            $echeancier = DB::table('echeanciers')
            ->where('dossier', $credit->num_dossier)
            ->where('date_echeance', '=', $today->day)
            ->where('statut_paiement', 'en cours')
            ->first();

            $MontantDebit = $echeancier->penalite_attendu + $echeancier->capital_attendu + $echeancier->interet_attendu;

            // Trouver le compte associé au crédit
            $account = DB::table('accounts')->where('number_account', $credit->num_account)->first();
            if (!$account) {
                $this->error("Le compte n'a pas été trouvé pour le crédit: {$credit->id}");
                continue;
            }

            $today = Carbon::today();
            $dueDate = Carbon::createFromFormat('d/m/Y', $credit->date);
            $daysLate = $dueDate->diffInDays($today, false); 

            if ($daysLate <= 29) {
                $etatCredit = 'A surveiller';
                $tauxProvision = 0.01;
            } elseif ($daysLate <= 89) {
                $etatCredit = 'Pré-douteux';
                $tauxProvision = 0.05;
            } elseif ($daysLate <= 179) {
                $etatCredit = 'Douteux';
                $tauxProvision = 0.25;
                //E
            } elseif ($daysLate <= 359) {
                $etatCredit = 'Contentieux';
                $tauxProvision = 0.50;
            } else { // 360 jours et plus
                $etatCredit = 'Compromis';
                $tauxProvision = 1.00;
            }


            // Le taux de pénalité est le même dans votre exemple original, mais peut être ajusté si nécessaire
            $tauxPenalite = 0.05;

            /*\DB::table('credits')
                ->where('id', $credit->id)
                ->update([
                    'etat_credit' => $etatCredit,
                    'montant_provision' => \DB::raw($MontantDebit.' * '.$tauxProvision),
                    'penalite_rembourse' => \DB::raw($MontantDebit.' * '.$tauxPenalite), 
                ]);*/

            $solde = intval($account->solde);

            if ($solde >= $MontantDebit) {
                // Vérifiez si le capital est dû
                if ($credit->capital_du != 0) {
                    
                    DB::table('echeanciers')
                    ->where('dossier', $credit->num_dossier)
                    ->where('date_echeance', '=', $today->day)
                    ->update([
                        'echeance_cloture' => 'oui',
                        'statut_paiement' => 'paye',
                        'capital_remb' => $echeancier->capital_attendu,
                        'interet_remb' => $echeancier->interet_attendu,
                        'penalite_remb' => $echeancier->penalite_attendu,
                        'montant_total_remb' => $echeancier->penalite_attendu + $echeancier->capital_attendu + $echeancier->interet_attendu,
                        'date_remb' => date('d/m/Y'),
                        'heure_echeance' => date('H:i'),
                    ]);


                    //Récupérer les comptes du client
                    $accounts = DB::table('accounts')
                        ->where('number_account', $credit->num_account)
                        ->get();

                    DB::table('credits')->where('id', $credit->id)
                    ->update([

                        'capital_rembourse' => $credit->capital_rembourse + $echeancier->capital_attendu,
                        'interet_rembourse' => $credit->interet_rembourse + $echeancier->interet_attendu,
                        'penalite_rembourse' => $credit->penalite_rembourse + $echeancier->penalite_attendu,
                        'total_rembourse' => $credit->total_rembourse + $MontantDebit,
                        'capital_du' => $credit->montant_octroye - ( $credit->capital_rembourse + $echeancier->capital_attendu),
                        'interet_restant_du' => $credit->montant_octroye - ( $credit->interet_rembourse + $echeancier->interet_attendu),

                    ]);


                    DB::table('accounts')->where('number_account', $credit->number_account)
                            ->decrement('solde', $MontantDebit);

                    // Réduire le montant du capital dû
                    DB::table('credits')->where('id', $credit->id)
                        ->decrement('capital_du', $credit->capital_du);

                    $piece = mt_rand(111111, 9999999);
                    $pieceExist = DB::table('journals')->Where('numero_piece', $piece)->first();

                    while( $pieceExist ){
                        $piece = mt_rand(111111, 9999999);
                        $pieceExist = DB::table('journals')->Where('numero_piece', $piece)->first();
                    }

                    

                      $compteComptable2 = DB::table('compte_comptables')->where('numero', '2.1.1.1')->first();

                    DB::table('journals')->insert([
                        'date' => date('d/m/Y'),
                        'numero_piece' => $piece,
                        'compte' => '7.0.2.1',
                        'intitule' => $compteComptable2->libelle,
                        'credit' => $echeancier->capital_attendu,
                        'account_id' => $credit->num_account,
                        'user_id' => 1,
                        'agence_id' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    $compteComptable = DB::table('compte_comptables')->where('numero', '2.2.1.1')->first();

                    DB::table('journals')->insert([
                        'date' => date('d/m/Y'),
                        'numero_piece' => $piece,
                        'fonction' => 'Batch',
                        'reference' => "REF-REMB-" .$piece. date("Ymd"),
                        'description' => 'Remboursement de crédit',
                        'compte' => $compteComptable->numero,
                        'intitule' => $compteComptable->libelle,
                        'debit' => $echeancier->capital_attendu,
                        'account_id' => $credit->num_account,
                        'user_id' => 1,
                        'agence_id' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                
                    $compteComptable3 = DB::table('compte_comptables')->where('numero', '7.0.2.1')->first();

                    DB::table('journals')->insert([
                        'date' => date('d/m/Y'),
                        'numero_piece' => $piece,
                        'compte' => '7.0.2.1',
                        'intitule' => $compteComptable3->libelle,
                        'credit' => $echeancier->interet_attendu,
                        'account_id' => $credit->num_account,
                        'user_id' => 1,
                        'agence_id' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    $compteComptable4 = DB::table('compte_comptables')->where('numero', '2.1.1.1')->first();

                    DB::table('journals')->insert([
                        'date' => date('d/m/Y'),
                        'numero_piece' => $piece,
                        'fonction' => 'Batch',
                        'reference' => "REF-REMB-" .$piece. date("Ymd"),
                        'description' => 'Remboursement de crédit',
                        'compte' => $compteComptable4->numero,
                        'intitule' => $compteComptable4->libelle,
                        'debit' => $echeancier->interet_attendu,
                        'account_id' => $credit->num_account,
                        'user_id' => 1,
                        'agence_id' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    // Vérifier si le crédit a été entièrement remboursé
                    $remainingCapital = DB::table('credits')->where('id', $credit->id)->value('capital_du');
                    if ($remainingCapital <= 0) {
                        // Si le capital restant est égal ou inférieur à zéro, mettre à jour l'état du crédit à "Remboursé"
                        DB::table('credits')->where('id', $credit->id)
                            ->update(['etat_credit' => 'Sain']);
                    }
                }
            }else{


                // Gérer le solde insuffisant
                $this->error("Solde insuffisant dans le compte {$account->number_account} pour débiter {$MontantDebit}");
                // Implémentation de la logique

                $piece = mt_rand(111111, 9999999);
                    $pieceExist = DB::table('journals')->Where('numero_piece', $piece)->first();

                    while( $pieceExist ){
                        $piece = mt_rand(111111, 9999999);
                        $pieceExist = DB::table('journals')->Where('numero_piece', $piece)->first();
                    }


                    DB::table('echeanciers')
                    ->where('dossier', $credit->num_dossier)
                    ->where('date_echeance', '=', $today->day)
                    ->update([
                        'echeance_cloture' => 'non',
                        'statut_paiement' => 'impaye',
                        'capital_remb' => $echeancier->capital_attendu,
                        'interet_remb' => $echeancier->interet_attendu,
                        'penalite_remb' => $echeancier->penalite_attendu,
                        'montant_total_remb' => $echeancier->penalite_attendu + $echeancier->capital_attendu + $echeancier->interet_attendu,
                        'date_remb' => date('d/m/Y'),
                        'heure_echeance' => date('H:i'),
                    ]);

                    $compteComptable2 = DB::table('compte_comptables')->where('numero', '2.2.1.1')->first();

                    DB::table('journals')->insert([
                        'numero_piece' => $piece,
                        'date' => date('d/m/Y'),
                        'compte' => '2.2.1.1',
                        'intitule' => $compteComptable2->libelle,
                        'credit' => $MontantDebit,
                        'account_id' => $credit->num_account,
                        'user_id' => 1,
                        'agence_id' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    $compteComptable = DB::table('compte_comptables')->where('numero', '2.1.4.1.3')->first();

                    DB::table('journals')->insert([
                        'date' => date('d/m/Y'),
                        'numero_piece' => $piece,
                        'fonction' => 'Batch',
                        'reference' => "REF-REMB-" .$piece. date("Ymd"),
                        'description' => 'Remboursement de crédit',
                        'compte' => $compteComptable->numero,
                        'intitule' => $compteComptable->libelle,
                        'debit' => $MontantDebit,
                        'account_id' => $credit->num_account,
                        'user_id' => 1,
                        'agence_id' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

            }

        }
        
        $this->info('Success');

    }

}
