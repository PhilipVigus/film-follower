<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Film;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportLegacyData extends Command
{
    /** @var string */
    protected $signature = 'film-follower:import-legacy-data';

    /** @var string */
    protected $description = 'This command imports data from the mongodb database of the previous version of film-follower.';

    public function __construct()
    {
        parent::__construct();
    }

    /** @var int */
    public function handle()
    {
        $trailers = DB::connection('mongodb')->table('trailers')->get();

        foreach ($trailers as $trailer) {
            $guid = Str::beforeLast($trailer['guid'], '/');

            if (! Str::contains($guid, 'http://')) {
                continue;
            }

            $title = Str::beforeLast($trailer['title'], ':');
            $date = Carbon::createFromTimestampMs($trailer['articleDate']);
            $film = Film::firstOrCreate(
                [
                    'guid' => $guid,
                ],
                [
                    'title' => $title,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]
            );
        }

        return 0;
    }
}
