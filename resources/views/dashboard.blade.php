@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')
@include('extra.user-modal')
@include('extra.edit-user-modal')
@include('extra.deactivate-user-modal')
<div class="container-fluid mt--7">
  @include('alerts.success')
  @include('alerts.error')
  <div class="card w-100">
    <div class="card-body">
      <div class="card-title d-flex">
        <div class="button-container">
          <button id="add-user" data-toggle="modal" data-target="#add-user" class="btn btn-primary">New User</button>
        </div>
      </div>
      <table class="table" id="user-table">
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th>Name</th>
            <th>Username</th>
            <th>Status</th>
            <th>Role</th>
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
  @include('custom-scripts.user-js')
</div>
@endsection
@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush