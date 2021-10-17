<?php

namespace App\Console\Commands;

use App\Jobs\GetTrailers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedWithRealData extends Command
{
    /** @var string */
    protected $signature = 'film-follower:clear-and-seed-real-data';

    /** @var string */
    protected $description = 'This command clears the database and seeds it with real data from the RSS feed and creates initial users.';

    public function __construct()
    {
        parent::__construct();
    }

    /** @var int */
    public function handle()
    {
        $this->info('WARNING - this command will wipe all data from your database before seeding');

        if (! $this->confirm('Do you wish to continue?')) {
            return 1;
        }

        Artisan::call('migrate:fresh');
        $this->info('Database wiped');

        Artisan::call('db:seed --class=UserSeeder');
        $this->info('Admin and guest users created');

        GetTrailers::dispatch();
        $this->info('Trailers retrieved');
    }
}
