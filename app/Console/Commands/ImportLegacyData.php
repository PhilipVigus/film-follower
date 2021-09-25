<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Tag;
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

    /** @array */
    protected $ratingMapping = [
        1 => 1,
        2 => 3,
        3 => 5,
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /** @var int */
    public function handle()
    {
        $trailers = DB::connection('mongodb')->table('trailers')->get();

        foreach ($trailers as $trailer) {
            $filmGuid = $this->decodeRssString(Str::beforeLast($trailer['guid'], '/'));

            if (! Str::contains($filmGuid, 'http://')) {
                continue;
            }

            $filmTitle = $this->decodeRssString(Str::beforeLast($trailer['title'], ':'));
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

            $me = $users->first();

            if (isset($trailer['rating'])) {
                $rating = $this->ratingMapping[$trailer['rating']];
                $comment = $trailer['notes'] ?? '';

                $me->priorities()->create(['film_id' => $film->id, 'rating' => $rating, 'comment' => $comment]);
                $me->films()->updateExistingPivot($film->id, ['status' => Film::SHORTLISTED]);
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

            $tags = explode(', ', $trailer['tags']);

            foreach ($tags as $tagData) {
                $tag = Tag::firstOrCreate(
                    [
                        'name' => $this->decodeRssString($tagData),
                    ],
                );

                if (! $film->tags->contains($tag)) {
                    $film->tags()->attach($tag);
                }
            }
        }

        return 0;
    }

    private function decodeRssString($string)
    {
        return $this->fixWrongUTF8Encoding(mb_convert_encoding($string, 'UTF-8'));
    }

    private function fixWrongUTF8Encoding($inputString)
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
