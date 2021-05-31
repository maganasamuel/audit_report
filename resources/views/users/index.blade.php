@extends('layouts.app', ['title' => 'Users'])

@section('content')
  @include('users.partials.header', ['title' => 'Users'])

  <div class="container-fluid mt--7">
    @include('alerts.success')
    @include('alerts.error')

    <div class="card">
      <div class="card-body"></div>
    </div>

    @include('layouts.footers.auth')
  </div>
@endsection
