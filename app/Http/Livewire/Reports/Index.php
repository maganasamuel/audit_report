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

    public function getAdvisersProperty()
    {
        return Adviser::where('status', 1)
            ->when(isset($this->input['adviser_name']) && $this->input['adviser_name'], function ($query) {
                $query->where('name', 'like', '%' . $this->input['adviser_name'] . '%');

                return $query;
            })->orderBy('name', 'asc')->get();
    }

    public function getAdviserProperty()
    {
        return Adviser::find($this->input['adviser_id'] ?? '');
    }

    public function render()
    {
        return view('livewire.reports.index');
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
