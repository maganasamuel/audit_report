@extends('layouts.app', ['title' => __('Reports')])

@section('content')
  @include('users.partials.header', [
  'title' => __('Reports'),
  'description' => __('This is Reports . You can see data from the previous audits
  and surveys we generated.'),
  'class' => 'col-lg-12'
  ])

  <div class="container-fluid mt--7">
    @include('alerts.success')

    <div class="card p-4">
      <div class="card-body">
        <div class="card-title">
          <h3 class="mb-0">Reports</h3>
        </div>
        @livewire('reports.index')
      </div>
    </div>

    @include('layouts.footers.auth')
  </div>
@endsection
