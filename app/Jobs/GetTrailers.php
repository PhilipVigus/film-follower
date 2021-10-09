<?php

namespace App\Jobs;

use App\Models\Tag;
use App\Models\Film;
use App\Models\User;
use App\Models\Trailer;
use Illuminate\Bus\Queueable;
use App\Support\RssFeedReader;
use Illuminate\Support\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetTrailers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle()
    {
        info('called');
        $rssDataItems = RssFeedReader::getLatestItems();

        $users = User::all();

        foreach ($rssDataItems as $itemData) {
            $film = Film::firstOrCreate(
                [
                    'guid' => $itemData['film']['guid'],
                ],
                [
                    'title' => $itemData['film']['title'],
                ]
            );

            $this->addFilmToUsers($film, $users);

            $itemData['trailer']['film_id'] = $film->id;

            $trailer = Trailer::create($itemData['trailer']);

            $this->createTags($itemData['tags'], $trailer);
        }
    }

    private function addFilmToUsers(Film $film, Collection $users)
    {
        foreach ($users as $user) {
            if (! $user->films()->where('film_id', $film->id)->exists()) {
                $user->films()->attach($film);
            }
        }
    }

    private function createTags(array $tagsData, Trailer $trailer)
    {
        foreach ($tagsData as $tagData) {
            $tag = Tag::firstOrCreate(
                [
                    'name' => $tagData['name'],
                ],
                [
                    'slug' => $tagData['slug'],
                ]
            );

            if (! $trailer->film->tags->contains($tag)) {
                $trailer->film->tags()->attach($tag);
            }
        }
    }
}
