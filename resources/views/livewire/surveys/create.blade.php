<form wire:submit.prevent="createSurvey" id="survey-form">
  <div class="form-group">
    <div class="form-control">{{ date('d-m-Y') }}</div>
  </div>

  <div class="form-group">
    <label>Select an Adviser:</label>
    <select class="form-control" name="adviser" id="adviser"
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
    <label>Is this a new client?</label>
    <select id="client-question" class="form-control"
      wire:model.lazy="input.new_client">
      <option value="">-</option>
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select>
    <x-input-error for="new_client" />
  </div>

  @if (isset($input['new_client']))
    @if ($input['new_client'] == 'Yes')
      <div class="form-row" id="new">
        <div class="form-group col-md-6">
          <input type="text" name="policy_holder" placeholder="Policy Holder"
            class="form-email form-control" id="policy_holder"
            wire:model.lazy="input.policy_holder">
          <x-input-error for="policy_holder" />
        </div>

        <div class="form-group col-md-6">
          <input type="text" name="policy_no" id="policy_no"
            placeholder="Policy No" class="form-control"
            wire:model.lazy="input.policy_no">
          <x-input-error for="policy_no" />
        </div>
      </div>
    @elseif($input['new_client'] == 'No')
      <div class="form-row" id="current">
        <div class="form-group col-lg-6 col-md-12">
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

        <div class="form-group col-lg-6 col-md-12">
          <div class="form-control">
            {{ $this->client ? $this->client->policy_no : '' }}
          </div>
        </div>
      </div>
    @endif
  @endif

  @foreach ($input['sa']['questions'] as $index => $question)
    @if (isset($showQuestions[$index]) && !$this->{'showQuestion' . $showQuestions[$index]})
      @continue
    @endif

    <div class="form-group">
      <label for="question_{{ $index }}">
        {{ $question['text'] }}
      </label>
      @if ($question['type'] == 'boolean')
        <select id="question_{{ $index }}" class="form-control"
          wire:model.lazy="input.sa.answers.{{ $index }}">
          <option value="">-</option>
          <option value="Yes">Yes</option>
          <option value="No">No</option>
        </select>
      @elseif($question['type'] == 'text')
        <input id="question_{{ $index }}" type="text"
          class="form-control"
          wire:model.debounce="input.sa.answers.{{ $index }}">
      @endif
      <x-input-error for="{{ 'sa.answers.' . $index }}" />
    </div>
  @endforeach

  @if ($this->showSubmit)
    <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
      wire:target="createSurvey">
      <i class="fa fa-circle-o-notch fa-spin m-1" style="font-size: 10px;"
        wire:loading wire:target="createSurvey">&nbsp;</i>
      Submit
    </button>
  @endif
</form>
