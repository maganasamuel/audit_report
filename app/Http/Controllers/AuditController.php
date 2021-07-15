<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Client;
use Illuminate\Support\Str;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class AuditController extends Controller
{
    public function create()
    {
        return view('audits.create');
    }

    public function pdf(Client $client = null, Audit $audit)
    {
        if ($client) {
            $audit = $client->audits()->where('id', $audit->id)->firstOrFail();
        } else {
            $audit = auth()->user()->createdAudits()->where('id', $audit->id)->firstOrFail();

            $client = $audit->client;
        }

        $pdf = Pdf::loadView('pdfs.audit', [
            'audit' => $audit,
            'client' => $client,
        ]);

        return $pdf->stream(Str::slug('Client Feedback Report - ' . $client->policy_holder . ' - ' . $audit->created_at->format('d-m-Y')) . '.pdf');
    }
}
