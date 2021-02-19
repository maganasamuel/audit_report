<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Adviser;

class AdviserController extends Controller
{
    public function index(){
      $advisers = Adviser::all();
      return view('profile.advisers.index', compact('advisers'));
    }

    public function fetch_data(Request $request){
      if($request->ajax()){
        $data = DB::table('advisers')->orderBy('id', 'desc')->get();
        echo json_encode($data);
      }
    }

    public function new_adviser(Request $request){
      if($request->ajax()){
        $adviser = new Adviser;
        $adviser->name = $request->name;
        $adviser->fsp_no = $request->fsp_no;
        $adviser->status = "Active";

        $adviser->save();
        $message = $request->name." with fsp number ".$request->fsp_no." has been added!";
        return $message;
      }
    }

}
