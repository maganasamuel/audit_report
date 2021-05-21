<div>
    <form wire:submit.prevent="onSubmit">

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-label">Report Type: </label>
                    <select class="form-control" name="report_type" wire:model.lazy="report_type">
                        <option value="" disabled selected>Choose an option.</option>
                        <option value="audit">Audit</option>
                        <option value="survey">Survey</option>
                    </select>

                    @error('report_type')
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                <label for="">Select an Adviser: </label>
                    <select class="form-control" id="advisers" name="adviser" wire:model.lazy="adviser_id">
                        <option value="" selected>Choose an option</option>
                        @foreach($advisers as $adviser)
                            <option value={{ $adviser->id }}>{{ $adviser->name }}</option>
                        @endforeach
                    </select>
                    @error('adviser_id')
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                <label for="">FSP Number: </label>
                    
                    <input class="form-control" type="text" id="fsp_no" name="fsp_no" disabled value="{{$fsp_no}}">
                </div>
            </div>
        </div>

        <div class="input-daterange datepicker row align-items-center">
            <div class="col">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input class="form-control" placeholder="Start date" type="text" wire:model.lazy="start_date">

                        @error('start_date')
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input class="form-control" placeholder="End date" type="text" wire:model.lazy="end_date">

                        @error('end_date')
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">Generate Report</button>
        </div>
    </form>
</div>
