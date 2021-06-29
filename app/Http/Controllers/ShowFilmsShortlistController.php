<?php

namespace App\Http\Controllers;

class ShowFilmsShortlistController extends Controller
{
    public function __invoke()
    {
        return view('shortlist');
    }
}
