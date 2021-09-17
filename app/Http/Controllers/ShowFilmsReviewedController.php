<?php

namespace App\Http\Controllers;

class ShowFilmsReviewedController extends Controller
{
    public function __invoke()
    {
        return view('reviewed');
    }
}
