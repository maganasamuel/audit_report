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

  public function edit_adviser(Request $request){
    if($request->ajax()){
      $adviser = Adviser::find($request->id);
      return json_encode($adviser);
    }
  }

  public function update_adviser(Request $request){
    if($request->ajax()){
      $adviser = Adviser::find($request->id);
      $message = "Adviser's name ". $adviser->name ." and fsp_number ". $adviser->fsp_no ." has been updated to ". $request->name ." and ". $request->fsp_no;
      $adviser->name = $request->name;
      $adviser->fsp_no = $request->fsp_no;

      $adviser->save();

      return $message;
    }
  }

  public function confirm_deactivate(Request $request){
    if($request->ajax()){
      $adviser = Adviser::find($request->id);
      return json_encode($adviser);
    }
  }

  public function deactivate_adviser(Request $request){
    if($request->ajax()){
      $adviser = Adviser::find($request->id);
      $adviser->status = "Terminated";
      $message = $adviser->name. " has been Terminated.";

      $adviser->save();
      return $message;
    }
  }
}
