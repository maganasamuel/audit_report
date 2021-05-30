<?php

namespace App\Http\Livewire\Audits;

use App\Actions\Audits\CreateAudit;
use App\Actions\Audits\UpdateAudit;
use App\Models\Adviser;
use App\Models\Audit;
use App\Models\Client;
use Livewire\Component;

class Form extends Component
{
    public $profileClientId;

    public $auditId;

    public $input;

    protected $listeners = ['editAudit'];

    public function getProfileClientProperty()
    {
        return Client::find($this->profileClientId);
    }

    public function getAuditProperty()
    {
        if ($this->auditId) {
            return $this->profileClient->audits()->findOrFail($this->auditId);
        }

        return;
    }

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

    public function mount($profileClientId = null)
    {
        $this->profileClientId = $profileClientId;

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

    public function editAudit($auditId)
    {
        $this->auditId = $auditId;

        $data = $this->audit->only([
            'adviser_id',
            'client_id',
            'lead_source',
            'qa',
        ]);

        $data['is_new_client'] = 'no';

        $this->input = $data;
    }

    public function submit()
    {
        $this->auditId ? $this->updateAudit() : $this->createAudit();
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
        $action = new UpdateAudit();

        $action->update($this->input, $this->audit);

        $this->emitTo('audits.index', 'auditUpdated');

        $this->dispatchBrowserEvent('audit-updated', 'Succuessfully updated audit.');
    }
}
