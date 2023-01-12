<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function list()
    {
        return ['tags' => Tag::all()->pluck('name')];
    }
}
