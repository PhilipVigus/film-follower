<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Film;
use App\Models\User;
use App\Models\Trailer;
use App\Support\RssFeedReader;
use Illuminate\Support\Collection;

class GetTrailersController extends Controller
{
    public function __invoke()
    {
        $rssDataItems = RssFeedReader::getLatestItems();

        $users = User::all();

        foreach ($rssDataItems as $itemData) {
            $film = Film::firstOrCreate(
                [
                    'guid' => $itemData['film']['guid'],
                ],
                [
                    'title' => $itemData['film']['title'],
                    'slug' => $itemData['film']['slug'],
                ]
            );

            $this->addFilmToUsers($film, $users);

            $itemData['trailer']['film_id'] = $film->id;

            $trailer = Trailer::create($itemData['trailer']);

            $this->createTags($itemData['tags'], $trailer);
        }

        return Trailer::count();
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

            $trailer->tags()->attach($tag);

            if (! $trailer->film->tags->contains($tag)) {
                $trailer->film->tags()->attach($tag);
            }
        }
    }
}
