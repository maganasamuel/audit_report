<div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="container">
        <form>
          @csrf
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-user"></i>
                    </span>
                  </div>
                  <input type="text" id="edit_name" class="form-control" placeholder="User's Name">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-at"></i>
                    </span>
                  </div>
                  <input type="email" id="edit_email" class="form-control" placeholder="Email Address">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group row">
                <div class="col-lg-12 d-flex justify-content-start">
                  <span class="clearfix"></span>
                  <label class="custom-toggle">
                    <input type="checkbox" id="edit_is_admin" value="1" checked>
                    <span class="custom-toggle-slider rounded-circle"></span>
                  </label>
                  <label class="form-control-label mx-2"> Admin Privileges</label>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="update_user" class="btn btn-primary">Update User</button>
      </div>
      </form>
    </div>
  </div>
</div>