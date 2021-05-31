<form wire:submit.prevent="submit">
  <div class="form-group">
    <div class="form-control">{{ date('d-m-Y') }}</div>
  </div>

  <div class="form-group">
    <label for="adviser_id">Select an Adviser:</label>
    <select class="form-control" id="adviser_id"
      wire:model.lazy="input.adviser_id">
      <option value="">-</option>
      @foreach ($this->advisers as $adviser)
        <option value="{{ $adviser->id }}">
          {{ $adviser->name }}
        </option>
      @endforeach
    </select>
    <x-input-error for="adviser_id" />
  </div>

  <div class="form-group">
    <label for="is_new_client">Is this a new client?</label>
    <select id="is_new_client" class="form-control"
      wire:model.lazy="input.is_new_client">
      <option value="">-</option>
      <option value="yes">Yes</option>
      <option value="no">No</option>
    </select>
    <x-input-error for="is_new_client" />
  </div>

  @if ($input['is_new_client'] == 'yes')
    <div class="form-row" id="new">
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
  @endif

  @if ($input['is_new_client'] == 'no')
    <div class="form-row">
      <div class="form-group col-md-6">
        <select id="policy_holder" name="policy_holder"
          class="form-control" wire:model.lazy="input.client_id">
          <option value="">-</option>
          @foreach ($this->clients as $client)
            <option value="{{ $client->id }}">
              {{ $client->policy_holder }}
            </option>
          @endforeach
        </select>
        <x-input-error for="client_id" />
      </div>

      <div class="form-group col-md-6">
        <div class="form-control">
          {{ $this->client ? $this->client->policy_no : '' }}
        </div>
      </div>
    </div>
  @endif

  @foreach (config('services.survey.questions') as $key => $question)
    @if ($key == 'adviser' && $input['sa']['cancellation_discussed'] != 'yes')
      @continue
    @endif

    @if ($key == 'policy_explained' && $input['sa']['policy_replaced'] != 'yes')
      @continue
    @endif

    @if ($key == 'risk_explained' && $input['sa']['policy_replaced'] != 'yes')
      @continue
    @endif

    @if ($key == 'benefits_discussed' && $input['sa']['cancellation_discussed'] != 'yes')
      @continue
    @endif

    @if ($key == 'insurer' && $input['sa']['policy_replaced'] != 'yes')
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

  <div class="form-group mt-4">
    <button type="submit" class="btn btn-primary"><i
        class="fa fa-circle-o-notch fa-spin d-none m-1"></i>{{ $surveyId ? 'Save' : 'Submit' }}</button>
  </div>
</form>
