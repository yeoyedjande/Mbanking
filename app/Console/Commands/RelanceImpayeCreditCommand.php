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

class RelanceImpayeCreditCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */ 
    protected $signature = 'relance:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Le cron pour la relance des crédits impayés';

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
        
        $CreditImpaye = DB::table('operations')->where('statut', 'impaye')->get();

        foreach ($CreditImpaye as $imp){

            $er = '';

        }


        $this->info('Success');

    }

}
