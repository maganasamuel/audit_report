<div>
  <x-delete-modal id="deleteSurveyModal{{ $componentId }}" />

  <div class="d-flex justify-content-between pt-4">
    <x-page.range wire:model="perPage" />
    <div>
      <input wire:model.debounce="search" type="text" class="form-control"
        placeholder="Search Surveys">
    </div>
  </div>

  <div class="table-responsive py-4">
    <table class="table table-flush">
      <thead class="thead-light">
        <tr>
          <th>#</th>
          <th>
            <a wire:click.prevent="sortBy('adviser_name')" href="#"
              role="button">
              Adviser
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="adviser_name" />
            </a>
          </th>
          @if (!$clientId)
            <th>
              <a wire:click.prevent="sortBy('policy_holder')" href="#"
                role="button">
                Policy Holder
                <x-sort-indicator :sort-column="$sortColumn"
                  column-name="policy_holder" />
              </a>
            </th>
            <th>
              <a wire:click.prevent="sortBy('policy_no')" href="#"
                role="button">
                Policy Number
                <x-sort-indicator :sort-column="$sortColumn"
                  column-name="policy_no" />
              </a>
            </th>
          @endif
          <th>
            <a wire:click.prevent="sortBy('created_at')" href="#"
              role="button">
              Date Called
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="created_at" />
            </a>
          </th>
          @if ($clientId)
            <th>
              <a wire:click.prevent="sortBy('creator_name')" href="#"
                role="button">
                Caller
                <x-sort-indicator :sort-column="$sortColumn"
                  column-name="creator_name" />
              </a>
            </th>
          @elseif(auth()->user()->is_admin)
            <th>
              <a wire:click.prevent="sortBy('creator_name')" href="#"
                role="button">
                Caller
                <x-sort-indicator :sort-column="$sortColumn"
                  column-name="creator_name" />
              </a>
            </th>
          @endif
          <th>
            <a wire:click.prevent="sortBy('client_answered')" href="#" role="button">
              Client Answered
              <x-sort-indicator :sort-column="$sortColumn" column-name="client_answered" />
            </a>
          </th>
          <th>
            <a wire:click.prevent="sortBy('updator_name')" href="#"
              role="button">
              Last Updated By
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="updator_name" />
            </a>
          </th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($surveys as $key => $survey)
          <tr wire:key="{{ $survey->id }}">
            <td>{{ $key + 1 }}</td>
            <td>{{ $survey->adviser_name }}</td>
            @if (!$clientId)
              <td>{{ $survey->policy_holder }}</td>
              <td>{{ $survey->policy_no }}</td>
            @endif
            <td>{{ $survey->created_at->format('d/m/Y') }}</td>
            @if ($clientId)
              <td>{{ $survey->creator_name }}</td>
            @elseif(auth()->user()->is_admin)
              <td>{{ $survey->creator_name }}</td>
            @endif
            <td class="text-center">
              <input type="checkbox" {{ $survey->client_answered ? 'checked' : '' }}
                onclick="return false" />
            </td>
            <td>{{ $survey->updator_name }}</td>
            <td class="text-right">
              @if ($survey->completed)
                <a href="{{ $clientId ? route('profile.clients.surveys.pdf', ['client' => $this->client->id, 'survey' => $survey->id]) : route('calls.survey.pdf', ['survey' => $survey->id]) }}"
                  target="_blank" class="btn btn-success btn-sm"
                  title="View Survey">
                  <i class="fa fa-eye"></i>
                </a>
              @endif
              <button class="btn btn-info btn-sm" data-toggle="modal"
                data-target="#editSurveyModal" title="Edit Survey"
                wire:click="$emitTo('surveys.form', 'editSurvey', {{ $survey->id }})">
                <i class="far fa-edit"></i>
              </button>
              @if ($survey->completed)
                <button class="btn btn-primary btn-sm" title="Send Survey"
                  wire:click="mailSurvey({{ $survey->id }})" wire:target="mailSurvey({{ $survey->id }})"
                  wire:loading.attr="disabled"
                  wire:loading.class.remove="btn-primary" wire:loading.class="btn-default">
                  <i class="far fa-envelope" wire:target="mailSurvey({{ $survey->id }})"
                    wire:loading.class.remove="far far-envelope"
                    wire:loading.class="fas fa-spinner"></i>
                </button>
              @endif
              <button class="btn btn-danger btn-sm" data-toggle="modal"
                title="Delete Survey"
                wire:click="$emit('delete-survey-{{ $componentId }}', {{ $survey->id }})">
                <i class="far fa-trash-alt"></i>
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <x-page.nav :paginator="$surveys" :search="$search" on-each-side="1"
      entity-name="surveys" />
  </div>
</div>

@push('scripts')
  <script type="text/javascript">
    const deleteSurvey{{ $componentId }} = () => {
      window.livewire.on('delete-survey-{{ $componentId }}', (surveyId) => {
        @this.set('surveyId', surveyId);

        $('#deleteSurveyModal{{ $componentId }}').modal('show');
      });

      $(document).on('survey-deleted', function(event) {
        $('#deleteSurveyModal{{ $componentId }}').modal('hide');

        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);
      });
    }
    window.addEventListener('load', deleteSurvey{{ $componentId }});
  </script>
@endpush
