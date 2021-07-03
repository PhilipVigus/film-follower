<?php

namespace App\Http\Controllers;

class ShowFilmsWatchedController extends Controller
{
    public function __invoke()
    {
        return view('watched');
    }
}
