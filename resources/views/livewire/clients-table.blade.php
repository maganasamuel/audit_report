<div>
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
            <input wire:model="search" type="text" class="form-control" placeholder="Search Clients">
        </div>
    </div>

    <div class="table-responsive py-4">
        <table class="table table-flush">
            <thead class="thead-light">
                <tr>

                    <th>#</th>
                    <th><a wire:click.prevent="sortBy('name')" href="#" role="button">
                    	Policy Holder
                    	
                    </a></th>
                    <th><a wire:click.prevent="sortBy('created_at')" href="#" role="button">
                    	Policy Number
                    
                    </a></th>
                    <th class="text-right">Actions</th>
       
                </tr>
            </thead>

            <tbody>
                @foreach($clients as $key => $client)
                    <tr wire:key="{{ $client->id }}">
                       
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $client->policy_holder }}</td>
                        <td>{{ $client->policy_no }}</td>
                        <td class="text-right" 
                            wire:ignore 
                            
                        >
                            <a href="/pdfs/view-pdf?id={{$client->id}}" class="btn btn-success btn-sm" title="View Audit">
                                <i class="fa fa-eye"></i>
                            </a>
                          
                            <a href="" class="btn btn-primary btn-sm" title="Send Audit">
                                <i class="far fa-envelope"></i> 
                            </a> 
                            <a href="" class="btn btn-info btn-sm" title="Edit Audit">
                                <i class="far fa-edit"></i>
                            </a> 

                            <a href="" class="btn btn-danger btn-sm" title="Delete Audit">

                                <i class="far fa-trash-alt"></i>
                            </a> 
    
         
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between d-flex-items-center pt-2">
            <div class="px-4 text-muted">

            	@if($clients->firstItem() > 0)
	                <small>
	                	Showing {{ $clients->firstItem() }} to {{ $clients->lastItem() }} out of {{$clients->total() }}
	                </small>
	            @else
	            	<small>Cannot find client</small>
	            @endif
            </div>
            <div class="px-4">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
            
</div>