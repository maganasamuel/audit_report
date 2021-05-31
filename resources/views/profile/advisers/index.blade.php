@extends('layouts.app', ['title' => __('Adviser Profiles')])

@section('content')
  {{-- @include('extra.edit-adviser-modal')
  @include('extra.deactivate-adviser-modal') --}}
  @include('users.partials.header', [
  'title' => __('Advisers'),
  'description' => __('This is the Advisers table. You can see different
  information of the advisers on this table. You can add, update or delete as
  well.'),
  'class' => 'col-lg-7'
  ])

  <div class="container-fluid mt--7">

    @include('alerts.success')
    @include('alerts.error')

    <div class="card w-100">
      <div class="card-body">
        <div class="card-title d-flex">
          <div class="button-container">
            @livewire('advisers.form')
          </div>
        </div>

        @livewire('advisers.index')
      </div>
    </div>

    @include('layouts.footers.auth')
  </div>
@endsection
