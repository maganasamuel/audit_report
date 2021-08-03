<div>
  <div class="d-flex justify-content-between pt-4">
    <div>
      <x-page.range wire:model="perPage" />
    </div>
    <div>
      <input wire:model.debounce="search" type="text" class="form-control"
        placeholder="Search Users">
    </div>
  </div>

  <div class="table-responsive py-4">
    <table class="table table-flush">
      <thead class="thead-light">
        <tr>

          <th>#</th>
          <th><a wire:click.prevent="sortBy('name')" href="#"
              role="button">
              Name
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="name" />
            </a></th>
          <th><a wire:click.prevent="sortBy('email')" href="#"
              role="button">
              E-Mail
              &nbsp;
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="email" />
            </a></th>
          <th class="text-left"><a wire:click.prevent="sortBy('is_admin')" href="#"
              role="button">
              Role
              &nbsp;
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="is_admin" />
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
        @foreach ($users as $key => $user)
          <tr wire:key="{{ $user->id }}" class="{{ $user->deleted_at ? 'bg-deleted' : '' }}">

            <td>{{ $key + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td class="text-left">
              <span
                class="{{ $badgeClass[$user->is_admin] }}">{{ $user->is_admin ? 'Admin' : 'User' }}</span>
            </td>
            <td class="text-left">
              <span class="{{ $badgeClass[$user->status] }}">{{ $user->status }}</span>
            </td>
            <td class="text-right">
              @if (!$user->deleted_at)
                <button class="btn btn-info btn-sm" data-toggle="modal"
                  data-target="#userFormModal" title="Edit User"
                  wire:click="$emitTo('users.form', 'editUser', {{ $user->id }})">
                  <i class="far fa-edit"></i>
                </button>

                <button class="btn btn-danger btn-sm" data-toggle="modal"
                  data-target="#deleteModal" title="Delete User"
                  wire:click="deleteUser({{ $user->id }})">
                  <i class="far fa-trash-alt"></i>
                </button>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <x-page.nav :paginator="$users" :search="$search" on-each-side="1"
      entity-name="users" />
  </div>

  <x-delete-modal />
</div>

@push('scripts')
  <script type="text/javascript">
    const handleUserLoad = () => {
      $(document).on('user-created', function(event) {
        $('#userFormModal').modal('hide');

        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);

        @this.call('render');
      });

      $(document).on('user-updated', (event) => {
        $('#userFormModal').modal('hide');

        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);

        @this.call('render');
      });

      $(document).on('user-deleted', function(event) {
        $('#deleteModal').modal('hide');

        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);
      });
    }

    window.addEventListener('load', handleUserLoad);
  </script>
@endpush

@push('styles')
  <style>
    .bg-deleted {
      background-color: #FCC8D2;
    }

  </style>
@endpush
