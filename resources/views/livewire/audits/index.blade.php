<div>
  @include('alerts.delete-modal')

  <div class="d-flex justify-content-between pt-4">
    <x-page.range wire:model="perPage" />
    <div>
      <input wire:model.debounce="search" type="text" class="form-control"
        placeholder="Search Audits">
    </div>
  </div>

  <div class="table-responsive py-4">
    <table class="table table-flush">
      <thead class="thead-light">
        <tr>
          <th>#</th>
          <th>
            <a wire:click.prevent="sortBy('adviser.name')" href="#"
              role="button">
              Adviser
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="adviser.name" />
            </a>
          </th>
          <th>
            <a wire:click.prevent="sortBy('lead_source')" href="#"
              role="button">
              Lead Source
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="lead_source" />
            </a>
          </th>
          <th>
            <a wire:click.prevent="sortBy('created_at')" href="#"
              role="button">
              Date Created
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="created_at" />
            </a>
          </th>
          <th>
            <a wire:click.prevent="sortBy('creator.name')" href="#"
              role="button">
              Created By
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="creator.name" />
            </a>
          </th>
          <th>
            <a wire:click.prevent="sortBy('updator.name')" href="#"
              role="button">
              Updated By
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="updator.name" />
            </a>
          </th>

          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($audits as $key => $audit)
          <tr wire:key="{{ $audit->id }}">
            <td>{{ /* $key + 1 */ $audit->id }}</td>
            <td>{{ $audit->adviser_name }}</td>
            <td>{{ $audit->lead_source }}</td>
            <td>{{ $audit->created_at->format('d/m/Y') }}</td>
            <td>{{ $audit->creator_name }}</td>
            <td>{{ $audit->updator_name }}</td>
            <td class="text-right"
              wire:ignore>
              <a href="/profile/clients/{{ $client->id }}/audits/{{ $audit->id }}/pdf"
                target="_blank" class="btn btn-success btn-sm"
                title="View Audit">
                <i class="fa fa-eye"></i>
              </a>
              <button class="btn btn-primary btn-sm" title="Send Audit"
                wire:click="sendEmail({{ $audit->id }}, {{ $client->id }})">
                <i class="far fa-envelope"></i>
              </button>
              <button class="btn btn-info btn-sm" data-toggle="modal"
                data-target="#editAuditModal" title="Edit Audit"
                wire:click="$emitTo('audits.form', 'editAudit', {{ $audit->id }})">
                <i class="far fa-edit"></i>
              </button>
              <button class="btn btn-danger btn-sm" data-toggle="modal"
                data-target="#deleteModal" title="Delete Audit"
                wire:click="onDelete({{ $audit->id }})">
                <i class="far fa-trash-alt"></i>
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <x-page.nav :paginator="$audits" :search="$search" on-each-side="1"
      entity-name="audits" />
  </div>

  @push('scripts')
    <script type="text/javascript">
      window.livewire.on('auditUpdate', () => {
        $('#updateAuditModal').modal('hide');
      });

      window.livewire.on('onConfirmDelete', () => {
        $('#deleteModal').modal('hide');
      });

    </script>
  @endpush
</div>
