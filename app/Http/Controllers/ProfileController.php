<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.user.edit');
    }
}
