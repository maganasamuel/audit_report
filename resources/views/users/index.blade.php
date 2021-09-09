@extends('layouts.app', ['title' => 'Users'])

@section('content')
  @include('users.partials.header', ['title' => 'Users', 'description' => ''])

  <div class="container-fluid mt--7">
    @include('alerts.success')
    @include('alerts.error')

    <div class="card w-100">
      <div class="card-body">
        {{-- <div class="card-title d-flex">
          <div class="button-container">
            @livewire('users.form')
          </div>
        </div> --}}

        @livewire('users.index')
      </div>
    </div>

    @include('layouts.footers.auth')
  </div>
@endsection
