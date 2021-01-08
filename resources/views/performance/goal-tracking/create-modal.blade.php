<!--Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel"><b>Add New Goal</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" method="POST">

                <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label><b>Company</b></label>
                              <select name="company_id" id="company_id" class="form-control selectpicker dynamic"
                                      data-live-search="true" data-live-search-style="begins"
                                      data-first_name="first_name" data-last_name="last_name"
                                      title='{{__('Selecting',['key'=>trans('file.Company')])}}'>
                                      <option value="">HARSALE</option>
                                      <option value="">LION CODERS</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label><b>Goal Type</b></label>
                              <select name="goal_type_id" id="goal_type_id" class="form-control selectpicker dynamic"
                                      data-live-search="true" data-live-search-style="begins"
                                      data-first_name="first_name" data-last_name="last_name"
                                      title='{{__('Select Goal Type')}}'>
                                      <option value="">Invoice Goal</option>
                                      <option value="">Event Goal</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label><b>Subject</b></label>
                              <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label><b>Target Achievement</b></label>
                              <input type="text" class="form-control" name="target_achievement" id="target_achievement" placeholder="Target Achievement">
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label><b>Description</b></label>
                              <textarea class="form-control" name="description" id="description" cols="30" rows="5" placeholder="Description"></textarea>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label><b>Start Date</b></label>
                              <input type="text" class="form-control"  name="start_date" id="start_date" placeholder="Start Date">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label><b>End Date</b></label>
                              <input type="text" class="form-control"  name="end_date" id="end_date" placeholder="End Date">
                          </div>
                      </div>
                </div>                

            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $('#start_date').datepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#end_date').datepicker({
        uiLibrary: 'bootstrap4'
    });
</script>