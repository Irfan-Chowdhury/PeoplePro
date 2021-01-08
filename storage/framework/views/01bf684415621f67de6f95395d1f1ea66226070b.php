<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />


<!--Create Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel"><b>Edit Goal Tracking</b></h5>
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
                                      title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>'>
                                      <option value="" selected>HARSALE</option>
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
                                      title='<?php echo e(__('Select Goal Type')); ?>'>
                                      <option value="" selected>Invoice Goal</option>
                                      <option value="">Event Goal</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label><b>Subject</b></label>
                              <input type="text" class="form-control" name="subject" id="subject" value="test">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label><b>Target Achievement</b></label>
                              <input type="text" class="form-control" name="target_achievement" id="target_achievement" value="test">
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label><b>Description</b></label>
                              <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label><b>Start Date</b></label>
                              <input type="date" class="form-control" name="start_date" id="start_date" selected value="01/07/2021">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label><b>End Date</b></label>
                              <input type="date" class="form-control" name="end_date" id="end_date" selected value="01/07/2021">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label><b>Progress</b></label>
                              <input type="text" class="form-control" name="progress" id="progress">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label><b>Status</b></label>
                              <select name="status" id="status" class="form-control selectpicker dynamic"
                                      data-live-search="true" data-live-search-style="begins"
                                      data-first_name="first_name" data-last_name="last_name"
                                      title='<?php echo e(__('Select Goal Type')); ?>'>
                                      <option value="Not Started" selected>Not Started</option>
                                      <option value="In Progress">In Progress</option>
                                      <option value="Completed">Completed</option>
                              </select>
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
</script><?php /**PATH C:\xampp\htdocs\Lion-Coders\PeoplePro-Related\peoplepro\resources\views/performance/goal-tracking/edit-modal.blade.php ENDPATH**/ ?>