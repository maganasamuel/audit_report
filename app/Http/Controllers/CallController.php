<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adviser;
use App\Models\Client;
use App\Models\Audit;
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
          'defaultFont' => 'Helvetica'
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
      return view('calls.survey');
    }
}
