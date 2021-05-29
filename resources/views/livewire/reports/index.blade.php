<div>
  <form wire:submit.prevent="generateReport">
    <div class="form-group">
      <label for="report_type">Report Type: </label>
      <select class="form-control" id="report_type"
        wire:model.defer="input.report_type">
        <option value="">Choose an option.</option>
        <option value="audit">Audit</option>
        {{-- <option value="survey">Survey</option> --}}
      </select>
      <x-input-error for="report_type" />
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="adviser_id">Select an Adviser: </label>
        <select class="form-control" id="adviser_id"
          wire:model.lazy="input.adviser_id">
          <option value="">Choose an option</option>
          @foreach ($this->advisers as $adviser)
            <option value={{ $adviser->id }}>{{ $adviser->name }}</option>
          @endforeach
        </select>
        <x-input-error for="adviser_id" />
      </div>
      <div class="form-group col-md-6">
        <label for="fsp_no">FSP Number:</label>
        <div id="fsp_no" class="form-control">
          {{ $this->adviser->fsp_no ?? '' }}
        </div>
      </div>
    </div>

    <div id="date_range"
      class="input-daterange datepicker row align-items-center">
      <div class="col">
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i
                  class="ni ni-calendar-grid-58"></i></span>
            </div>
            <input class="form-control" placeholder="Start date" type="text"
              id="start_date">
            <x-input-error for="start_date" />
          </div>
        </div>
      </div>
      <div class="col">
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i
                  class="ni ni-calendar-grid-58"></i></span>
            </div>
            <input class="form-control" placeholder="End date" type="text"
              id="end_date">
            <x-input-error for="end_date" />
          </div>
        </div>
      </div>
    </div>

    <div class="form-group">
      <button class="btn btn-primary" type="submit">Generate Report</button>
    </div>
  </form>
</div>


@push('scripts')
  <script type="text/javascript">
    window.onload = () => {
      $(function() {
        $('#date_range').datepicker()
          .on('hide', function(event) {
            @this.set('input.start_date', $('#start_date').val());
            @this.set('input.end_date', $('#end_date').val());
          });
      });

      $(document).on('report-generated', function(event){
        window.open(event.detail, '_blank');
      });
    }

  </script>
@endpush
