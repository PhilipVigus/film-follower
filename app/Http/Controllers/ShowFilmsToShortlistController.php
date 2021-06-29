<?php

namespace App\Http\Controllers;

class ShowFilmsToShortlistController extends Controller
{
    public function __invoke()
    {
        return view('to-shortlist');
    }
}
