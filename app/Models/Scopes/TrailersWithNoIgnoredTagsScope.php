<?php

namespace App\Models\Scopes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class TrailersWithNoIgnoredTagsScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (! Auth::check()) {
            return $builder;
        }

        $builder->where(function ($query) {
            $query->whereDoesntHave('tags', function ($query) {
                $query->whereIn(
                    'id',
                    Auth::user()->ignoredTrailerTags->pluck('id')
                );
            })->orDoesntHave('tags');
        });
    }
}
