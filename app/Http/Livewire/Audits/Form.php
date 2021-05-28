<?php

namespace App\Http\Livewire\Audits;

use App\Actions\Audits\CreateAudit;
use App\Models\Adviser;
use App\Models\Audit;
use App\Models\Client;
use Carbon\Carbon;
use Livewire\Component;

class Form extends Component
{
    public $input;

    public $audit;

    protected $listeners = ['auditClicked'];

    public function getAdvisersProperty()
    {
        return Adviser::orderBy('name')->get();
    }

    public function getClientsProperty()
    {
        return Client::orderBy('policy_holder')->get();
    }

    public function getClientProperty()
    {
        return Client::find($this->input['client_id']);
    }

    public function mount()
    {
        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.audits.form');
    }

    public function resetInput()
    {
        $this->input = [
            'adviser_id' => '',
            'is_new_client' => '',
            'client_id' => '',
            'policy_holder' => '',
            'policy_no' => '',
            'lead_source' => '',
            'qa' => [
                'adviser_scale' => 10,
                'received_copy' => 'yes',
                'with_policy' => 'yes',
                'confirm_adviser' => 'yes',
                'medical_agreement' => 'yes - refer to notes',
                'bank_account_agreement' => 'yes',
                'replace_policy' => 'no',
                'confirm_occupation' => '',
                'received_copy' => 'yes',
                'replacement_is_discussed' => 'yes',
                'is_action_taken' => 'yes',
                'is_new_client' => 'yes',
                'lead_source' => 'Telemarketer',
            ],
        ];
    }

    public function auditClicked(Audit $audit)
    {
        $this->audit = $audit;

        if ($this->audit) {
            $this->answers = $this->audit->qa;
            $this->adviser_id = $this->audit->adviser_id;
        }
    }

    public function submit()
    {
        $this->audit ? $this->updateAudit() : $this->createAudit();
    }

    public function createAudit()
    {
        $action = new CreateAudit();

        $action->create($this->input);

        $this->dispatchBrowserEvent('audit-created', 'Successfully created audit.');

        $this->resetInput();
    }

    public function updateAudit()
    {
        $this->audit->update([
            'adviser_id' => $this->adviser_id,
            'user_id' => auth()->id(),
            'qa' => json_encode($this->answers),
        ]);
        session()->flash('message', 'Successfully Updated Audit.');
        $this->emit('auditUpdate');
    }
}
