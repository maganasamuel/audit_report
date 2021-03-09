<div class="modal fade" id="edit-client-pdf-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Client Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="container">
        <div class="assessment-container">
          <div class="container">
            <div class="row">
              <div class="col-lg-12 pt-0 form-box">
                <form class="registration-form" method="POST">
                  @csrf
                  <div class="form-bottom">
                    <input type="text" id="client_id" value="" hidden />
                    <input type="text" id="audit_id" value="" hidden />
                    <input type="text" id="adviser_id" value="" hidden />
                    <div class="row">
                      <div class="form-group col-lg-12 col-md-12">
                        <input type="text" class="form-control" placeholder="Week of" id="week-of" required>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:3px;">
                      <div class="row">
                        <div class="form-group col-lg-6 col-md-12">
                          <select class="form-control" name="adviser" id="adviser" required>
                            <option value="" selected disabled>Select an Adviser</option>
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
                      <div class="form-group col-lg-6 col-md-12">
                        <input type="text" name="policy_holder" placeholder="Policy Holder" class="form-email form-control" id="policy_holder" required>
                      </div>
                      <div class="form-group col-lg-6 col-md-12">
                        <input type="number" name="policy_no" id="policy_no" placeholder="Policy No" class="form-control" required>
                      </div>
                    </div>
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
                            <option value="yes">Yes - Refer to Notes</option>
                            <option value="no">No</option>
                            <option value="not sure">Not Sure - Refer to Notes</option>
                          </select>
                        </div>
                        <div class="form-group col-lg-12 col-md-12">
                          <label>5. We have received authority for all future payments to be direct debited from your bank account? Is this correct? </label>
                          <select class="form-control questions" required>
                            <option value="" selected disabled>Select an Answer</option>
                            <option value="yes">Yes</option>
                            <option value="no">No - Refer to Notes</option>
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
                            <option value="no">No - Refer to Notes</option>
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
                            <option value="n/a">Not Applicable</option>
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
                    

                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            <button type="button" id="updateAudit" class="btn btn-success" data-client>Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>