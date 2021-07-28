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
        $rssItems = FeedReader::read(config('film-follower.rss-url'))->get_items();
        $items = [];

        // dd(self::fixWrongUTF8Encoding(mb_convert_encoding($rssItems[3]->get_content(), 'UTF-8')), mb_convert_encoding($rssItems[6]->get_content(), 'UTF-8'));

        $recentlyDownloadedTrailerGuids = Trailer::query()
            ->orderByDesc('uploaded_at')
            ->limit(config('film-follower.rss-items-per-request'))
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
                    'type' => $trailerType[1],
                    'image' => $trailerImage[1],
                    'link' => self::decodeRssString($rssItem->get_link()),
                    'uploaded_at' => Carbon::parse($rssItem->get_date()),
                ],
                'film' => self::getFilmData($trailerContent),
                'tags' => self::getTagsData($trailerContent),
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
        return self::fixWrongUTF8Encoding(mb_convert_encoding($string, 'UTF-8'));
    }

    private static function getTagsData($content)
    {
        if (self::trailerHasTags($content)) {
            preg_match_all('/<a href=".*?">(.*?)<\/a>/', explode('Tags: ', $content)[1], $tags);

            return array_map(function ($tagName) {
                return [
                    'name' => $tagName,
                    'slug' => Str::slug($tagName),
                ];
            }, $tags[1]);
        }

        return [];
    }

    private static function trailerHasTags($content)
    {
        return 2 === count(explode('Tags: ', $content));
    }

    /** I'm not 100% sure why this function is even needed. Whatever encoding variation I tried in the decodeRssString
     * function didn't always work. Encoding to windows-1252 fixed most problems, but there were still issues with
     * certain characters, which the database wouldn't allow to be saved. Encoding to UTF-8 worked for many characters
     * but there were certain encoding issues that the function below fixes *shrug*
     *
     * This function is shamelessly stolen from a gist currently available here:
     * https://gist.github.com/kasperkamperman/198c6389840532b96069ba6a776d69e6
     *
     * The author's homepage is available here:
     * https://www.kasperkamperman.com/
     */
    private static function fixWrongUTF8Encoding($inputString)
    {
        // code source:  https://github.com/devgeniem/wp-sanitize-accented-uploads/blob/master/plugin.php#L152
        // table source: http://www.i18nqa.com/debug/utf8-debug.html

        $fix_list = [
            // 3 char errors first
            'â€š' => '‚', 'â€ž' => '„', 'â€¦' => '…', 'â€¡' => '‡',
            'â€°' => '‰', 'â€¹' => '‹', 'â€˜' => '‘', 'â€™' => '’',
            'â€œ' => '“', 'â€¢' => '•', 'â€“' => '–', 'â€”' => '—',
            'â„¢' => '™', 'â€º' => '›', 'â‚¬' => '€',
            // 2 char errors
            'Ã‚' => 'Â', 'Æ’' => 'ƒ', 'Ãƒ' => 'Ã', 'Ã„' => 'Ä',
            'Ã…' => 'Å', 'â€' => '†', 'Ã†' => 'Æ', 'Ã‡' => 'Ç',
            'Ë†' => 'ˆ', 'Ãˆ' => 'È', 'Ã‰' => 'É', 'ÃŠ' => 'Ê',
            'Ã‹' => 'Ë', 'Å’' => 'Œ', 'ÃŒ' => 'Ì', 'Å½' => 'Ž',
            'ÃŽ' => 'Î', 'Ã‘' => 'Ñ', 'Ã’' => 'Ò', 'Ã“' => 'Ó',
            'â€' => '”', 'Ã”' => 'Ô', 'Ã•' => 'Õ', 'Ã–' => 'Ö',
            'Ã—' => '×', 'Ëœ' => '˜', 'Ã˜' => 'Ø', 'Ã™' => 'Ù',
            'Å¡' => 'š', 'Ãš' => 'Ú', 'Ã›' => 'Û', 'Å“' => 'œ',
            'Ãœ' => 'Ü', 'Å¾' => 'ž', 'Ãž' => 'Þ', 'Å¸' => 'Ÿ',
            'ÃŸ' => 'ß', 'Â¡' => '¡', 'Ã¡' => 'á', 'Â¢' => '¢',
            'Ã¢' => 'â', 'Â£' => '£', 'Ã£' => 'ã', 'Â¤' => '¤',
            'Ã¤' => 'ä', 'Â¥' => '¥', 'Ã¥' => 'å', 'Â¦' => '¦',
            'Ã¦' => 'æ', 'Â§' => '§', 'Ã§' => 'ç', 'Â¨' => '¨',
            'Ã¨' => 'è', 'Â©' => '©', 'Ã©' => 'é', 'Âª' => 'ª',
            'Ãª' => 'ê', 'Â«' => '«', 'Ã«' => 'ë', 'Â¬' => '¬',
            'Ã¬' => 'ì', 'Â®' => '®', 'Ã®' => 'î', 'Â¯' => '¯',
            'Ã¯' => 'ï', 'Â°' => '°', 'Ã°' => 'ð', 'Â±' => '±',
            'Ã±' => 'ñ', 'Â²' => '²', 'Ã²' => 'ò', 'Â³' => '³',
            'Ã³' => 'ó', 'Â´' => '´', 'Ã´' => 'ô', 'Âµ' => 'µ',
            'Ãµ' => 'õ', 'Â¶' => '¶', 'Ã¶' => 'ö', 'Â·' => '·',
            'Ã·' => '÷', 'Â¸' => '¸', 'Ã¸' => 'ø', 'Â¹' => '¹',
            'Ã¹' => 'ù', 'Âº' => 'º', 'Ãº' => 'ú', 'Â»' => '»',
            'Ã»' => 'û', 'Â¼' => '¼', 'Ã¼' => 'ü', 'Â½' => '½',
            'Ã½' => 'ý', 'Â¾' => '¾', 'Ã¾' => 'þ', 'Â¿' => '¿',
            'Ã¿' => 'ÿ', 'Ã€' => 'À',
            // 1 char errors last
            'Ã' => 'Á', 'Å' => 'Š', 'Ã' => 'Í', 'Ã' => 'Ï',
            'Ã' => 'Ð', 'Ã' => 'Ý', 'Ã' => 'à', 'Ã­' => 'í',
        ];

        $error_chars = array_keys($fix_list);
        $real_chars = array_values($fix_list);

        return str_replace($error_chars, $real_chars, $inputString);
    }
}
