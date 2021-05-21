<?php

namespace App\Http\Livewire;

use App\Models\Audit;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade as PDF;

class AuditsTable extends Component
{

    use WithPagination;

	public $perPage = 10;

	public $search;

	public $sortField = 'pdf_title';

	public $sortAsc = true;

    public $client;

    public $updateMode = false;

    public $audit;

    public function mount($client)
    {
        $this->client = $client;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
	{

        $this->sortAsc === $field ? $this->sortAsc = !$this->sortAsc : $this->sortField = $field;
	}


    public function onEdit(Audit $audit)
    {   
        $this->audit = $audit;

        $this->updateMode = true;

        $this->emit('auditClicked', $audit->id);
    }

    public function onDelete(Audit $audit)
    {
        $this->audit = $audit;
    }


    public function confirmDelete()
    {
        $this->audit->delete();

        session()->flash('message', 'Successfully deleted audit.');

        $this->emit('onConfirmDelete');
    }

    public function sendEmail(Audit $audit, Client $client)
    {
        $audit = $client->audits()->where('audit_id', $audit->id)->first();

        $answers = json_decode($audit->qa, true);
        $questions = [

            [
                'question' => 'I understand you recently took out a policy with (fidelity, partners, aia) from one of our advisers Is that correct?',
                'answer' => $answers['with_policy']
            ],
            [
                'question' => 'Was the adviser by him / herself?',
                'answer' => $answers['confirm_adviser']
            ],
            [

                'question' => "How would you describe the adviser's standard of service on a scale of 1-10? (10 is the highest)",
                'answer' => $answers['adviser_scale']
            ],
            [
                'question' => 'As you are aware, non disclosure can lead to non payment of claim. To make sure the correct underwriting takes place , we have noted your current pre-existing medical conditions are',
                'answer' => $answers['medical_conditions']
            ],
            [
                'question' => 'Is there anything else apart from this not stated?',
                'answer' => $answers['medical_agreement']
            ],
            [
                'question' => 'We have received authority for all future payments to be direct debited from your bank account? Is this correct?',
                'answer' => $answers['bank_account_agreement']
            ],
            [
                'question' => 'Is there anything else apart from this not stated?',
                'answer' => $answers['medical_agreement']
            ],
            [
                'question' => 'Is that correct? ',
                'answer' => $answers['confirm_occupation']
            ],
            [
                'question' => 'What is your understanding of the benefits of the policy?',
                'answer' => $answers['policy_understanding']
            ],
            [
                'question' => 'It specified in the authority to proceed that a copy of the disclosure statement was given to you and your insurance planner and or plan/copy of your LAT was e mailed to e mail address John@eliteinsure..co.nz . Did you received them?',
                'answer' => $answers['received_copy']
            ],
            [
                'question' => 'Do you have any further comments?',
                'answer' => isset($answers['further_comments']) ? $answers['further_comments'] : 'N/A'
            ],

            [
                'question' => 'If replacement, were the risks of replacing this insurance policy explained to you?',
                'answer' => $answers['replacement_is_discussed']
            ],
            [
                'question' => 'Do you have any further comments?',
                'answer' =>  $answers['is_action_taken']
            ],

            [
                'question' => 'Notes: ',
                'answer' =>  isset($answers['notes']) ? $answers['notes'] : 'N/A'
            ]
        ];


        $pdf= PDF::loadView('pdfs.view-pdf', [

            'weekOf' => $audit->pivot->weekOf,
            'lead_source' => $audit->pivot->lead_source,
            'audit' => $audit,
            'client' => $client,
            'questions' => $questions
        ]);
   
        $data['policy_holder'] = $client->policy_holder;
        $data['policy_no'] = $client->policy_no;
  
  
        Mail::send('mails.audit-mail', $data, function($message)use($data, $pdf) {
            $message->to('admin@eliteinsure.co.nz')
                    ->subject('Audit Report')
                    ->attachData($pdf->output(), "audit_report.pdf");
        });

        session()->flash('message', 'Successfully sent email to manager.');
    }

    public function render()
    {
        $this->search = strtolower($this->search);
        
    	$audits = $this->client->audits()
            ->whereRaw('lower(pdf_title) like (?)',["%{$this->search}%"])
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.audits-table',[

            'audits' => $audits->paginate($this->perPage)
        ]);
    }
}
