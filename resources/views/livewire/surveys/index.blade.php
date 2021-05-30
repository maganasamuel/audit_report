<div>
  @include('alerts.delete-modal')

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
          <th>
            <a wire:click.prevent="sortBy('created_at')" href="#"
              role="button">
              Date Called
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="created_at" />
            </a>
          </th>
          <th>
            <a wire:click.prevent="sortBy('creator_name')" href="#"
              role="button">
              Caller
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="creator_name" />
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
            <td>{{ $survey->created_at->format('d/m/Y') }}</td>
            <td>{{ $survey->creator_name }}</td>
            <td>{{ $survey->updator_name }}</td>
            <td class="text-right"
              wire:ignore>
              <a href="{{ route('profile.clients.surveys.pdf', ['client' => $this->client->id, 'survey' => $survey->id]) }}"
                target="_blank" class="btn btn-success btn-sm"
                title="View Survey">
                <i class="fa fa-eye"></i>
              </a>
              <button class="btn btn-info btn-sm" data-toggle="modal"
                data-target="#editSurveyModal" title="Edit Survey"
                wire:click="$emitTo('surveys.form', 'editSurvey', {{ $survey->id }})">
                <i class="far fa-edit"></i>
              </button>
              <button class="btn btn-primary btn-sm" title="Send Survey"
                wire:click="mailSurvey({{ $survey->id }})">
                <i class="far fa-envelope"></i>
              </button>
              <button class="btn btn-danger btn-sm" data-toggle="modal"
                data-target="#deleteModal" title="Delete Survey"
                wire:click="$emit('delete-survey', {{ $survey->id }})">
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
    window.onload = () => {
      $(function() {
        window.livewire.on('delete-survey', (surveyId) => {
          @this.set('surveyId', surveyId);

          $('#deleteModal').modal('show');
        });
      });
    }

  </script>
@endpush
