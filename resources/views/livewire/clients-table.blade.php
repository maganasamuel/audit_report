<div>
  @include('profile.clients.edit')
  @include('alerts.delete-modal')

  <div class="d-flex justify-content-between pt-4">
    <div>
      <select wire:model="perPage" class="form-control">
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
      </select>
    </div>
    <div>
      <input wire:model="search" type="text" class="form-control"
        placeholder="Search Clients">
    </div>
  </div>

  @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show rounded-0 mt-4"
      role="alert">
      <span class="alert-text"><strong>Success!</strong>
        {{ session('message') }}</span>
      <button type="button" class="close" data-dismiss="alert"
        aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  <div class="table-responsive py-4">
    <table class="table table-flush">
      <thead class="thead-light">
        <tr>

          <th>#</th>
          <th><a wire:click.prevent="sortBy('policy_holder')" href="#"
              role="button">
              Policy Holder
              &nbsp;
              <i
                class="fa fa-lg {{ $sortColumn['name'] == 'policy_holder' ? $sortClasses[$sortColumn['direction']] : 'fa-sort' }}">&nbsp;</i>
            </a></th>
          <th><a wire:click.prevent="sortBy('policy_no')" href="#"
              role="button">
              Policy Number
              &nbsp;
              <i
                class="fa fa-lg {{ $sortColumn['name'] == 'policy_no' ? $sortClasses[$sortColumn['direction']] : 'fa-sort' }}">&nbsp;</i>
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
            <td class="text-right"
              wire:ignore>
              <a href="{{ $client->path() }}" class="btn btn-success btn-sm"
                title="View Client">
                <i class="fa fa-eye"></i>
              </a>

              <button class="btn btn-info btn-sm" data-toggle="modal"
                data-target="#updateClientModal" title="Edit audit"
                wire:click="onEdit({{ $client->id }})">
                <i class="far fa-edit"></i>
              </button>

              <button class="btn btn-danger btn-sm" data-toggle="modal"
                data-target="#deleteModal" title="Delete audit"
                wire:click="onDelete({{ $client->id }})">

                <i class="far fa-trash-alt"></i>
              </button>

            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="d-flex justify-content-between d-flex-items-center pt-2">
      <div class="px-4 text-muted">

        @if ($clients->firstItem() > 0)
          <small>
            Showing {{ $clients->firstItem() }} to
            {{ $clients->lastItem() }} out of {{ $clients->total() }}
          </small>
        @else
          <small>{{ $search ? 'No clients found.' : 'No available clients.' }}</small>
        @endif
      </div>
      <div class="px-4">
        {{ $clients->links() }}
      </div>
    </div>
  </div>

  @push('js')
    <script type="text/javascript">
      window.livewire.on('clientUpdate', (data) => {
        $('#updateClientModal').modal('hide');
      });

      window.livewire.on('onConfirmDelete', () => {
        $('#deleteModal').modal('hide');
      });

    </script>
  @endpush

</div>
