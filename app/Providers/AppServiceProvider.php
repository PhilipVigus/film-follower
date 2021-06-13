<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        Collection::macro('getNth', function ($n) {
            return $this->slice($n, 1)->first();
        });
    }

    public function boot()
    {
    }
}
