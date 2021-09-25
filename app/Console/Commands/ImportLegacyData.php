<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $filename = $this->argument('file');
        $handle = fopen($filename, 'r');
        $header = true;

        while ($csvLine = fgetcsv($handle)) {
            if ($header) {
                $header = false;

                continue;
            }

            $this->info(json_encode($csvLine[0]));
        }

        return 0;
    }
}
