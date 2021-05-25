<div>
    @include('livewire.update-audit')
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
        <div >
            <input wire:model="search" type="text" class="form-control" placeholder="Search Audits">
        </div>
    </div>

    @if (session()->has('message'))

        <div class="alert alert-success alert-dismissible fade show rounded-0 mt-4" role="alert">

            <span class="alert-text"><strong>Success!</strong> {{ session('message') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="table-responsive py-4">
        <table class="table table-flush">
            <thead class="thead-light">
                <tr>

                    <th>#</th>
                    <th><a wire:click.prevent="sortBy('pdf_title)" href="#" role="button">
                    	PDF Title

                    </a></th>
                    <th><a wire:click.prevent="sortBy('weekOf')" href="#" role="button">
                    	Week Of

                    </a></th>
                    <th class="text-right">Actions</th>

                </tr>
            </thead>

            <tbody>
                @foreach($audits as $key => $audit)
                    <tr wire:key="{{ $audit->id }}">

                        <td>{{ $key + 1 }}</td>
                        <td>{{ $audit->pivot->pdf_title }}</td>
                        <td>{{ $audit->pivot->weekOf }}</td>
                        <td class="text-right"
                            wire:ignore

                        >
                            <a href="/profile/clients/{{$client->id}}/audits/{{$audit->id}}/pdf" target="_blank" class="btn btn-success btn-sm" title="View audit">
                                <i class="fa fa-eye"></i>
                            </a>

                          
                            <button class="btn btn-primary btn-sm" title="Send Audit" wire:click="sendEmail({{$audit->id}}, {{$client->id}})">
                                <i class="far fa-envelope"></i> 
                            </button> 

                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#updateAuditModal" title="Edit audit" wire:click="onEdit({{$audit->id}})">
                                <i class="far fa-edit"></i>
                            </button>

                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" title="Delete audit" wire:click="onDelete({{$audit->id}})">

                                <i class="far fa-trash-alt"></i>
                            </button>


                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between d-flex-items-center pt-2">
            <div class="px-4 text-muted">

            	@if($audits->firstItem() > 0)
	                <small>
	                	Showing {{ $audits->firstItem() }} to {{ $audits->lastItem() }} out of {{$audits->total() }}
	                </small>
	            @else
	            	<small>Cannot find audit</small>
	            @endif
            </div>
            <div class="px-4">
                {{ $audits->links() }}
            </div>
        </div>
    </div>

    @push('js')
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
