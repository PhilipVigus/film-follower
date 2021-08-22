<?php

namespace App\Http\Controllers;

class ShowTagsController extends Controller
{
    public function __invoke()
    {
        return view('tags');
    }
}
