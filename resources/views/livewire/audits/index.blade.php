<div>
  @include('alerts.delete-modal', ['id' => 'deleteAuditModal'])

  <div class="d-flex justify-content-between pt-4">
    <x-page.range wire:model="perPage" />
    <div>
      <input wire:model.debounce="search" type="text" class="form-control"
        placeholder="Search Client Feedbacks">
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
          {{-- <th>
            <a wire:click.prevent="sortBy('lead_source')" href="#"
              role="button">
              Lead Source
              <x-sort-indicator :sort-column="$sortColumn"
                column-name="lead_source" />
            </a>
          </th> --}}
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
        @foreach ($audits as $key => $audit)
          <tr wire:key="{{ $audit->id }}">
            <td>{{ $key + 1 }}</td>
            <td>{{ $audit->adviser_name }}</td>
            {{-- <td>{{ $audit->lead_source }}</td> --}}
            @if (!$clientId)
              <td>{{ $audit->policy_holder }}</td>
              <td>{{ $audit->policy_no }}</td>
            @endif
            <td>{{ $audit->created_at->format('d/m/Y') }}</td>
            @if ($clientId)
              <td>{{ $audit->creator_name }}</td>
            @elseif(auth()->user()->is_admin)
              <td>{{ $audit->creator_name }}</td>
            @endif
            <td>{{ $audit->updator_name }}</td>
            <td class="text-right">
              <a href="{{ $clientId ? route('profile.clients.audits.pdf', ['client' => $this->client->id, 'audit' => $audit->id]) : route('calls.audit.pdf', ['audit' => $audit->id]) }}"
                target="_blank" class="btn btn-success btn-sm"
                title="View Client Feedback">
                <i class="fa fa-eye"></i>
              </a>
              <button class="btn btn-info btn-sm" data-toggle="modal"
                data-target="#editAuditModal" title="Edit Client Feedback"
                wire:click="$emitTo('audits.form', 'editAudit', {{ $audit->id }})">
                <i class="far fa-edit"></i>
              </button>
              <button class="btn btn-primary btn-sm" title="Send Client Feedback"
                wire:click="mailAudit({{ $audit->id }})" wire:target="mailAudit({{ $audit->id }})" wire:loading.attr="disabled"
                wire:loading.class.remove="btn-primary" wire:loading.class="btn-default">
                <i class="far fa-envelope" wire:target="mailAudit({{ $audit->id }})" wire:loading.class.remove="far far-envelope"
                  wire:loading.class="fas fa-spinner"></i>
              </button>
              <button class="btn btn-danger btn-sm" data-toggle="modal"
                title="Delete Client Feedback"
                wire:click="$emit('delete-audit', {{ $audit->id }})">
                <i class="far fa-trash-alt"></i>
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <x-page.nav :paginator="$audits" :search="$search" on-each-side="1"
      entity-name="client feedbacks" />
  </div>
</div>

@push('scripts')
  <script type="text/javascript">
    const deleteAudit = () => {
      window.livewire.on('delete-audit', (auditId) => {
        @this.set('auditId', auditId);

        $('#deleteAuditModal').modal('show');
      });
    }

    window.addEventListener('load', deleteAudit);
  </script>
@endpush
