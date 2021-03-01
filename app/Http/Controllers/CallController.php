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
        $adviser = Adviser::find($request->adviser);
        $client->policy_holder = $request->policy_holder;
        $client->policy_no = $request->policy_no;
        $client->save();

        $audit->qa = json_encode($request->qa);
        $audit->adviser_id = $request->adviser;
        $audit->save();

        $client->audits()->attach($audit->id,
        [
          "weekOf" => date('Y-m-d', strtotime($request->weekOf)),
          "lead_source" => $request->lead_source,
        ]);

        $message = "Audit #". $audit->id ." has been stored.";

        return $message;
      }
    }

    public function survey(){
      return view('calls.survey');
    }
}
