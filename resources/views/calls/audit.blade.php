@extends('layouts.app', ['title' => __('Adviser Profiles')])

@section('content')
@include('users.partials.header', [
  'title' => __('Audit Questionnaire'),
  'description' => __('This is the Audit Questionnaire. You can see different sets of questions.'),
  'class' => 'col-lg-12'
  ])

  <!-- Kevin 3-->
  <div class="container-fluid mt--7">
    @include('alerts.success')
    <div class="card w-100">
      <div class="card-body">
        <div class="card-title">
          <h3 class="mb-0">Audit Report</h3>
        </div>
        <div class="assessment-container">
          <div class="row">
            <div class="col-lg-12 pt-0 form-box">
              <form class="registration-form" method="POST">
                @csrf
                <div class="form-top">
                  <p>
                    INTRODUCTION: Mr/ Mrs Policyholder, my name is_____________. I am the Client Relationship manager with EliteInsure Ltd.. The reason for my SPECIAL call is to inspect the standard of service provided by our adviser, ( mention name), and also to ensure that high quality of service and advise was given to you. It should take approx 5 mins. Would that be alright?

                  </p>
                </div>
                <div class="form-bottom">
                  <div class="row">
                    <div class="form-group col-lg-12 col-md-12">
                      <input type="text" class="form-control" placeholder="Week of" id="week-of" value="{{ date('d-m-Y') }}" required>
                    </div>
                  </div>
                  <div class="form-group" style="margin-bottom:3px;">
                    <div class="row">
                      <div class="form-group col-lg-6 col-md-12">
                        <select class="form-control" name="adviser" id="adviser" required>
                          <option value="" selected disabled>Select an Adviser</option>
                          @foreach($advisers as $adviser)
                          <option value="{{ $adviser->id }}">{{$adviser->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group col-lg-6 col-md-12">
                        <select class="form-control" name="lead_source" id="lead_source" required>
                          <option value="" selected disabled>Select a Lead Source</option>
                          <option value="Telemarketer">Telemarketer</option>
                          <option value="BDM">BDM</option>
                          <option value="Self-generated">Self-generated</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-lg-12">Is this a new client?</label>
                    <div class="form-group col-lg-12">
                      <select id="client-question" class="form-control">
                        <option value="" selected disabled>Choose an option</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                    </div>
                  </div>
                  <div id="if-new-client"></div>
                  <div class="row">
                    <div class="col-lg-6 col-md-6 p-0">
                      <div class="form-group col-lg-12 col-md-12">
                        <label>1. I understand you recently took out a policy with ( fidelity, partners, aia) from one of our advisers Is that correct? </label>
                        <select class="form-control questions" required>
                          <option value="" selected disabled>Select an Answer</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group col-lg-12 col-md-12">
                        <label>2. Was the adviser by him / herself?</label>
                        <select class="form-control questions" required>
                          <option value="" selected disabled>Select an Answer</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group col-lg-12 col-md-12">
                        <label>3. How would you describe the adviser's standard of service on a scale of 1-10? (10 is the highest)</label>
                        <select class="form-control questions" required>
                          @for($x = 10; $x >= 1; $x--)
                          <option value='{{ $x }}'>{{ $x }}</option>
                          @endfor
                        </select>
                      </div>
                      <div class="form-group col-lg-12 col-md-12">
                        <label>4. As you are aware, non disclosure can lead to non payment of claim. To make sure the correct underwriting takes place , we have noted your current pre-existing medical conditions are ___ and ___. Is there anything else apart from this not stated? </label>
                        <select class="form-control questions" required>
                          <option value="" selected disabled>Select an Answer</option>
                          <option value="Yes - Refer to Notes">Yes - Refer to Notes</option>
                          <option value="no">No</option>
                          <option value="Not Sure - Refer to Notes">Not Sure - Refer to Notes</option>
                        </select>
                      </div>
                      <div class="form-group col-lg-12 col-md-12">
                        <label>5. We have received authority for all future payments to be direct debited from your bank account? Is this correct? </label>
                        <select class="form-control questions" required>
                          <option value="" selected disabled>Select an Answer</option>
                          <option value="yes">Yes</option>
                          <option value="No - Refer to Notes">No - Refer to Notes</option>
                        </select>
                      </div>
                      <div class="form-group col-lg-12 col-md-12">
                        <label>6. Did you take this policy to replace any other policy? </label>
                        <select class="form-control questions" required>
                          <option value="" selected disabled>Select an Answer</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                    </div>
                    <!-- end of col -->
                    <div class="col-lg-6 col-md-6 p-0">
                      <div class="form-group col-lg-12 col-md-12">
                        <label>7. We have your occupation recorded as _________ - is that correct? </label>
                        <select class="form-control questions" required>
                          <option value="" selected disabled>Select an Answer</option>
                          <option value="yes">Yes</option>
                          <option value="No - Refer to Notes">No - Refer to Notes</option>
                        </select>
                      </div>
                      <div class="form-group col-lg-12 col-md-12">
                        <label>8. What is your understanding of the benefits of the policy? </label>
                        <textarea class="form-control questions" cols="10" rows="3"></textarea>
                      </div>
                      <div class="form-group col-lg-12 col-md-12">
                        <label>9. It specified in the authority to proceed that a copy of the disclosure statement was given to you and your insurance planner and or plan/copy of your LAT was e mailed to e mail address John@eliteinsure..co.nz . Did you received them? </label>
                        <select class="form-control questions" required>
                          <option value="" selected disabled>Select an Answer</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group col-lg-12 col-md-12">
                        <label>10. Do you have any further comments? </label>
                        <textarea class="form-control questions" cols="10" rows="3" required></textarea>
                      </div>
                      <div class="form-group col-lg-12 col-md-12">
                        <label>11. If replacement( were the risks of replacing this insurance policy explained to you? </label>
                        <select class="form-control questions" required>
                          <option value="" selected disabled>Select an Answer</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                          <option value="n/A">Not Applicable</option>
                        </select>
                      </div>
                      <div class="form-group col-lg-12 col-md-12">
                        <label>12. Remedial Action Taken Or Proposed:</label>
                        <select class="form-control questions" required>
                          <option value="" selected disabled>Select an Answer</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                    </div>
                    <!-- end of col -->
                    <div class="form-group col-lg-12 col-md-12 mx-2">
                      <label>Notes: </label>
                      <textarea name="notes" class="form-control questions" cols="10" rows="3"></textarea>
                    </div>
                  </div>
                  <button type="button" id="submitAudit" class="btn">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


    @include('layouts.footers.auth')
  </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
  <script>
    $('#adviser').selectize({
          sortField: 'text'
      });
  </script>
  <link type="text/css" href="{{ asset('custom-css') }}/custom-style.css?v=1.0.0" rel="stylesheet">
  @include('custom-scripts.multi-form-js')
  @endsection