<div>
  <form wire:submit.prevent="submit">
    <div class="form-top mb-4">
      <p>
        INTRODUCTION: Mr/ Mrs Policyholder, my name is <span
          class="text-uppercase"><ins>{{ auth()->user()->name }}</ins></span>.
        I
        am the Client Relationship manager with EliteInsure Ltd.. The reason for
        my SPECIAL call is to inspect the standard of service provided by our
        adviser, ( mention name), and also to ensure that high quality of
        service and advise was given to you. It should take approx 5 mins. Would
        that be alright?
      </p>
    </div>
    <hr>
    <div class="form-bottom">
      <div class="row">
        <div class="form-group col-lg-12 col-md-12">
          <h5 class="text-sm">
            {{ \Carbon\Carbon::now()->toFormattedDateString() }}</h5>
        </div>
      </div>
      <div class="form-group">
        <x-lookup id="audit_adviser_name" value-model="input.adviser_id" label-model="input.adviser_name"
          value-column="id" label-column="name" :items="$this->advisers" placeholder="Select an Adviser" />
        <x-input-error for="adviser_id" />
      </div>
      <div class="form-group">
        <label class="text-sm">Is this a new client?</label>
        <select id="auditClient" class="form-control"
          wire:model.defer="input.is_new_client">
          <option value="">Choose an option</option>
          <option value="yes">Yes</option>
          <option value="no">No</option>
        </select>
        <x-input-error for="is_new_client" />
      </div>

      <div class="form-row" id="auditNewClient" wire:ignore.self>
        <div class="form-group col-md-6">
          <input type="text" class="form-control"
            placeholder="Enter Policy Holder"
            wire:model.defer="input.policy_holder">
          <x-input-error for="policy_holder" />
        </div>
        <div class="form-group col-md-6">
          <input type="text" class="form-control"
            placeholder="Enter Policy No."
            wire:model.defer="input.policy_no">
          <x-input-error for="policy_no" />
        </div>
      </div>

      <div class="form-row" id="auditOldClient" wire:ignore.self>
        <div class="form-group col-md-6">
          <x-lookup id="audit_client_policy_holder" value-model="input.client_id"
            label-model="input.client_policy_holder"
            value-column="id" label-column="policy_holder" :items="$this->clients"
            placeholder="Select a Client" />
          <x-input-error for="client_id" />
        </div>
        <div class="form-group col-md-6">
          <div class="form-control">
            {{ $this->client->policy_no ?? 'Policy Number' }}
          </div>
        </div>
      </div>

      <hr>

      @foreach (config('services.audit.questions') as $key => $question)
        @if ($key == 'medical_conditions' && !in_array($input['qa']['medical_agreement'], ['yes', 'not sure']))
          @continue
        @endif

        @if ($key == 'replacement_is_discussed' && $input['qa']['replace_policy'] != 'yes')
          @continue
        @endif

        @if ($key == 'occupation' && $input['qa']['confirm_occupation'] != 'no')
          @continue
        @endif

        <div class="form-group">
          @if ($question['text'])
            <label for="{{ $key }}">
              {{ $question['text'] }}
              @if ($question['type'] == 'boolean')
                <select id="{{ $key }}"
                  class="form-control form-control-sm d-inline-block w-auto ml-2"
                  wire:model.lazy="input.qa.{{ $key }}">
                  <option value="">Select an Answer</option>
                  <option value="yes">Yes</option>
                  <option value="no">No</option>
                </select>
              @endif

              @if ($question['type'] == 'select')
                <select id="{{ $key }}"
                  class="form-control form-control-sm d-inline-block w-auto ml-2"
                  wire:model.lazy="input.qa.{{ $key }}">
                  <option value="">Select an Answer</option>
                  @foreach ($question['values'] as $value)
                    <option value="{{ $value['value'] }}">
                      {{ $value['label'] }}
                    </option>
                  @endforeach
                </select>
              @endif
            </label>
          @endif

          @if (in_array($question['type'], ['text', 'text-optional']))
            <textarea id="{{ $key }}" class="form-control" rows="2"
              wire:model.defer="input.qa.{{ $key }}">
            </textarea>
          @endif

          <x-input-error for="qa.{{ $key }}" />
        </div>
      @endforeach
    </div>

    <div class="form-group mt-4">
      <button type="submit" class="btn btn-primary"><i
          class="fa fa-circle-o-notch fa-spin d-none m-1"></i>{{ $auditId ? 'Save' : 'Submit' }}</button>
    </div>
  </form>
</div>

@push('scripts')
  <script type="text/javascript">
    const handleAuditFormLoad = () => {
      const resetClient = () => {
        $('#auditNewClient').addClass('d-none');
        $('#auditOldClient').addClass('d-none');
      }

      const clientChange = () => {
        resetClient();

        if ($('#auditClient').val() == 'yes') {
          $('#auditNewClient').removeClass('d-none');
        } else if ($('#auditClient').val() == 'no') {
          $('#auditOldClient').removeClass('d-none');
        }
      };

      clientChange();

      $('#auditClient').change(function() {
        clientChange();
      });

      $(document).on('audit-created', function() {
        clientChange();
      });

      $(document).on('edit-audit', function() {
        clientChange();
      });
    }

    window.addEventListener('load', handleAuditFormLoad);
  </script>
@endpush
