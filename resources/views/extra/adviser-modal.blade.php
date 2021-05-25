<div class="modal fade" id="add-adviser" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true"
  wire:ignore.self>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add an Adviser</h5>
        <button type="button" class="close" data-dismiss="modal"
          aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="container">
        <form wire:submit.prevent="createAdviser">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-user"></i>
                    </span>
                  </div>
                  <input type="text" id="name" class="form-control"
                    placeholder="Adviser Name"
                    wire:model.defer="input.name">
                </div>
                @error('name')
                  <p class="small text-danger mt-1">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-hashtag"></i>
                    </span>
                  </div>
                  <input type="text" id="fsp_no" class="form-control"
                    placeholder="FSP Number"
                    wire:model.defer="input.fsp_no">
                </div>
                @error('fsp_no')
                  <p class="small text-danger mt-1">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"
          data-dismiss="modal">Close</button>
        <button type="submit" id="add" class="btn btn-primary"><i
            class="fa fa-circle-o-notch fa-spin d-none m-1"
            style="font-size: 10px;"></i>Add Adviser</button>
      </div>
      </form>
    </div>
  </div>
</div>
