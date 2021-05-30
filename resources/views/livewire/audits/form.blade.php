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
      <div class="row">
        <div class="form-group col-lg-6 col-md-12">
          <select class="form-control" name="adviser" id="adviser"
            wire:model.defer="input.adviser_id">
            <option value="" selected>Select an Adviser</option>
            @foreach ($this->advisers as $adviser)
              <option value="{{ $adviser->id }}">{{ $adviser->name }}
              </option>
            @endforeach
          </select>
          <x-input-error for="adviser_id" />
        </div>
        <div class="form-group col-lg-6 col-md-12">
          <select class="form-control" name="lead_source" id="lead_source"
            wire:model.defer="input.lead_source">
            <option value="">Select a Lead Source</option>
            @foreach (config('services.lead_source') as $leadSource)
              <option value="{{ $leadSource }}">{{ $leadSource }}</option>
            @endforeach
          </select>
          <x-input-error for="lead_source" />
        </div>
      </div>
      <div class="form-group">
        <label class="text-sm">Is this a new client?</label>
        <select id="client-question" class="form-control"
          wire:model.lazy="input.is_new_client">
          <option value="">Choose an option</option>
          <option value="yes">Yes</option>
          <option value="no">No</option>
        </select>
        <x-input-error for="is_new_client" />
      </div>

      @if ($input['is_new_client'] == 'yes')
        <div class="form-row">
          <div class="form-group col-md-6">
            <input type="text" class="form-control"
              placeholder="Enter Policy Holder"
              wire:model.lazy="input.policy_holder">
            <x-input-error for="policy_holder" />
          </div>
          <div class="form-group col-md-6">
            <input type="text" class="form-control"
              placeholder="Enter Policy No."
              wire:model.lazy="input.policy_no">
            <x-input-error for="policy_no" />
          </div>
        </div>
      @endif

      @if ($input['is_new_client'] == 'no')
        <div class="form-row">
          <div class="form-group col-md-6">
            <select class="form-control" wire:model.lazy="input.client_id">
              <option value="">Select a Client</option>
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
              {{ $this->client->policy_no ?? 'Policy Number' }}
            </div>
          </div>
        </div>
      @endif

      <hr>

      @foreach (config('services.audit.questions') as $key => $question)
        <div class="form-group">
          <label for="{{ $key }}">{{ $question['text'] }}</label>

          @if (in_array($question['type'], ['text', 'text-optional']))
            <textarea id="{{ $key }}" class="form-control" rows="2"
              wire:model.defer="input.qa.{{ $key }}">
            </textarea>
          @endif

          @if ($question['type'] == 'boolean')
            <select id="{{ $key }}" class="form-control"
              wire:model.defer="input.qa.{{ $key }}">
              <option value="">Select an Answer</option>
              <option value="yes">Yes</option>
              <option value="no">No</option>
            </select>
          @endif

          @if ($question['type'] == 'select')
            <select id="{{ $key }}" class="form-control"
              wire:model.defer="input.qa.{{ $key }}">
              <option value="">Select an Answer</option>
              @foreach ($question['values'] as $value)
                <option value="{{ $value['value'] }}">
                  {{ $value['label'] }}
                </option>
              @endforeach
            </select>
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
