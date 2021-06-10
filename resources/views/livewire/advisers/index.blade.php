<div>
  <div class="d-flex justify-content-between pt-4">
    <div>
      <x-page.range wire:model="perPage" />
    </div>
    <div>
      <input wire:model.debounce="search" type="text" class="form-control"
        placeholder="Search Advisers">
    </div>
  </div>

  <div class="table-responsive py-4">
    <table class="table table-flush">
      <thead class="thead-light">
        <tr>

          <th>#</th>
          <th>
            <a wire:click.prevent="sortBy('name')" href="#"
              role="button">
              Name
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="name" />
            </a>
          </th>
          <th>
            <a wire:click.prevent="sortBy('email')" href="#"
              role="button">
              E-Mail
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="email" />
            </a>
          </th>
          <th><a wire:click.prevent="sortBy('fsp_no')" href="#"
              role="button">
              FSP Number
              &nbsp;
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="fsp_no" />
            </a></th>
          <th class="text-left"><a wire:click.prevent="sortBy('status')" href="#"
              role="button">
              Status
              &nbsp;
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="status" />
            </a></th>
          <th class="text-right">Actions</th>

        </tr>
      </thead>

      <tbody>
        @foreach ($advisers as $key => $adviser)
          <tr wire:key="{{ $adviser->id }}">

            <td>{{ $key + 1 }}</td>
            <td>{{ $adviser->name }}</td>
            <td>{{ $adviser->email }}</td>
            <td>{{ $adviser->fsp_no }}</td>
            <td class="text-left">
              <span class="{{ $badgeClass[$adviser->status] }}">{{ $adviser->status }}</span>
            </td>
            <td class="text-right">
              <button class="btn btn-info btn-sm" data-toggle="modal"
                data-target="#adviserFormModal" title="Edit Adviser"
                wire:click="$emitTo('advisers.form', 'editAdviser', {{ $adviser->id }})">
                <i class="far fa-edit"></i>
              </button>

              <button class="btn btn-danger btn-sm" data-toggle="modal"
                data-target="#deleteModal" title="Delete Adviser"
                wire:click="deleteAdviser({{ $adviser->id }})">

                <i class="far fa-trash-alt"></i>
              </button>

            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <x-page.nav :paginator="$advisers" :search="$search" on-each-side="1"
      entity-name="advisers" />
  </div>

  @include('alerts.delete-modal')
</div>

@push('scripts')
  <script type="text/javascript">
    const handleAdviserLoad = () => {
      $(document).on('adviser-created', function(event) {
        $('#adviserFormModal').modal('hide');

        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);

        @this.call('render');
      });

      $(document).on('adviser-updated', (event) => {
        $('#adviserFormModal').modal('hide');

        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);

        @this.call('render');
      });

      $(document).on('adviser-deleted', function(event) {
        $('#deleteModal').modal('hide');

        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);
      });
    }

    window.addEventListener('load', handleAdviserLoad);

  </script>
@endpush
