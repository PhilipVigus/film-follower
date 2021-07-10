<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class ShowTagController extends Controller
{
    public function __invoke(Tag $tag)
    {
        return view('tag', ['tag' => $tag]);
    }
}
