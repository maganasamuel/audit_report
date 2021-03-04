<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DataTables;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
      return view('dash');
    }

    public function home(){
      if(Auth::user()->status == "Deactivated"){
        Auth::logout();
        return redirect()->route('login')
                ->with('status', "You've been terminated. Please contact administrator.")
                ->withErrors(['username' => "You've been deactivated."]);
      }
      return view('users.home');
    }

    public function fetch_data(Request $request){
      if($request->ajax()){
          $data = User::latest()->get();
          return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('action', function($row){
                    $actionBtn = '<button type="button" id="edit-user" rel="tooltip" class="btn btn-success btn-icon btn-sm" data-id="'. $row->id .'" data-original-title="" title="" data-toggle="modal" data-target="#modal-edit-user"><i class="fa fa-edit pt-1"></i></button>
                      <button type="button" id="user-deactivate-confirmation" rel="tooltip" class="btn btn-danger btn-icon btn-sm " data-original-title="" title="" data-id="'. $row->id .'" data-toggle="modal" data-target="#modal-deactivate-user"><i class="fa fa-ban pt-1"></i></button>
                    ';
                      return $actionBtn;
                    })
                ->rawColumns(['action'])
                ->make(true);
      }
    }

    public function new_user(Request $request){
      if($request->ajax()){
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->created_at = now();
        $user->updated_at = now();
        $user->is_admin = $request->is_admin;

        $user->save();
        $message = $request->name." with email address of ". $request->email ." has been added!";

        return $message;
      }
    }

    public function edit_user(Request $request){
      if($request->ajax()){
        $user = User::find($request->id);
        return json_encode($user);
      }
    }

    public function update_user(Request $request){
      if($request->ajax()){
        $user = User::find($request->id);

        $message = "User's name ". $user->name .", email ". $user->email ." and admin privilege has been updated";

        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_admin = $request->is_admin;

        $user->save();

        return $message;
      }
    }

    public function confirm_user_deactivate(Request $request){
      if($request->ajax()){
        $user = User::find($request->id);
        return json_encode($user);
      }
    }

    public function deactivate_user(Request $request){
      if($request->ajax()){
        $user = User::find($request->id);
        $user->status = "Deactivated";
        $message = $user->name. " has been Deactivated.";

        $user->save();
        return $message;
      }
    }
}
