@extends('layouts.app', ['title' => __('Client Profiles')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Client Details'),
        'description' => __('This is the Clients table. You can see different information of the clients on this table. You can add, update or delete as well.'),
        'class' => 'col-lg-7'
    ])   

    <div class="container-fluid mt--7">
      @if(session()->has('message'))
        <div class="alert alert-success alert-with-icon" id="successmail">
            <a href="#" aria-hidden="true" class="close" data-dismiss="alert" aria-label="close">
              &times;
            </a>
            <span data-notify="icon" class="tim-icons icon-trophy"></span>
            <span id="success-text">{{ session()->get('message') }}</span>
        </div>
      @endif
      @include('alerts.success')
      @include('alerts.error')
      @include('extra.edit-client-pdf-modal')
      @include('extra.edit-survey-pdf-modal')
      @include('extra.delete-client-pdf-modal')
      @include('extra.cancel-survey-pdf-modal')
      <div class="card rounded-0">
        <div class="card-body">
          @livewire('clients-table')
        </div>
      </div>
        
      @include('layouts.footers.auth')
    </div>

  {{--@include('custom-scripts.client-js')--}}
@endsection
