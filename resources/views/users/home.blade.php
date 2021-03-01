@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')
{{-- @include('extra.user-modal') --}}
{{-- @include('extra.edit-user-modal') --}}
{{-- @include('extra.deactivate-user-modal') --}}
<div class="container-fluid mt--7">
  @include('alerts.success')
  @include('alerts.error')
  <div class="card w-100">
    <div class="card-body">
      <div class="card-title d-flex">
        <div class="button-container">
          <h5>All Made Calls</h5>
        </div>
      </div>
      <table class="table" id="normal-user-table">
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
  {{-- @include('custom-scripts.user-js') --}}
</div>
@endsection
@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush