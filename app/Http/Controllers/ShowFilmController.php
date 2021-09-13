<?php

namespace App\Http\Controllers;

use App\Models\Film;

class ShowFilmController extends Controller
{
    public function __invoke(Film $film)
    {
        return view('film', ['film' => $film]);
    }
}
