<div id="EditformModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title"><?php echo e(__('Edit Appraisal')); ?></h5>
                <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
            </div>

            <div class="modal-body">
                <span id="form_result"></span>
                <form method="post" id="submit_form" class="form-horizontal">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Company</b></label>
                                <select name="company_id" id="company_id" class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="begins"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>...'>
                                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo e(__('Employee')); ?></label>
                                <select name="employee_id" id="employee_id" class=" form-control">
                                        <option value="">-- Select --</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Customer Experience</b></label>
                                <select name="customer_experience" id="customer_experience" class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="begins"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title='<?php echo e(__('--Select Experinece--')); ?>'>
                                    <option value="None">None</option>
                                    <option value="Begginer">Begginer</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert/Leader">Expert/Leader</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Marketing</b></label>
                                <select name="marketing" id="marketing" class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="begins"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title='<?php echo e(__('--Select Marketing--')); ?>'>
                                    <option value="None">None</option>
                                    <option value="Begginer">Begginer</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert/Leader">Expert/Leader</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Administration</b></label>
                                <select name="administration" id="administration" class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="begins"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title='<?php echo e(__('--Select Administration--')); ?>'>
                                    <option value="None">None</option>
                                    <option value="Begginer">Begginer</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert/Leader">Expert/Leader</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Professionalism</b></label>
                                <select name="professionalism" id="professionalism" class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="begins"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title='<?php echo e(__('--Select Professionalism--')); ?>'>
                                    <option value="None">None</option>
                                    <option value="Begginer">Begginer</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert/Leader">Expert/Leader</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Integrity</b></label>
                                <select name="integrity" id="integrity" class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="begins"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title='<?php echo e(__('--Select Integrity--')); ?>'>
                                    <option value="None">None</option>
                                    <option value="Begginer">Begginer</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert/Leader">Expert/Leader</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Attendance</b></label>
                                <select name="attendance" id="attendance" class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="begins"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title='<?php echo e(__('--Select Attendance--')); ?>'>
                                    <option value="None">None</option>
                                    <option value="Begginer">Begginer</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert/Leader">Expert/Leader</option>
                                </select>
                            </div>
                        </div>


                        <div class="container">
                            <div class="form-group" align="center">
                                <input type="hidden" name="action" id="action"/>
                                <input type="hidden" name="hidden_id" id="hidden_id"/>
                                <input type="submit" name="action_button" id="submit" class="btn btn-warning" value=<?php echo e(trans('file.Add')); ?> />
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\Lion-Coders\peoplepro\resources\views/appraisal/edit-form-modal.blade.php ENDPATH**/ ?>