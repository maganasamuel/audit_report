@extends('layouts.app', ['title' => __('Client Profiles')])

@section('content')
    @include('users.partials.header', [
        'title' => __("Policy No: | $client->policy_no"),
        'description' => __("This is the Client Audit's Table. You can see different information of the audits taken by client on this table. You can add, update or delete as well."),
        'class' => 'col-lg-7'
    ])   

    <div class="container-fluid mt--7">

      <div class="row">
        <div class="col-lg-12">
          <div class="card rounded-0">
            <div class="card-header">
              <h4 class="card-title">Audits</h4>
            </div>
            
            <div class="card-body">
                @livewire('audits-table', ['client' => $client])
            </div>
          </div>
        </div>

      </div>
      <div class="row mt-4">
        <div class="col-lg-12">
          <div class="card rounded-0">
            <div class="card-header">
              <h4 class="card-title">Surveys</h4>
            </div>
            
            <div class="card-body">
                <p>surveys here....</p>
              
            </div>
          </div>
        </div>

      </div>
       
      @include('layouts.footers.auth')
    </div>

@endsection
