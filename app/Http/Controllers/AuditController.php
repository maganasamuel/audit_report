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

    public function pdf(Client $client, Audit $audit)
    {
        $audit = $client->audits()->where('id', $audit->id)->firstOrFail();

        $pdf = Pdf::loadView('pdfs.audit', [
            'audit' => $audit,
            'client' => $client,
        ]);

        return $pdf->stream(Str::slug('Audit Report - ' . $client->policy_holder . ' - ' . $audit->created_at->format('d-m-Y')) . '.pdf');
    }
}
