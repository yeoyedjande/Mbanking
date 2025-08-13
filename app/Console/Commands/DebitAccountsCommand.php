<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Credit;
use App\Models\Client;
use App\Models\Type_frais;
use App\Models\Operation;
use App\Models\Journal;
use App\Models\CoffreFort;

use DB;

use Illuminate\Console\Command;

class DebitAccountsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */ 
    protected $signature = 'frais:log';

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

        $accounts = DB::table('accounts')->where('type_account_id', 18)->get();
        $frais = DB::table('type_frais')->where('type_compte_id', 18)->first();

        foreach ($accounts as $c) {
        
            $init = "REF-FRAI-";

            $rand = rand(111111, 999999);
            $codeExit = Journal::Where('numero_piece', $rand)->first();

            while ($codeExit) {
                
                $rand = mt_rand(111111, 999999);
                $codeExit = Journal::Where('numero_piece', $rand)->first();
            }

            dd();

            $date = date("Ymd");
            $code = $init.$rand.$date;

            Operation::create([
                'ref' => $code,
                'montant' => $frais->montant,
                'account_id' => $c->number_account,
                'date_op' => date('d/m/Y'),
                'heure_op' => date('H:i:s'),
                'user_id' => 1,
                'motif' => 'Frais standard',
            ]);

            DB::table('accounts')->where('number_account', $c->number_account)
                    ->update([
                        'solde' => intval($c->solde) - intval($frais->montant),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);


           $coffresiege = DB::table('coffreforts')->where('id', 1)->first();

            DB::table('coffreforts')->where('id', 1)
                    ->update([
                        'montant' => intval($coffresiege->montant) + intval($frais->montant),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
    
            $compteComptableFrais = DB::table('compte_comptables')->where('numero', '7.1.2')->first();

            DB::table('journals')->insert([
                'date' => date('d/m/Y'),
                'numero_piece' => $rand,
                'fonction' => 'Dépôt',
                'reference' => "REF-FRAIS-" .$rand. date("Ymd"),
                'description' => 'Frais de tenues de compte',
                'compte' => '7.1.2',
                'intitule' => $compteComptableFrais->libelle,
                'credit' => $frais->montant,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $compteComptableRetrait = DB::table('compte_comptables')->where('numero', '2.2.1.1')->first();

            DB::table('journals')->insert([
                'date' => date('d/m/Y'),
                'compte' => '2.2.1.1',
                'intitule' => $compteComptableRetrait->libelle,
                'debit' => $frais->montant,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            

        }
    $this->info('Success');

    }

}
