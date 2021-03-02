<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Adviser;
use DataTables;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;

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
                $actionBtn = '
                  <form action="'.route('pdfs.view_pdf').'" method="GET" target="_blank" class="mr-2">
                    <input type="text" value="'. $row->id .'" name="id" hidden />
                    <button type="submit" rel="tooltip" class="btn btn-info btn-icon btn-sm" data-original-title="" title="" data-id="'. $row->id .'"><i class="far fa-eye pt-1"></i></button>
                  </form>'
                  .
                  '
                  <form action="'.route('mails.send-mail').'" method="GET" target="_blank" class="mr-2">
                    <input type="text" value="'. $row->id .'" name="id" hidden />
                    <button type="submit" rel="tooltip" class="btn btn-primary btn-icon btn-sm" data-original-title="" title="" data-id="'. $row->id .'"><i class="far fa-envelope"></i></button>
                  </form>'
                  .
                  '<button type="button" id="edit-client" rel="tooltip" class="btn btn-success btn-icon btn-sm" data-id="'. $row->id .'" data-original-title="" title="" data-toggle="modal" data-target="#modal-edit-client"><i class="fa fa-edit pt-1"></i></button>'
                  .
                  '<button type="button" id="client-deactivate-confirmation" rel="tooltip" class="btn btn-danger btn-icon btn-sm " data-original-title="" title="" data-id="'. $row->id .'" data-toggle="modal" data-target="#modal-deactivate-client"><i class="fa fa-ban pt-1"></i></button>'
                  ;
                    return $actionBtn;
                  })
              ->rawColumns(['action'])
              ->make(true);
    }
  }

  public function view_pdf(Request $request){
    $client = Client::find($request->id);
    $adviser = Adviser::find($client->audits[0]->adviser_id);
    $qa = json_decode($client->audits[0]->qa);
    
    $pdf_title = $client->policy_holder.date('dmYgi', time()).'.pdf';
    $options = new Options();
    $options->set([
      'defaultFont' => 'Helvetica'
    ]);

    $dompdf = new Dompdf($options);
    
    $data = [
      "clients" => $client,
      "adviser_name" => $adviser->name,
      "questions" => $qa->questions,
      "answers" => $qa->answers
    ];

    $pdf = PDF::loadView('pdfs.view-pdf', $data);
    return $pdf->stream($pdf_title);
  }
}
