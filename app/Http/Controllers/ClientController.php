<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Adviser;
use App\Models\Audit;
use App\Models\Survey;
use App\Models\User;
use DataTables;

use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;
use File;
use Storage;

class ClientController extends Controller
{
  public function index(){
    $clients = Client::all();
    return view('profile.clients.index', compact('clients'));
  }

  public function fetch_data(Request $request){
    if($request->ajax()){
      $data = Client::latest()->get();
      $survey = Survey::all();
      $audit_client = DB::select('select client_id from audit_client');
      
      $clients_with_survey = [];
      $clients_with_audit = [];

      foreach($data as $client){
        foreach($survey as $surv){
          if($client->id == $surv->client_id){
            array_push($clients_with_survey, $client->id);
          }
        }
      }

      foreach($data as $client){
        foreach($audit_client as $ac){
          if($client->id == $ac->client_id){
            array_push($clients_with_audit, $client->id);
          }
        }
      }

      $actionBtn = "";
      return Datatables::of($data)
              ->addIndexColumn()
              ->addColumn('action', function($row) use ($clients_with_survey, $clients_with_audit, $actionBtn, $survey){
                if(!in_array($row->id, $clients_with_audit)){
                  $actionBtn .= '<div class="d-flex my-2">
                    <form action="'.route('pdfs.view_pdf').'" method="GET" target="_blank" class="mr-2">
                      <input type="text" value="'. $row->id .'" name="id" hidden />
                      <button type="submit" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="View Audit" class="btn btn-info btn-icon btn-sm" data-original-title="" title="" data-id="'. $row->id .'" disabled><i class="far fa-eye pt-1"></i></button>
                    </form>'
                    .
                    '<form action="'.route('mails.send-mail').'" method="GET" class="mr-2">
                      <input type="text" value="'. $row->id .'" name="id" hidden />
                      <button type="submit" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Audit" class="btn btn-primary btn-icon btn-sm" data-original-title="" title="" data-id="'. $row->id .'" disabled><i class="far fa-envelope"></i></button>
                    </form>'
                    .
                    '<button type="button" id="edit-client" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Audit" class="btn btn-success btn-icon btn-sm" data-id="'. $row->id .'" data-original-title="" title="" data-toggle="modal" data-target="#edit-client-pdf-modal" disabled><i class="fa fa-edit pt-1"></i></button>'
                    .
                    '<button type="button" id="client-delete-confirmation" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Audit" class="btn btn-danger btn-icon btn-sm " data-original-title="" title="" data-id="'. $row->id .'" data-toggle="modal" data-target="#modal-delete-client" disabled><i class="fa fa-ban pt-1"></i></button></div>'
                    ;
                } else {
                  $actionBtn .= '<div class="d-flex my-2">
                    <form action="'.route('pdfs.view_pdf').'" method="GET" target="_blank" class="mr-2">
                      <input type="text" value="'. $row->id .'" name="id" hidden />
                      <button type="submit" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="View Audit" class="btn btn-info btn-icon btn-sm" data-original-title="" title="" data-id="'. $row->id .'"><i class="far fa-eye pt-1"></i></button>
                    </form>'
                    .
                    '<form action="'.route('mails.send-mail').'" method="GET" class="mr-2">
                      <input type="text" value="'. $row->id .'" name="id" hidden />
                      <button type="submit" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Audit" class="btn btn-primary btn-icon btn-sm" data-original-title="" title="" data-id="'. $row->id .'" ><i class="far fa-envelope"></i></button>
                    </form>'
                    .
                    '<button type="button" id="edit-client" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Audit" class="btn btn-success btn-icon btn-sm" data-id="'. $row->id .'" data-original-title="" title="" data-toggle="modal" data-target="#edit-client-pdf-modal" ><i class="fa fa-edit pt-1"></i></button>'
                    .
                    '<button type="button" id="client-delete-confirmation" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Audit" class="btn btn-danger btn-icon btn-sm " data-original-title="" title="" data-id="'. $row->id .'" data-toggle="modal" data-target="#modal-delete-client" ><i class="fa fa-ban pt-1"></i></button></div>'
                    ;                
                }

                if(!in_array($row->id, $clients_with_survey)){
                    $actionBtn .=
                    '<div class="d-flex my-2">
                    <form action="'.route('pdfs.view_survey').'" method="GET" target="_blank" class="mr-2">
                      <input type="text" value="'. $row->id .'" name="id" hidden />
                      <button type="submit" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="View Survey" class="btn btn-warning btn-icon btn-sm" data-original-title="" title="" data-id="'. $row->id .'" disabled><i class="fas fa-poll-h pt-1"></i></button>
                    </form>'
                    .
                    '<button type="button" id="edit-survey" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Survey" class="btn btn-success btn-icon btn-sm" data-id="'. $row->id .'" data-original-title="" title="" data-toggle="modal" data-target="#edit-survey-pdf-modal" disabled><i class="fas fa-pencil-alt pt-1"></i></button>'
                    ;

                    $actionBtn .= 
                          '<button type="button" id="survey-cancel-confirmation" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel Survey" class="btn btn-danger btn-icon btn-sm " data-original-title="" title="" data-id="'. $row->id .'" data-toggle="modal" data-target="#modal-cancel-survey" disabled><i class="fa fa-ban pt-1"></i></button></div>';
                } else {
                  $actionBtn .=
                  '<div class="d-flex my-2">
                    <form action="'.route('pdfs.view_survey').'" method="GET" target="_blank" class="mr-2">
                      <input type="text" value="'. $row->id .'" name="id" hidden />
                      <button type="submit" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="View Survey" class="btn btn-warning btn-icon btn-sm" data-original-title="" title="" data-id="'. $row->id .'"><i class="fas fa-poll-h pt-1"></i></button>
                    </form>'
                    .
                    '<button type="button" id="edit-survey" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Survey" class="btn btn-success btn-icon btn-sm" data-id="'. $row->id .'" data-original-title="" title="" data-toggle="modal" data-target="#edit-survey-pdf-modal" ><i class="fas fa-pencil-alt pt-1"></i></button>'
                    ;
                    $actionBtn .= 
                          '<button type="button" id="survey-cancel-confirmation" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel Survey" class="btn btn-danger btn-icon btn-sm " data-original-title="" title="" data-id="'. $row->id .'" data-toggle="modal" data-target="#modal-cancel-survey"><i class="fa fa-ban pt-1"></i></button></div>';

                    // foreach($survey as $surv){
                    //   if($surv->client_id == $row->id && $surv->is_cancelled != 1){ 
                    //     $actionBtn .= 
                    //       '<button type="button" id="survey-cancel-confirmation" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel Survey" class="btn btn-danger btn-icon btn-sm " data-original-title="" title="" data-id="'. $row->id .'" data-toggle="modal" data-target="#modal-cancel-survey"><i class="fa fa-ban pt-1"></i></button></div>';
                    //   } else if($surv->client_id == $row->id && $surv->is_cancelled != 0){
                    //     $actionBtn .= 
                    //       '<button type="button" id="survey-cancel-confirmation" rel="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Reactivate Survey" class="btn btn-primary btn-icon btn-sm " data-original-title="" title="" data-id="'. $row->id .'" data-toggle="modal" data-target="#modal-reactivate-survey"><i class="fas fa-sync-alt pt-1"></i></button></div>';
                    //   }
                    // }
                }

                

                return $actionBtn;
              })
              ->rawColumns(['action'])
              ->make(true);
    }
  }

