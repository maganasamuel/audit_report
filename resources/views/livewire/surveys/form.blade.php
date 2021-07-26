<form wire:submit.prevent="submit">
  <div class="form-group">
    <div class="form-control">{{ date('d-m-Y') }}</div>
  </div>

  <div class="form-group">
    <label for="adviser_id">Select an Adviser:</label>
    <x-lookup id="survey_adviser_name" value-model="input.adviser_id" label-model="input.adviser_name"
      value-column="id" label-column="name" :items="$this->advisers" placeholder="Select an Adviser" />
    <x-input-error for="adviser_id" />
  </div>

  <div class="form-group">
    <label for="surveyClient">Is this a new client?</label>
    <select id="surveyClient" class="form-control"
      wire:model.defer="input.is_new_client">
      <option value="">-</option>
      <option value="yes">Yes</option>
      <option value="no">No</option>
    </select>
    <x-input-error for="is_new_client" />
  </div>

  <div class="form-row" id="surveyNewClient" wire:ignore.self>
    <div class="form-group col-md-6">
      <input type="text" placeholder="Policy Holder"
        class="form-email form-control" id="policy_holder"
        wire:model.lazy="input.policy_holder">
      <x-input-error for="policy_holder" />
    </div>

    <div class="form-group col-md-6">
      <input type="text" id="policy_no"
        placeholder="Policy No" class="form-control"
        wire:model.lazy="input.policy_no">
      <x-input-error for="policy_no" />
    </div>
  </div>

  <div class="form-row" id="surveyOldClient" wire:ignore.self>
    <div class="form-group col-md-6">
      <x-lookup id="survey_client_policy_holder" value-model="input.client_id"
        label-model="input.client_policy_holder"
        value-column="id" label-column="policy_holder" :items="$this->clients"
        placeholder="Select a Client" />
      <x-input-error for="client_id" />
      <x-input-error for="client_id" />
    </div>

    <div class="form-group col-md-6">
      <div class="form-control">
        {{ $this->client ? $this->client->policy_no : '' }}
      </div>
    </div>
  </div>

  <div class="form-group">
    <label>Did the client answer the call?
      <select id="survey_client_answered" class="form-control form-control-sm d-inline-block w-auto ml-2"
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
    @foreach (config('services.survey.questions') as $key => $question)
      @if ($key == 'adviser' && ($input['sa']['cancellation_discussed'] ?? '') != 'yes')
        @continue
      @endif

      @if ($key == 'policy_explained' && ($input['sa']['policy_replaced'] ?? '') != 'yes')
        @continue
      @endif

      @if ($key == 'risk_explained' && ($input['sa']['policy_replaced'] ?? '') != 'yes')
        @continue
      @endif

      @if ($key == 'benefits_discussed' && ($input['sa']['cancellation_discussed'] ?? '') != 'yes')
        @continue
      @endif

      @if ($key == 'insurer' && ($input['sa']['policy_replaced'] ?? '') != 'yes')
        @continue
      @endif

      <div class="form-group">
        <label for="{{ $key }}">
          {{ $question['text'] }}
        </label>

        @if (in_array($question['type'], ['text', 'text-optional']))
          <textarea id="{{ $key }}" type="text"
            class="form-control" rows="2"
            wire:model.defer="input.sa.{{ $key }}">
        </textarea>
        @endif

        @if ($question['type'] == 'boolean')
          <select id="{{ $key }}" class="form-control"
            wire:model.lazy="input.sa.{{ $key }}">
            <option value="">Select an Answer</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>
          </select>
        @endif

        @if ($question['type'] == 'select')
          <select id="{{ $key }}" class="form-control"
            wire:model.defer="input.sa.{{ $key }}">
            <option value="">Select an Answer</option>
            @foreach ($question['values'] as $value)
              <option value="{{ $value['value'] }}">
                {{ $value['label'] }}
              </option>
            @endforeach
          </select>
        @endif

        <x-input-error for="sa.{{ $key }}" />
      </div>
    @endforeach
  @endif

  <div class="form-group mt-4">
    <button type="submit" class="btn btn-primary"><i
        class="fa fa-circle-o-notch fa-spin d-none m-1"></i>{{ $surveyId ? 'Save' : 'Submit' }}</button>
  </div>
</form>

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
  <script type="text/javascript">
    const handleSurveyFormLoad = () => {
      const resetClient = () => {
        $('#surveyNewClient').addClass('d-none');
        $('#surveyOldClient').addClass('d-none');
      }

      const clientChange = () => {
        resetClient();

        if ($('#surveyClient').val() == 'yes') {
          $('#surveyNewClient').removeClass('d-none');
        } else if ($('#surveyClient').val() == 'no') {
          $('#surveyOldClient').removeClass('d-none');
        }
      };

      const initializeDateTimePicker = () => {
        $('.datetimepicker').flatpickr();

        $('.datetimepicker').removeAttr('readonly');
      }

      clientChange();

      $('#surveyClient').change(function() {
        clientChange();
      });

      $(document).on('survey-created', function() {
        clientChange();
      });

      $(document).on('edit-survey', function() {
        clientChange();

        initializeDateTimePicker();
      });

      $(document).on('client-not-answered', function() {
        initializeDateTimePicker();
      });
    }

    window.addEventListener('load', handleSurveyFormLoad);
  </script>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>
@endpush
