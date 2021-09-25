<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportLegacyData extends Command
{
    /** @var string */
    protected $signature = 'film-follower:import-legacy-data {file}';

    /** @var string */
    protected $description = 'This command imports data from the previous version of film-follower, which is in json format.';

    public function __construct()
    {
        parent::__construct();
    }

    /** @var int */
    public function handle()
    {
        $trailers = DB::connection('mongodb')->table('trailers')->get();
        dd($trailers->first());
        $this->info(json_encode($trailers->first()));

        return 0;
    }
}
