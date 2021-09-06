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
          <th><a wire:click.prevent="sortBy('user_name')" href="#"
              role="button">
              Name
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="user_name" />
            </a></th>
          <th><a wire:click.prevent="sortBy('email_address')" href="#"
              role="button">
              E-Mail
              &nbsp;
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="email_address" />
            </a></th>
          <th class="text-left"><a wire:click.prevent="sortBy('id_user_type')" href="#"
              role="button">
              Role
              &nbsp;
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="id_user_type" />
            </a></th>
          <th class="text-left"><a wire:click.prevent="sortBy('status')" href="#"
              role="button">
              Status
              &nbsp;
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="status" />
            </a></th>
          {{-- <th class="text-right">Actions</th> --}}
        </tr>
      </thead>

      <tbody>
        @foreach ($users as $key => $user)
          <tr wire:key="{{ $user->id_user }}" class="{{ $user->deleted_at ? 'bg-deleted' : '' }}">

            <td>{{ $key + 1 }}</td>
            <td>{{ $user->user_name }}</td>
            <td>{{ $user->email_address }}</td>
            <td class="text-left">
              <span class="{{ $typeBadgeClass[$user->id_user_type] }}">
                {{ $user->is_admin ? 'Admin' : 'User' }}
              </span>
            </td>
            <td class="text-left">
              <span class="{{ $statusBadgeClass[$user->status] }}">{{ $statusLabel[$user->status] }}</span>
            </td>
            {{-- <td class="text-right">
              @if (!$user->deleted_at)
                <button class="btn btn-info btn-sm" data-toggle="modal"
                  data-target="#userFormModal" title="Edit User"
                  wire:click="$emitTo('users.form', 'editUser', {{ $user->id_user }})">
                  <i class="far fa-edit"></i>
                </button>

                <button class="btn btn-danger btn-sm" data-toggle="modal"
                  data-target="#deleteModal" title="Delete User"
                  wire:click="deleteUser({{ $user->id_user }})">
                  <i class="far fa-trash-alt"></i>
                </button>
              @endif
            </td> --}}
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
