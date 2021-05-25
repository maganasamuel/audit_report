<?php

namespace App\Http\Livewire;

use App\Models\Adviser;
use Carbon\Carbon;
use Livewire\Component;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

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
        'adviser_id' => 'required',
    ];

    protected $listeners = [
        'selectStartDate' => 'getStartDate',
        'selectEndDate' => 'getEndDate',
    ];

    public function getStartDate($value)
    {
        $this->start_date = $value;
    }

    public function getEndDate($value)
    {
        $this->end_date = $value;
    }

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
    }

    public function onSubmit()
    {
        $this->validate();

        $reportName = $this->adviser->name . '_reports_' . Carbon::now()->timestamp . '.pdf';

        $dateStart = Carbon::parse($this->start_date);

        $dateEnd = Carbon::parse($this->end_date);

        return response()->streamDownload(function () use ($dateStart, $dateEnd) {
            $pdf = Pdf::loadView('reports.pdf', [
                'adviser' => $this->adviser,
                'date' => date('D, jS F, Y h:i A'),
                'start_date' => Carbon::parse($this->start_date)->copy()->format('d/m/Y'),
                'end_date' => Carbon::parse($this->end_date)->copy()->format('d/m/Y'),
                'total_clients' => $this->adviser->totalClients($dateStart, $dateEnd),
                'service_rating' => $this->adviser->serviceRating($dateStart, $dateEnd),
                'disclosure_percentage' => $this->adviser->disclosurePercentage($dateStart, $dateEnd),
                'payment_percentage' => $this->adviser->paymentPercentage($dateStart, $dateEnd),
                'policy_replaced_percentage' => $this->adviser->policyReplacedPercentage($dateStart, $dateEnd),
                'correct_occupation_percentage' => $this->adviser->correctOccupationPercentage($dateStart, $dateEnd),
                'compliance_percentage' => $this->adviser->compliancePercentage($dateStart, $dateEnd),
                'replacement_risks_percentage' => $this->adviser->replacementRisksPercentage($dateStart, $dateEnd),
            ]);

            echo $pdf->stream();
        }, $reportName);
    }

    public function render()
    {
        return view('livewire.report-form');
    }
}
