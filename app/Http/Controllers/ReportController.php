<?php

namespace App\Http\Controllers;

use App\Models\Adviser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function pdf($type, Adviser $adviser, $startDate, $endDate, Request $request)
    {
        $parameters = [
            'type' => $type,
            'adviser' => $adviser,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        Validator::make($parameters, [
            'type' => ['required', 'in:audit,survey'],
            'start_date' => ['required', 'date_format:d-m-Y'],
            'end_date' => ['required', 'date_format:d-m-Y'],
        ], [], [
            'type' => 'Report Type',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ])->validate();

        $filename = $adviser->name . '_reports_' . Carbon::now()->timestamp . '.pdf';

        $startDate = Carbon::createFromFormat('d-m-Y', $startDate);

        $endDate = Carbon::createFromFormat('d-m-Y', $endDate);

        $data = [
            'adviser' => $adviser,
            'date' => date('D, jS F, Y h:i A'),
            'start_date' => $startDate->copy()->format('d/m/Y'),
            'end_date' => $endDate->copy()->format('d/m/Y'),
            'total_clients' => $adviser->totalClients($startDate, $endDate),
            'service_rating' => $adviser->serviceRating($startDate, $endDate),
            'disclosure_percentage' => $adviser->disclosurePercentage($startDate, $endDate),
            'payment_percentage' => $adviser->paymentPercentage($startDate, $endDate),
            'policy_replaced_percentage' => $adviser->policyReplacedPercentage($startDate, $endDate),
            'correct_occupation_percentage' => $adviser->correctOccupationPercentage($startDate, $endDate),
            'compliance_percentage' => $adviser->compliancePercentage($startDate, $endDate),
            'replacement_risks_percentage' => $adviser->replacementRisksPercentage($startDate, $endDate),
        ];

        $pdf = Pdf::loadView('pdfs.audit-report', $data);

        return $pdf->stream($filename);
    }
}
