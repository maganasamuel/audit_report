<?php

namespace App\Http\Controllers;

use App\Models\Adviser;
use App\Models\Client;
use App\Models\Survey;
use Auth;
use DataTables;
use File;
use Illuminate\Http\Request;
use PDF;
use Storage;

class SurveyController extends Controller
{
    public function create()
    {
        return view('calls.survey');
    }

    public function show_survey()
    {
        return view('surveys.index');
    }

    public function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $data = Survey::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                  <form action="" method="GET" target="_blank" class="mr-2">
                    <input type="text" value="' . $row->id . '" name="id" hidden />
                    <button type="submit" rel="tooltip" class="btn btn-primary btn-icon btn-sm" data-original-title="" title="" data-id="' . $row->id . '"><i class="far fa-eye pt-1"></i></button>
                  </form>'
                  .
                  '
                  <form action="" method="GET" class="mr-2">
                    <input type="text" value="' . $row->id . '" name="id" hidden />
                    <button type="submit" rel="tooltip" class="btn btn-primary btn-icon btn-sm" data-original-title="" title="" data-id="' . $row->id . '"><i class="far fa-envelope"></i></button>
                  </form>'
                  .
                  '<button type="button" id="edit-client" rel="tooltip" class="btn btn-primary btn-icon btn-sm" data-id="' . $row->id . '" data-original-title="" title="" data-toggle="modal" data-target="#edit-client-pdf-modal"><i class="fa fa-edit pt-1"></i></button>'
                  .
                  '<button type="button" id="client-delete-confirmation" rel="tooltip" class="btn btn-primary btn-icon btn-sm " data-original-title="" title="" data-id="' . $row->id . '" data-toggle="modal" data-target="#modal-delete-client"><i class="fa fa-ban pt-1"></i></button>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function fetch_clients(Request $request)
    {
        if ($request->ajax()) {
            $clients = Client::all();

            return $clients;
        }
    }

    public function edit_pdf(Request $request)
    {
        if ($request->ajax()) {
            $client = Client::find($request->id);
            $survey = Survey::where('client_id', $request->id)->first();
            $advisers = Adviser::orderBy('name')->get();
            $adviser = Adviser::find($survey->adviser_id);
            $sa = json_decode($survey->sa);

            return response()->json([
                'clients' => $client,
                'sa' => $sa,
                'adviser' => $adviser,
                'advisers' => $advisers,
                'survey' => $survey,
                'survey_date' => date('d-m-Y', strtotime($survey->created_at)),
            ]);
        }
    }

    public function update_pdf(Request $request)
    {
        if ($request->ajax()) {
            $survey = Survey::find($request->survey_id);
            $client = Client::find($survey->client_id);

            if (File::exists(public_path('pdfs/' . $survey->survey_pdf))) {
                $old_file = $survey->survey_pdf;
            } else {
                $message = "The file doesn't exists.";

                return $message;
            }

            $pdf_title = 'survey' . $client->policy_holder . date('dmYgi', time()) . '.pdf';
            $survey->updated_by = Auth::user()->name;
            $survey->survey_pdf = $pdf_title;
            $survey->adviser_id = $request->adviser;
            $survey->sa = $request->sa;
            $survey->save();
            $message = 'Successfully updated Survey.';
            // dd($survey->sa);
            $sa = $survey->sa;
            $adviser = Adviser::find($request->adviser);

            $options = new Options();
            $options->set([
                'defaultFont' => 'Helvetica',
            ]);

            $data = [
                'clients' => $client,
                'survey' => $survey,
                'adviser' => $adviser,
                'questions' => $sa['questions'],
                'answers' => $sa['answers'],
            ];

            $path = public_path('/pdfs/' . $pdf_title);
            $pdf = PDF::loadView('pdfs.view-survey', $data)->save($path);

            $content = $pdf->download()->getOriginalContent();
            Storage::put($pdf_title, $pdf->output());

            File::delete(public_path('pdfs/' . $old_file));
            Storage::delete($old_file);

            $message = 'Survey #' . $survey->id . ' has been updated.';

            return $message;
        }
    }

    public function confirm_cancel_survey(Request $request)
    {
        if ($request->ajax()) {
            $client = Client::find($request->id);

            return $client;
        }
    }

    public function cancel_survey(Request $request)
    {
        if ($request->ajax()) {
            $client = Client::find($request->id);
            $survey = Survey::where('client_id', $request->id)->first();

            if (File::exists(public_path('pdfs/' . $survey->survey_pdf))) {
                File::delete(public_path('pdfs/' . $survey->survey_pdf));
                Storage::delete($survey->survey_pdf);
            } else {
                dd('File doesn\'t exist');
            }

            $survey->delete();

            $message = 'Successfully cancelled the Survey for ' . $client->policy_holder . '.';

            return $message;
        }
    }
}
