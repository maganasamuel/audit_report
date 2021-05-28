<?php

namespace App\Http\Livewire\Audits;

use App\Models\Audit;
use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class Index extends Component
{
    use WithPagination;

    public $client;

    public $perPage = 10;

    public $search;

    public $sortColumn = [
        'name' => '',
        'direction' => '',
    ];

    public $audit;

    protected $paginationTheme = 'bootstrap';

    public function mount($client)
    {
        $this->client = $client;
    }

    public function render()
    {
        $query = $this->client->audits()
            ->select(
                'audits.id',
                'adviser.name as adviser_name',
                'audits.lead_source',
                'audits.created_at',
                'creator.name as creator_name',
                'updator.name as updator_name'
            )->leftJoin('advisers as adviser', 'adviser.id', 'audits.adviser_id')
            ->leftJoin('users as creator', 'creator.id', 'audits.created_by')
            ->leftJoin('users as updator', 'updator.id', 'audits.updated_by')
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('adviser.name', 'like', '%' . $this->search . '%')
                        ->orWhere('audits.lead_source', 'like', '%' . $this->search . '%')
                        ->when(strtotime($this->search), function ($query) {
                            $query->orWhereBetween('audits.created_at', [
                                Carbon::parse($this->search)->startOfDay()->toDateTimeString(),
                                Carbon::parse($this->search)->endOfDay()->toDateTimeString(),
                            ]);

                            return $query;
                        })->orWhere('creator.name', 'like', '%' . $this->search . '%')
                        ->orWhere('updator.name', 'like', '%' . $this->search . '%');
                });

                return $query;
            });

        if ($this->sortColumn['name'] && $this->sortColumn['direction']) {
            $query->orderBy($this->sortColumn['name'], $this->sortColumn['direction']);
        }

        $audits = $query->paginate($this->perPage);

        return view('livewire.audits.index', compact('audits'));
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($column)
    {
        $sortDirections = [
            '' => 'asc',
            'asc' => 'desc',
            'desc' => '',
        ];

        if ($this->sortColumn['name'] == $column) {
            $this->sortColumn['direction'] = $sortDirections[$this->sortColumn['direction']];
        } else {
            $this->sortColumn['name'] = $column;
            $this->sortColumn['direction'] = 'asc';
        }
    }

    /**
     * Will prompt delete modal
     *
     * @param Audit $audit
     *
     * @return void
     */
    public function onDelete(Audit $audit)
    {
        $this->audit = $audit;
    }

    /**
     *
     * Will confirm deletion
     *
     * @return void
     */
    public function confirmDelete()
    {
        $this->audit->delete();

        session()->flash('message', 'Successfully deleted audit.');

        $this->emit('onConfirmDelete');
    }

    /**
     *
     * This email will be sent to client's manager
     * Discuss if the adviser will be given a copy
     *
     * @param Audit $audit
     * @param Client $client
     *
     * @return void
     */
    public function sendEmail(Audit $audit, Client $client)
    {
        $audit = $client->audits()->where('audit_id', $audit->id)->first();

        $answers = json_decode($audit->qa, true);
        $questions = [

            [
                'question' => 'I understand you recently took out a policy with (fidelity, partners, aia) from one of our advisers Is that correct?',
                'answer' => $answers['with_policy'],
            ],
            [
                'question' => 'Was the adviser by him / herself?',
                'answer' => $answers['confirm_adviser'],
            ],
            [

                'question' => "How would you describe the adviser's standard of service on a scale of 1-10? (10 is the highest)",
                'answer' => $answers['adviser_scale'],
            ],
            [
                'question' => 'As you are aware, non disclosure can lead to non payment of claim. To make sure the correct underwriting takes place , we have noted your current pre-existing medical conditions are',
                'answer' => $answers['medical_conditions'],
            ],
            [
                'question' => 'Is there anything else apart from this not stated?',
                'answer' => $answers['medical_agreement'],
            ],
            [
                'question' => 'We have received authority for all future payments to be direct debited from your bank account? Is this correct?',
                'answer' => $answers['bank_account_agreement'],
            ],
            [
                'question' => 'Is there anything else apart from this not stated?',
                'answer' => $answers['medical_agreement'],
            ],
            [
                'question' => 'Is that correct? ',
                'answer' => $answers['confirm_occupation'],
            ],
            [
                'question' => 'What is your understanding of the benefits of the policy?',
                'answer' => $answers['policy_understanding'],
            ],
            [
                'question' => 'It specified in the authority to proceed that a copy of the disclosure statement was given to you and your insurance planner and or plan/copy of your LAT was e mailed to e mail address John@eliteinsure..co.nz . Did you received them?',
                'answer' => $answers['received_copy'],
            ],
            [
                'question' => 'Do you have any further comments?',
                'answer' => $answers['further_comments'] ?? 'N/A',
            ],

            [
                'question' => 'If replacement, were the risks of replacing this insurance policy explained to you?',
                'answer' => $answers['replacement_is_discussed'],
            ],
            [
                'question' => 'Do you have any further comments?',
                'answer' => $answers['is_action_taken'],
            ],

            [
                'question' => 'Notes: ',
                'answer' => $answers['notes'] ?? 'N/A',
            ],
        ];

        $pdf = Pdf::loadView('pdfs.view-pdf', [
            'weekOf' => $audit->pivot->weekOf,
            'lead_source' => $audit->pivot->lead_source,
            'audit' => $audit,
            'client' => $client,
            'questions' => $questions,
        ]);

        $data['policy_holder'] = $client->policy_holder;
        $data['policy_no'] = $client->policy_no;

        Mail::send('mails.audit-mail', $data, function ($message) use ($data, $pdf) {
            $message->to('admin@eliteinsure.co.nz')
                ->subject('Audit Report')
                ->attachData($pdf->output(), 'audit_report.pdf');
        });

        session()->flash('message', 'Successfully sent email to manager.');
    }
}
