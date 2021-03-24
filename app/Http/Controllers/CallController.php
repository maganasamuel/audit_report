<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adviser;
use App\Models\Client;
use App\Models\Audit;
use App\Models\Survey;
use DataTables;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;
use Storage;
use Auth;

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
        $audit->user_id = Auth::user()->id;
        $audit->save();
        
        $client->audits()->attach($audit->id,
        [
          "weekOf" => date('Y-m-d', strtotime($request->weekOf)),
          "lead_source" => $request->lead_source,
        ]);

        $qa = json_decode($client->audits[0]->qa);
        $clients = Client::find($client->id);

        $pdf_title = $clients->policy_holder.date('dmYgi', time()).'.pdf';

        $client->audits()->updateExistingPivot($audit->id,
        [
          "pdf_title" => $pdf_title
        ]);

        $options = new Options();
        $options->set([
          'defaultFont' => 'Helvetica',
          "enable_php" => true
        ]);

        $dompdf = new Dompdf($options);
        
        $data = [
          "clients" => $clients,
          "adviser_name" => $adviser->name,
          "caller_name" => Auth::user()->name,
          "caller_email" => Auth::user()->email,
          "questions" => $qa->questions,
          "answers" => $qa->answers
        ];

        $path = public_path('/pdfs/' . $pdf_title);
        $pdf = PDF::loadView('pdfs.view-pdf', $data)->save($path);

        $content = $pdf->download()->getOriginalContent();
        Storage::put($pdf_title, $pdf->output());

        $message = "Audit #". $audit->id ." has been stored.";

        return $message;
      }
    }

    public function survey(){
      $advisers = Adviser::all();
      return view('calls.survey', compact('advisers'));
    }

    public function show_survey(){
      return view('surveys.index');
    }

    public function fetch_data(Request $request){
      if($request->ajax()){
        $data = Survey::latest()->get();
        return Datatables::of($data)
              ->addIndexColumn()
              ->addColumn('action', function($row){
                $actionBtn = '
                  <form action="" method="GET" target="_blank" class="mr-2">
                    <input type="text" value="'. $row->id .'" name="id" hidden />
                    <button type="submit" rel="tooltip" class="btn btn-info btn-icon btn-sm" data-original-title="" title="" data-id="'. $row->id .'"><i class="far fa-eye pt-1"></i></button>
                  </form>'
                  .
                  '
                  <form action="" method="GET" class="mr-2">
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

    public function store_survey(Request $request){
      if($request->ajax()){
        $survey = new Survey;
        $client = Client::where('policy_holder', $request->policy_holder)->first();
        
        if($client != null){
          $survey->client_id = $client->id;
        } else {
          $new_client = new Client;
          $new_client->policy_holder = $request->policy_holder;
          $new_client->policy_no = $request->policy_no;
          $new_client->save();

          $survey->client_id = $new_client->id;
        }
        $survey->adviser_id = $request->adviser;
        $survey->sa = json_encode($request->survey);
        $survey->save();
        $message = "Successfully added a Survey";

        return $message;
      }
    }

    public function fetch_clients(Request $request){
      if($request->ajax()){
        $clients = Client::all();
        return $clients;
      }
    }
}
