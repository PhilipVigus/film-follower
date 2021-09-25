<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Film;
use App\Models\User;
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
            $filmGuid = Str::beforeLast($trailer['guid'], '/');

            if (! Str::contains($filmGuid, 'http://')) {
                continue;
            }

            $filmTitle = Str::beforeLast($trailer['title'], ':');
            $date = Carbon::createFromTimestampMs($trailer['articleDate']);

            $film = Film::firstOrCreate(
                [
                    'guid' => $filmGuid,
                ],
                [
                    'title' => $filmTitle,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]
            );

            $users = User::all();

            foreach ($users as $user) {
                if (! $user->films()->where('film_id', $film->id)->exists()) {
                    $user->films()->attach($film);
                }
            }

            $trailerType = trim(Str::afterLast($trailer['title'], ':'));

            $film->trailers()->create([
                'guid' => $trailer['guid'],
                'title' => $trailer['title'],
                'type' => $trailerType,
                'image' => $trailer['imageURL'],
                'link' => $trailer['trailerLink'],
                'uploaded_at' => $date,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        return 0;
    }
}
