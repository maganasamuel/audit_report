<?php

namespace App\Http\Livewire\Reports;

use App\Models\Adviser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Index extends Component
{
    public $input = [
        'report_type' => 'audit',
    ];

    public $start_date;

    public $end_date;

    public $adviser_id;

    public $fsp_no;

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

    public function getAdvisersProperty()
    {
        return Adviser::orderBy('name', 'asc')->get();
    }

    public function getAdviserProperty()
    {
        return Adviser::find($this->input['adviser_id'] ?? '');
    }

    public function render()
    {
        return view('livewire.reports.index');
    }

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

    public function generateReport()
    {
        $data = Validator::make($this->input, [
            'report_type' => ['required', 'in:audit,survey'],
            'adviser_id' => ['required', 'exists:advisers,id'],
            'start_date' => ['required', 'date_format:d/m/Y'],
            'end_date' => ['required', 'date_format:d/m/Y'],
        ], [], [
            'report_type' => 'Report Type',
            'adviser_id' => 'Adviser',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ])->validate();

        $url = route('reports.pdf', [
            'type' => $data['report_type'],
            'adviser' => $data['adviser_id'],
            'startDate' => Carbon::createFromFormat('d/m/Y', $data['start_date'])->format('d-m-Y'),
            'endDate' => Carbon::createFromFormat('d/m/Y', $data['end_date'])->format('d-m-Y'),
        ]);

        $this->dispatchBrowserEvent('report-generated', $url);
    }
}
