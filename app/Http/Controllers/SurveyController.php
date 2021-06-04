<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Survey;
use Illuminate\Support\Str;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class SurveyController extends Controller
{
    public function create()
    {
        return view('surveys.create');
    }

    public function pdf(Client $client = null, Survey $survey)
    {
        if ($client) {
            $survey = $client->surveys()->where('id', $survey->id)->firstOrFail();
        } else {
            $survey = auth()->user()->createdSurveys()->where('id', $survey->id)->firstOrFail();

            $client = $survey->client;
        }

        $pdf = Pdf::loadView('pdfs.survey', [
            'survey' => $survey,
            'client' => $client,
        ]);

        return $pdf->stream(Str::slug('Survey Report - ' . $client->policy_holder . ' - ' . $survey->created_at->format('d-m-Y')) . '.pdf');
    }
}
