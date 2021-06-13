<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Trailer;
use App\Support\RssFeedReader;

class GetTrailersController extends Controller
{
    public function __invoke()
    {
        $rssDataItems = RssFeedReader::getLatestItems();

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

            $itemData['trailer']['film_id'] = $film->id;

            Trailer::create($itemData['trailer']);
        }

        return Trailer::count();
    }
}
