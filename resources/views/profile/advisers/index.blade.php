@extends('layouts.app', ['title' => __('Adviser Profiles')])

@section('content')
    @include('extra.adviser-modal')
    @include('extra.edit-adviser-modal')
    @include('extra.deactivate-adviser-modal')
    @include('users.partials.header', [
        'title' => __('Adviser Details'),
        'description' => __('This is the Advisers table. You can see different information of the advisers on this table. You can add, update or delete as well.'),
        'class' => 'col-lg-7'
    ])   

    <div class="container-fluid mt--7">
      
      @include('alerts.success')
      @include('alerts.error')
      <div class="card w-100">
        <div class="card-body">
          <div class="card-title d-flex">
            <div class="button-container">
              <button id="add-adviser" data-toggle="modal" data-target="#add-adviser" class="btn btn-primary">Add an Adviser</button>
            </div>
          </div>
        <table class="table" id="adviser-table">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>FSP Number</th>
                    <th>Status</th>
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

  @include('custom-scripts.adviser-js')
@endsection
