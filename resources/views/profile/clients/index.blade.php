@extends('layouts.app', ['title' => __('Client Profiles')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Client Details'),
        'description' => __('This is the Clients table. You can see different information of the clients on this table. You can add, update or delete as well.'),
        'class' => 'col-lg-7'
    ])   

    <div class="container-fluid mt--7">
      
      @include('alerts.success')
      @include('alerts.error')
      @include('extra.view-client-pdf-modal')
      <div class="card w-100">
        <div class="card-body">
          <div class="card-title d-flex">
            
          </div>
        <table class="table" id="client-table">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Policy Holder</th>
                    <th>Policy Number</th>
                    <th class="text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
              {{-- data fetched via ajax should be inside here --}}
            </tbody>
        </table>
        </div>
      </div>
        
      @include('layouts.footers.auth')
    </div>

  @include('custom-scripts.client-js')
@endsection
