<!--Create Modal -->
<div class="modal fade" id="EditformModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel"><b>Edit Goal Tracking Test</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="edit-body"> 
        
        <form method="POST" id="updatetEditForm">
          <?php echo csrf_field(); ?> 
          <input type="hidden" name="goal_tracking_id" id="goalTrackingIdEdit">

          <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Company</b></label>
                        <select name="company_id" id="companyIdEdit" class="form-control selectpicker dynamic"
                            data-live-search="true" data-live-search-style="begins"
                            data-first_name="first_name" data-last_name="last_name"
                            title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>'>
                            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($company->id); ?>" ><?php echo e($company->company_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Goal Type</b></label>
                        <select name="goal_type_id" id="goalTypeIdEdit" class="form-control selectpicker dynamic" data-live-search="true" data-live-search-style="begins">
                            <?php $__currentLoopData = $goal_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goalTypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($goalTypes->id); ?>" ><?php echo e($goalTypes->goal_type); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Subject</b></label>
                        <input type="text" class="form-control" name="subject" id="subjectEdit">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Target Achievement</b></label>
                        <input type="text" class="form-control" name="target_achievement" id="targetAchievementEdit">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label><b>Description</b></label>
                        <textarea class="form-control" name="description" id="descriptionEdit" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Start Date</b></label>
                        <input type="text" class="form-control" name="start_date" id="startDateEdit">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>End Date</b></label>
                        <input type="text" class="form-control" name="end_date" id="endDateEdit">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Progress %</b></label>
                        <input type="number" min="0" max="100" class="form-control" name="progress" id="progressEdit">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Status</b></label>
                        <select name="status" id="statusEdit" class="form-control selectpicker dynamic"
                              data-live-search="true" data-live-search-style="begins">
                              <option value="Not Started"><b>Not Started</b></option>
                              <option value="In Progress"><b>In Progress</b></option>
                              <option value="Completed"><b>Completed</b></option>
                        </select>
                    </div>
                </div>
          </div>    
      </form>

      </div>
      <div class="row mb-5">
          <div class="col-sm-2"></div>
          <div class="col-sm-6">
              <div id="alertMessageBoxEdit">
                  <div id="alertMessageEdit" class="text-light"></div>
              </div>
          </div>
          <div class="col-sm-1"></div>
          <div class="col-sm-3">
              <button type="button" class="btn btn-primary" id="update-button">Update</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>   
          </div>
      </div>
      
    </div>
  </div>
</div>

<script>
  $('#startDateEdit').datepicker({
      uiLibrary: 'bootstrap4'
  });
  $('#endDateEdit').datepicker({
      uiLibrary: 'bootstrap4'
  });
</script><?php /**PATH D:\xampp\htdocs\Lion_Coders\10.01.2020\peoplepro\resources\views/performance/goal-tracking/edit-modal-test.blade.php ENDPATH**/ ?>