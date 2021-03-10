<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Audit;
use App\Models\Client;
use DataTables;
use Auth;

class SpecificUserController extends Controller
{
    public function fetch_data(Request $request){
      if($request->ajax()){
        $c_id = []; //client_id
        $user = User::all();
        $audit = Audit::where('user_id', Auth::user()->id)->get();

        foreach($audit as $index => $a){
          array_push($c_id, $audit[$index]->clients[0]->pivot->client_id);
        }

        $clients = Client::whereIn('id', $c_id)->get();
        $data = $clients;
        return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('action', function($row){
                    $actionBtn = '
                  <form action="'.route('pdfs.view_pdf').'" method="GET" target="_blank" class="mr-2">
                    <input type="text" value="'. $row->id .'" name="id" hidden />
                    <button type="submit" rel="tooltip" class="btn btn-info btn-icon btn-sm" data-original-title="" title="" data-id="'. $row->id .'"><i class="far fa-eye pt-1"></i></button>
                  </form>'
                  .
                  '
                  <form action="'.route('mails.send-mail').'" method="GET" class="mr-2">
                    <input type="text" value="'. $row->id .'" name="id" hidden />
                    <button type="submit" rel="tooltip" class="btn btn-primary btn-icon btn-sm" data-original-title="" title="" data-id="'. $row->id .'"><i class="far fa-envelope"></i></button>
                  </form>'
                  .
                  '<button type="button" id="edit-client" rel="tooltip" class="btn btn-success btn-icon btn-sm" data-id="'. $row->id .'" data-original-title="" title="" data-toggle="modal" data-target="#edit-client-pdf-modal"><i class="fa fa-edit pt-1"></i></button>'
                  .
                  '<button type="button" id="client-delete-confirmation" rel="tooltip" class="btn btn-danger btn-icon btn-sm " data-original-title="" title="" data-id="'. $row->id .'" data-toggle="modal" data-target="#modal-delete-client"><i class="fa fa-ban pt-1"></i></button>'
                  ;
                      return $actionBtn;
                    })
                ->rawColumns(['action'])
                ->make(true);
      }
    }
}
