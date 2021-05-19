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
                            <a href="/pdfs/view-pdf?id={{$audit->id}}" class="btn btn-success btn-sm" title="View audit">
                                <i class="fa fa-eye"></i>
                            </a>
                          
                            <!-- <a href="" class="btn btn-primary btn-sm" title="Send Audit">
                                <i class="far fa-envelope"></i> 
                            </a>  -->
                            <a href="" class="btn btn-info btn-sm" title="Edit audit">
                                <i class="far fa-edit"></i>
                            </a> 

                            <a href="" class="btn btn-danger btn-sm" title="Delete audit">

                                <i class="far fa-trash-alt"></i>
                            </a> 
    
         
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
            
</div>