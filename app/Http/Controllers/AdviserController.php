<?php

namespace App\Http\Controllers;

class AdviserController extends Controller
{
    public function index()
    {
        return view('profile.advisers.index');
    }
}
