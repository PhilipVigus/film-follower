<?php

namespace App\Support;

use Carbon\Carbon;
use App\Models\Trailer;
use Illuminate\Support\Str;
use Vedmant\FeedReader\Facades\FeedReader;

class RssFeedReader
{
    public static function getLatestItems()
    {
        $rssItems = FeedReader::read(config('film-follower.rss_url'))->get_items();
        $items = [];

        $recentlyDownloadedTrailerGuids = Trailer::query()
            ->orderByDesc('uploaded_at')
            ->limit(config('film-follower.rss_items_per_request'))
            ->get()
            ->pluck('guid')
            ->toArray()
        ;

        foreach ($rssItems as $rssItem) {
            $trailerGuid = self::decodeRssString($rssItem->get_id());

            if (in_array($trailerGuid, $recentlyDownloadedTrailerGuids)) {
                continue;
            }

            $trailerTitle = self::decodeRssString($rssItem->get_title());
            $trailerContent = self::decodeRssString($rssItem->get_content());

            preg_match('/: ([^:]*)$/', $trailerTitle, $trailerType);
            preg_match('/<img src="(.*)"/', $trailerContent, $trailerImage);

            $items[] = [
                'trailer' => [
                    'guid' => $trailerGuid,
                    'title' => $trailerTitle,
                    'slug' => Str::slug($trailerTitle),
                    'type' => $trailerType[1],
                    'image' => $trailerImage[1],
                    'link' => self::decodeRssString($rssItem->get_link()),
                    'uploaded_at' => Carbon::parse($rssItem->get_date()),
                ],
                'film' => self::getFilmData($trailerContent),
            ];
        }

        return $items;
    }

    private static function getFilmData($content)
    {
        preg_match('/Filed Under: <a href="(.*)">(.*)<\/a>/', $content, $filmMatches);

        return [
            'guid' => $filmMatches[1],
            'title' => $filmMatches[2],
            'slug' => Str::slug($filmMatches[2]),
        ];
    }

    private static function decodeRssString($string)
    {
        return mb_convert_encoding($string, 'windows-1252');
    }
}
