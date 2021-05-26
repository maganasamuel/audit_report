@extends('layouts.app', ['title' => __('Client Profiles')])

@section('content')
  @include('users.partials.header', [
  'title' => __('Clients'),
  'description' => __('This is the Clients table. You can see different
  information of the clients on this table. You can add, update or delete as
  well.'),
  'class' => 'col-lg-7'
  ])

  <div class="container-fluid mt--7">
    @include('alerts.success')
    @include('alerts.error')
    {{-- @include('extra.edit-client-pdf-modal')
    @include('extra.edit-survey-pdf-modal')
    @include('extra.delete-client-pdf-modal')
    @include('extra.cancel-survey-pdf-modal') --}}

    @livewire('clients.edit')

    <div class="card">
      <div class="card-body">
        @livewire('clients.index')
      </div>
    </div>

    @include('layouts.footers.auth')
  </div>
@endsection
