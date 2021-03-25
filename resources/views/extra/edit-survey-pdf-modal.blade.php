
<div class="modal fade" id="edit-survey-pdf-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Survey Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="container">
        <div class="card-body survey">
              <div class="row">
                <div class="form-group col-lg-12 col-md-12">
                  <input type="text" class="form-control" placeholder="Week of" id="week-of-edit" value="{{ date('d-m-Y') }}" required>
                </div>
              </div>
              <div class="form-group" style="margin-bottom:3px;">
                <div class="row">
                  <div class="form-group col-lg-12 col-md-12">
                    <select class="form-control" name="adviser" id="adviser-edit" required>
                      <option value="" selected disabled>Select an Adviser</option>
                      
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group survey-qa">
                <label>Have you had a chance to discuss this cancellation with your Adviser?</label>
                <select id="level-1" class="form-control">
                  <option value="" selected disabled>Choose an option</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>

            </div>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" id="updateSurvey" class="btn btn-success d-none" data-survey>Update</button>
      </div>
    </div>
  </div>
</div>
@include('custom-scripts.survey-js')
<script>
  
</script>