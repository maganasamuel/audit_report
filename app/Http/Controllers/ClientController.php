<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use DataTables;

class ClientController extends Controller
{
  public function index(){
    $clients = Client::all();
    return view('profile.clients.index', compact('clients'));
  }

  public function fetch_data(Request $request){
    if($request->ajax()){
      $data = Client::latest()->get();
      return Datatables::of($data)
              ->addIndexColumn()
              ->addColumn('action', function($row){
                $actionBtn = '<button type="button" id="edit-client" rel="tooltip" class="btn btn-success btn-icon btn-sm" data-id="'. $row->id .'" data-original-title="" title="" data-toggle="modal" data-target="#modal-edit-client"><i class="fa fa-edit pt-1"></i></button>
                  <button type="button" id="client-deactivate-confirmation" rel="tooltip" class="btn btn-danger btn-icon btn-sm " data-original-title="" title="" data-id="'. $row->id .'" data-toggle="modal" data-target="#modal-deactivate-client"><i class="fa fa-ban pt-1"></i></button>
                ';
                    return $actionBtn;
                  })
              ->rawColumns(['action'])
              ->make(true);
    }
  }
}
