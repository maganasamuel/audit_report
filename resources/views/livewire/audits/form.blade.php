<div>
  <form wire:submit.prevent="submit">
    <div class="form-top mb-4">
      <p>
        INTRODUCTION: Mr/ Mrs Policyholder, my name is <span
          class="text-uppercase"><ins>{{ auth()->user()->name }}</ins></span>.
        I
        am a financial adviser of EliteInsure Ltd.. The reason for
        my SPECIAL call is to inspect the standard of service provided by our
        adviser, ( mention name), and also to ensure that high quality of
        service advise was given to you. It should take approx 5 mins. Would
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

      <div class="form-group">
        <label>Did the client answer the call?
          <select id="client_answered" class="form-control form-control-sm d-inline-block w-auto ml-2"
            wire:model.lazy="input.client_answered">
            <option value="">Select an Answer</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
          <x-input-error for="client_answered" />
        </label>
      </div>

      @if (($input['client_answered'] ?? null) == '0')
        <div class="form-row">
          @foreach ($input['call_attempts'] ?? [] as $index => $callAttempt)
            <div class="form-group col-md-4">
              <label
                for="call_attempt_{{ $index }}">{{ ordinalNumber($index + 1) }}
                Attempt</label>
              <input type="text" class="form-control datetimepicker" data-enable-time="true"
                data-date-format="d/m/Y G:i K" wire:model.defer="input.call_attempts.{{ $index }}" />
              <x-input-error for="call_attempts.{{ $index }}" />
            </div>
          @endforeach
        </div>
      @endif

      <hr>

      @if (($input['client_answered'] ?? 0) == 1)
        @foreach (config('services.audit.questions') as $key => $question)
          @if ($key == 'medical_conditions' && !in_array($input['qa']['medical_agreement'] ?? '', ['yes', 'not sure']))
            @continue
          @endif

          @if ($key == 'replacement_is_discussed' && ($input['qa']['replace_policy'] ?? '') != 'yes')
            @continue
          @endif

          @if ($key == 'occupation' && ($input['qa']['confirm_occupation'] ?? '') != 'no')
            @continue
          @endif

          <div class="form-group">
            @if ($question['text'])
              <label for="{{ $key }}" class="{{ $question['class'] ?? '' }}">
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
      @endif
    </div>

    <div class="form-group mt-4">
      <button type="submit" class="btn btn-primary"><i
          class="fa fa-circle-o-notch fa-spin d-none m-1"></i>{{ $auditId ? 'Save' : 'Submit' }}</button>
    </div>
  </form>
</div>

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

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

      $(document).on('client-not-answered', function() {
        $('.datetimepicker').flatpickr();

        $('.datetimepicker').removeAttr('readonly');
      });
    }

    window.addEventListener('load', handleAuditFormLoad);
  </script>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>
@endpush
