<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Adviser;
use App\Models\Audit;
use App\Models\Survey;
use App\Models\User;
use Carbon\Carbon;

use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;

use File;
use Storage;

class ReportController extends Controller
{
  public function index(){
    $advisers = Adviser::orderBy('name')->get();
    return view('reports.index', compact('advisers'));
  }


  public function fetch_adviser(Request $request){
    if($request->ajax()){
      $adviser = Adviser::find($request->id );
      
      return $adviser;
    }
  }

  public function view_pdf(Request $request){
    $adviser = Adviser::find($request->adviser);
    $date = date('d-m-Y');

    $startDate = Carbon::parse($request->startDate)->startOfDay();
    $endDate = Carbon::parse($request->endDate)->endOfDay();

    $clients = Audit::where('adviser_id', $adviser->id)->count();
    $qa = Audit::where('adviser_id', $adviser->id)->whereBetween('created_at', [$startDate, $endDate])->get();
    
    $question3 = [];
    $question4 = [];
    $question5 = [];
    $question6 = [];
    $question7 = [];
    $question8 = [];
    $question9 = [];
    
    foreach($qa as $q){
      $test = json_decode($q->qa);
      array_push($question3, $test->answers[2]/10);
      array_push($question4, $test->answers[3]);
      array_push($question5, $test->answers[4]);
      array_push($question6, $test->answers[5]);
      array_push($question7, $test->answers[6]);
      array_push($question8, $test->answers[8]);
      array_push($question9, $test->answers[10]);
    }

    $avg_rating = round((array_sum($question3)/count($question3))*100, 2);
    $perc_cdc = round(($this->no_positive($question4)/$clients)*100, 2);
    $perc_cpm = round(($this->yes_positive($question5)/$clients)*100, 2);
    $perc_cbr = round(($this->yes_positive($question6)/$clients)*100, 2);
    $perc_cpco = round(($this->yes_positive($question7)/$clients)*100, 2);
    $perc_cdrc = round(($this->yes_positive($question8)/$clients)*100, 2);
    $perc_errb = round(($this->yes_positive($question9)/$clients)*100, 2);

    $data = [
      "adviser" => $adviser,
      "date" => $date,
      "date_range" => date('d/m/Y', strtotime($request->startDate)) . " - " . date('d/m/Y', strtotime($request->endDate)),
      "subtitle" => ucwords($request->report_type),
      "clients" => $clients,
      "qa" => $qa,
      "avg_rating" => $avg_rating,
      "perc_cdc" => $perc_cdc,
      "perc_cpm" => $perc_cpm,
      "perc_cbr" => $perc_cbr,
      "perc_cpco" => $perc_cpco,
      "perc_cdrc" => $perc_cdrc,
      "perc_errb" => $perc_errb,
    ];

    $pdf_title = $adviser->name.date('dmYgi', time()).'.pdf';
    $options = new Options();
    $options->set([
      'defaultFont' => 'Helvetica'
    ]);

    $dompdf = new Dompdf($options);

    $path = public_path('/pdfs/' . $pdf_title);
    $pdf = PDF::loadView('reports.pdf', $data)->save($path);
    $content = $pdf->download()->getOriginalContent();
    Storage::put($pdf_title, $pdf->output());
    return $pdf->stream($pdf_title);
  }

  function no_positive($array){
    $total_avg = 0;

    foreach($array as $a){
      if($a == "no"){
        $total_avg++;
      }
    }

    return $total_avg;
  }

  function yes_positive($array){
    $total_avg = 0;

    foreach($array as $a){
      if($a == "yes"){
        $total_avg++;
      }
    }

    return $total_avg;
  }
}
