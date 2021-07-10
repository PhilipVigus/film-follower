<?php

namespace App\Http\Controllers;

class ShowFilmsIgnoredController extends Controller
{
    public function __invoke()
    {
        return view('ignored');
    }
}
