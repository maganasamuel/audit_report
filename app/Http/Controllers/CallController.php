<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adviser;

class CallController extends Controller
{
    public function audit(){
      $advisers = Adviser::all();
      return view('calls.audit', compact('advisers'));
    }

    public function store_audit(Request $request){
      
    }

    public function survey(){
      return view('calls.survey');
    }
}
