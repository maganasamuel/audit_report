<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class PDFController extends Controller
{
    public function pdf(Client $client, Audit $audit)
    {
        $audit = $client->audits()->where('id', $audit->id)->firstOrFail();

        $pdf = Pdf::loadView('pdfs.view-pdf', [
            'audit' => $audit,
            'client' => $client,
        ]);

        return $pdf->stream(Str::slug('Audit Report - ' . $client->policy_holder . ' - ' . $audit->created_at->format('d-m-Y')) . '.pdf');
    }
}
