<?php

namespace App\Http\Livewire;

use App\Helpers\Report;
use App\Models\Adviser;
use Carbon\Carbon;
use Livewire\Component;
use Barryvdh\DomPDF\Facade as PDF;

class ReportForm extends Component
{
    public $advisers;

    public $start_date;

    public $end_date;

    public $adviser_id;

    public $fsp_no;

    public $report_type = 'audit';

    public $adviser;

    protected $rules = [

        'report_type' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'adviser_id' => 'required'
    ];

    public function updatedAdviserId($value)
    {

        $this->adviser = Adviser::find($value);

        $this->fsp_no = $this->adviser->fsp_no;

    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function mount()
    {
        $this->advisers = Adviser::orderBy('name', 'asc')->get();

        $this->start_date = Carbon::now()->format('d/m/y');

        $this->end_date = Carbon::now()->addMonth()->format('d/m/y');

    }

    public function onSubmit()
    {
        $this->validate();

 
        $reportName = $this->adviser->name .'_reports_' .Carbon::now()->timestamp .'.pdf';

        return response()->streamDownload(function () {
            $pdf= PDF::loadView('reports.pdf', [
                'adviser' => $this->adviser,
                'date' => Carbon::now()->toDayDateTimeString(),
                'start_date' => Carbon::createFromFormat('d/m/y', $this->start_date)->format('d/m/y'),
                'end_date' => Carbon::createFromFormat('d/m/y', $this->start_date)->format('d/m/y'),
                'total_clients' => $this->adviser->totalClients(),
                'service_rating' => $this->adviser->serviceRating(),
                'disclosure_percentage' => $this->adviser->disclosurePercentage(),
                'payment_percentage' => $this->adviser->paymentPercentage(),
                'policy_replaced_percentage' => $this->adviser->policyReplacedPercentage(),
                'correct_occupation_percentage' => $this->adviser->correctOccupationPercentage(),
                'compliance_percentage' => $this->adviser->compliancePercentage(),
                'replacement_risks_percentage' => $this->adviser->replacementRisksPercentage()
            ]);

            echo $pdf->stream();
        }, $reportName);

    }

    public function render()
    {
        return view('livewire.report-form');
    }
}
