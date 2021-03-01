<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
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
                $actionBtn = '<button type="button" id="view-client-pdf" rel="tooltip" class="btn btn-info btn-icon btn-sm" data-original-title="" title="" data-id="'. $row->id .'" data-toggle="modal" data-target="#view-client-pdf-modal"><i class="far fa-eye pt-1"></i></a>'
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
    if($request->ajax()){
      $client = Client::find($request->id);
      // dd($client);
      $pdf_title = date('dmYgi', time()).'.pdf';
      $options = new Options();
      $options->set([
        'defaultFont' => 'Helvetica'
      ]);

      $dompdf = new Dompdf($options);
      
      $data = [
        "clients" => $client
      ];

      $pdf = PDF::loadView('pdfs.view-pdf', $data);
      return $pdf->stream($pdf_title);
    }
  }
}
