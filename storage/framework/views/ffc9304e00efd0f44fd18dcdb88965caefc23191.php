<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />


<form action="" method="POST" id="updatetEditForm">
    <?php echo csrf_field(); ?> 
    <input type="hidden" name="goal_tracking_id" value="<?php echo e($goal_tracking->id); ?>">
    <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label><b>Company</b></label>
                  <select name="company_id" id="company_id" class="form-control"
                          title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>'>
                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($company->id); ?>" <?php echo e($company->id == $goal_tracking->company_id ? 'selected="selected"' : ''); ?>><?php echo e($company->company_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <label><b>Goal Type</b></label>
                  <select name="goal_type_id" id="goal_type_id" class="form-control" title='<?php echo e(__('Select Goal Type')); ?>'>
                        <?php $__currentLoopData = $goal_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goalTracking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($goalTracking->id); ?>" <?php echo e($goalTracking->id == $goal_tracking->goal_type_id ? 'selected="selected"' : ''); ?>><?php echo e($goalTracking->goal_type); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <label><b>Subject</b></label>
                  <input type="text" class="form-control" name="subject" id="subject" value="<?php echo e($goal_tracking->subject); ?>">
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <label><b>Target Achievement</b></label>
                  <input type="text" class="form-control" name="target_achievement" id="target_achievement" value="<?php echo e($goal_tracking->target_achievement); ?>">
              </div>
          </div>
          <div class="col-md-12">
              <div class="form-group">
                  <label><b>Description</b></label>
                  <textarea class="form-control" name="description" id="description" rows="5"><?php echo e($goal_tracking->description); ?></textarea>
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <label><b>Start Date</b></label>
                  <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo e($goal_tracking->start_date); ?>">
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <label><b>End Date</b></label>
                  <input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo e($goal_tracking->end_date); ?>">
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <label><b>Progress %</b></label>
                  <input type="number" min="0" max="100" class="form-control" name="progress" id="progress" value="<?php echo e($goal_tracking->progress); ?>">
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <label><b>Status</b></label>
                  <select name="status" id="status" class="form-control"
                          title='<?php echo e(__('Select Goal Type')); ?>'>
                        <?php if($goal_tracking->status == 'Not Started'): ?>
                            <option value="<?php echo e($goal_tracking->status); ?>" selected><?php echo e($goal_tracking->status); ?></option>
                            <option value="In Progress"><b>In Progress</b></option>
                            <option value="Completed"><b>Completed</b></option>
                        <?php elseif($goal_tracking->status == 'In Progress'): ?>
                            <option value="<?php echo e($goal_tracking->status); ?>" selected><?php echo e($goal_tracking->status); ?></option>
                            <option value="Not Started" selected><b>Not Started</b></option>
                            <option value="Completed"><b>Completed</b></option>
                        <?php elseif($goal_tracking->status == 'Completed'): ?>
                            <option value="<?php echo e($goal_tracking->status); ?>" selected><?php echo e($goal_tracking->status); ?></option>
                            <option value="Not Started" selected><b>Not Started</b></option>
                            <option value="In Progress"><b>In Progress</b></option>
                        <?php endif; ?>
                  </select>
              </div>
          </div>
    </div>    
</form>




<script>
    $('#start_date').datepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#end_date').datepicker({
        uiLibrary: 'bootstrap4'
    });
</script><?php /**PATH D:\xampp\htdocs\Lion_Coders\10.01.2020\peoplepro\resources\views/performance/goal-tracking/update-form.blade.php ENDPATH**/ ?>