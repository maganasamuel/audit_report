<div>
  <div class="d-flex justify-content-between pt-4">
    <div>
      <x-page.range wire:model="perPage" />
    </div>
    <div>
      <input wire:model.debounce="search" type="text" class="form-control"
        placeholder="Search Clients">
    </div>
  </div>

  <div class="table-responsive py-4">
    <table class="table table-flush">
      <thead class="thead-light">
        <tr>

          <th>#</th>
          <th><a wire:click.prevent="sortBy('policy_holder')" href="#"
              role="button">
              Policy Holder
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="policy_holder" />
            </a></th>
          <th><a wire:click.prevent="sortBy('policy_no')" href="#"
              role="button">
              Policy Number
              &nbsp;
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="policy_no" />
            </a></th>
          <th class="text-right">Actions</th>

        </tr>
      </thead>

      <tbody>
        @foreach ($clients as $key => $client)
          <tr wire:key="{{ $client->id }}">

            <td>{{ $key + 1 }}</td>
            <td>{{ $client->policy_holder }}</td>
            <td>{{ $client->policy_no }}</td>
            <td class="text-right">
              <a href="{{ $client->path() }}" class="btn btn-success btn-sm"
                title="View Details">
                <i class="fa fa-eye"></i>
              </a>

              <button class="btn btn-info btn-sm" data-toggle="modal"
                data-target="#editClientModal" title="Edit Client"
                wire:click="$emitTo('clients.edit', 'editClient', {{ $client->id }})">
                <i class="far fa-edit"></i>
              </button>

              <button class="btn btn-danger btn-sm" data-toggle="modal"
                data-target="#deleteModal" title="Delete Client"
                wire:click="deleteClient({{ $client->id }})">

                <i class="far fa-trash-alt"></i>
              </button>

            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <x-page.nav :paginator="$clients" :search="$search" on-each-side="1"
      entity-name="clients" />
  </div>

  <x-delete-modal />
</div>

@push('scripts')
  <script type="text/javascript">
    window.livewire.on('clientUpdated', (data) => {
      $('#editClientModal').modal('hide');

      $('#success').removeClass('d-none').addClass('d-block');
      $('#success-text').text(data);

      @this.call('render');
    });

    window.livewire.on('clientDeleted', (data) => {
      $('#deleteModal').modal('hide');

      $('#success').removeClass('d-none').addClass('d-block');
      $('#success-text').text(data);
    });
  </script>
@endpush
