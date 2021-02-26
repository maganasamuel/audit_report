<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adviser;
use App\Models\Client;
use App\Models\Audit;

class CallController extends Controller
{
    public function audit(){
      $advisers = Adviser::all();
      return view('calls.audit', compact('advisers'));
    }

    public function store_audit(Request $request){
      if($request->ajax()){
        $client = new Client;
        $audit = new Audit;

        $client->policy_holder = $request->policy_holder;
        $client->policy_no = $request->policy_no;
        $client->save();

        $audit->weekOf = date('Y-m-d', strtotime($request->weekOf));
        $audit->adviser_id = $request->adviser;
        $audit->lead_source = $request->lead_source;
        $audit->policy_holder_id = $client->id;
        $audit->qa = json_encode($request->qa);
        $audit->save();

        $message = "Audit #". $audit->id ." has been stored.";

        return $message;
      }
    }

    public function survey(){
      return view('calls.survey');
    }
}
