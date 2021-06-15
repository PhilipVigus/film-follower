<?php

namespace App\Http\Controllers;

class ShowFilmsController extends Controller
{
    public function __invoke()
    {
        return view('films');
    }
}
