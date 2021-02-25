<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CallController extends Controller
{
    public function audit(){
      return view('calls.audit');
    }

    public function survey(){
      return view('calls.survey');
    }
}