  public function view_pdf(Request $request){
    $client = Client::find($request->id);
    $adviser = Adviser::find($client->audits[0]->adviser_id);
    $user = User::find($client->audits[0]->user_id);
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
      "caller_name" => $user->name,
      "caller_email" => $user->email,
      "questions" => $qa->questions,
      "answers" => $qa->answers
    ];

    $path = public_path('/pdfs/' . $pdf_title);
    $pdf = PDF::loadView('pdfs.view-pdf', $data)->save($path);
    $content = $pdf->download()->getOriginalContent();
    Storage::put($pdf_title, $pdf->output());

    return $pdf->stream($pdf_title);
  }

  public function view_survey(Request $request){
    $client = Client::find($request->id);
    $survey = Survey::where('client_id', $request->id)->first();
    // dd($survey);
    $adviser = Adviser::find($survey->adviser_id);
    $sa = json_decode($survey->sa);
    $pdf_title = $client->policy_holder.date('dmYgi', time()).'.pdf';

    $options = new Options();
    $options->set([
      'defaultFont' => 'Helvetica'
    ]);

    $data = [
      "clients" => $client,
      "survey" => $survey,
      "adviser" => $adviser,
      "questions" => $sa->questions,
      "answers" => $sa->answers
    ];

    $dompdf = new Dompdf($options);
    $path = public_path('/pdfs/' . $pdf_title);
    $pdf = PDF::loadView('pdfs.view-survey', $data)->save($path);
    return $pdf->stream($pdf_title);
  }

  public function edit_pdf(Request $request){
    if($request->ajax()){
      $client = Client::where(["id" => $request->id])->with('audits')->first();
      $advisers = Adviser::orderBy('name')->get();
      $adviser = Adviser::find($client->audits[0]->adviser_id);
      $weekOf = date("d-m-Y", strtotime($client->audits[0]->pivot->weekOf));
      $qa = json_decode($client->audits[0]->qa);
      
      return response()->json([
        "clients" => $client,
        "advisers" => $advisers,
        "adviser" => $adviser,
        "weekOf" => $weekOf,
        "answers" => $qa->answers
      ]);
    }
  }

  public function update_pdf(Request $request){
    if($request->ajax()){
      $client = Client::find($request->c_id);
      
      if(File::exists(public_path('pdfs/'.$client->audits[0]->pivot->pdf_title))){
        $old_file = $client->audits[0]->pivot->pdf_title;
      } else {
        $message = "The file doesn't exists.";

        return $message;
      }

      $client->policy_holder = $request->policy_holder;
      $client->policy_no = $request->policy_no;
      $client->save();

      $audit = Audit::find($request->au_id);
      $audit->qa = json_encode($request->qa);
      $audit->adviser_id = $request->ad_id;
      $audit->save();

      $client->audits()->updateExistingPivot($request->au_id, [
        "weekOf" => date('Y-m-d', strtotime($request->weekOf)),
        "lead_source" => $request->lead_source
      ]);

      $adviser = Adviser::find($client->audits[0]->adviser_id);
      $user = User::find($client->audits[0]->user_id);
      $qa = json_decode($client->audits[0]->qa);

      $pdf_title = $request->policy_holder.date('dmYgi', time()).'.pdf';
      $options = new Options();
      $options->set([
        'defaultFont' => 'Helvetica'
      ]);

      $dompdf = new Dompdf($options);
      
      $data = [
        "clients" => $client,
        "adviser_name" => $adviser->name,
        "caller_name" => $user->name,
        "caller_email" => $user->email,
        "questions" => $qa->questions,
        "answers" => $qa->answers
      ];

      $path = public_path('/pdfs/' . $pdf_title);
      $pdf = PDF::loadView('pdfs.view-pdf', $data)->save($path);
      $content = $pdf->download()->getOriginalContent();
      Storage::put($pdf_title, $pdf->output());

      //Delete old file
      File::delete(public_path('pdfs/'.$old_file));
      Storage::delete($old_file);

      $client->audits()->updateExistingPivot($request->au_id, [
        "pdf_title" => $pdf_title
      ]);

      $message = "Audit #". $request->au_id ." has been updated.";

      return $message;
    }
  }

  public function confirm_client_delete(Request $request){
    if($request->ajax()){
      $client = Client::find($request->id);
      $audit = $client->audits[0]->id;
      
      return json_encode($client, $audit);
    }
  }

  public function delete_client(Request $request){
    if($request->ajax()){
      $client = Client::find($request->id);
      $audit = Audit::find($request->audit_id);
      
      if(File::exists(public_path('pdfs/'.$client->audits[0]->pivot->pdf_title))){
        File::delete(public_path('pdfs/'.$client->audits[0]->pivot->pdf_title));
        Storage::delete($client->audits[0]->pivot->pdf_title);
      } else {
        dd('File doesn\'t exist'); 
      }

      $message = 'Audit #'.$audit->id.' has been deleted.';
      $client->audits()->detach($request->id);
      $client->delete();
      $audit->delete();

      return $message;
    }
  }
}
