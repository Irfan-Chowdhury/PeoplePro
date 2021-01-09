<form action="" method="POST" id="submitForm">
    <?php echo csrf_field(); ?> 
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Company</b></label>
        <div class="col-sm-6">
            

            <select name="company_id" id="companyId" class="form-control">
                <option value="">-- Select --</option>
                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($company->id); ?>" <?php echo e($company->id == $indicator->company_id ? 'selected="selected"' : ''); ?>><?php echo e($company->company_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
            </select>   
        </div>
    </div>

    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Designation</b></label>
        <div class="col-sm-6" id="designation-selection">
            <select name="designation_id" id="designationId-edit" class=" form-control">
                
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <h5><b>Technical Competencies</b></h5>
            <br>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Customer
                        Experience</b></label>
                <div class="col-sm-6">
                    <select name="customer_experience" id="customerExperience"
                        class="form-control" title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>'>
                        <?php if($indicator->customer_experience == 'None'): ?>
                            <option value="<?php echo e($indicator->customer_experience); ?>" selected><?php echo e($indicator->customer_experience); ?></option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->customer_experience == 'Beginner'): ?>
                            <option value="None" selected>None</option>
                            <option value="<?php echo e($indicator->customer_experience); ?>" selected><?php echo e($indicator->customer_experience); ?></option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->customer_experience == 'Intermidiate'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="<?php echo e($indicator->customer_experience); ?>" selected><?php echo e($indicator->customer_experience); ?></option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->customer_experience == 'Advanced'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="<?php echo e($indicator->customer_experience); ?>" selected><?php echo e($indicator->customer_experience); ?></option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->customer_experience == 'Expert/Leader'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="<?php echo e($indicator->customer_experience); ?>" selected><?php echo e($indicator->customer_experience); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Marketing</b></label>
                <div class="col-sm-6">
                    <select name="marketing" id="marketing" class="form-control dynamic">
                        <?php if($indicator->marketing == 'None'): ?>
                            <option value="<?php echo e($indicator->marketing); ?>" selected><?php echo e($indicator->marketing); ?></option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->marketing == 'Beginner'): ?>
                            <option value="None" selected>None</option>
                            <option value="<?php echo e($indicator->marketing); ?>" selected><?php echo e($indicator->marketing); ?></option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->marketing == 'Intermidiate'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="<?php echo e($indicator->marketing); ?>" selected><?php echo e($indicator->marketing); ?></option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->marketing == 'Advanced'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="<?php echo e($indicator->marketing); ?>" selected><?php echo e($indicator->marketing); ?></option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->marketing == 'Expert/Leader'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="<?php echo e($indicator->marketing); ?>" selected><?php echo e($indicator->marketing); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Administration</b></label>
                <div class="col-sm-6">
                    <select name="administrator" id="administrator"
                        class="form-control selectpicker dynamic" data-live-search="true"
                        data-live-search-style="begins" data-first_name="first_name"
                        data-last_name="last_name"
                        title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>'>
                        <option value="None" selected>None</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermidiate">Intermidiate</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Expert/Leader">Expert/Leader</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h5><b>Organizational Competencies</b></h5>
            <br>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Professionalism</b></label>
                <div class="col-sm-6">
                    <select name="professionalism" id="professionalism"
                        class="form-control selectpicker dynamic" data-live-search="true"
                        data-live-search-style="begins" data-first_name="first_name"
                        data-last_name="last_name"
                        title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>'>
                        <option value="None" selected>None</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermidiate">Intermidiate</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Expert/Leader">Expert/Leader</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Integrity</b></label>
                <div class="col-sm-6">
                    <select name="integrity" id="integrity" class="form-control selectpicker dynamic"
                        data-live-search="true" data-live-search-style="begins"
                        data-first_name="first_name" data-last_name="last_name"
                        title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>'>
                        <option value="None" selected>None</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermidiate">Intermidiate</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Expert/Leader">Expert/Leader</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Attendance</b></label>
                <div class="col-sm-6">
                    <select name="attendance" id="attendance" class="form-control selectpicker dynamic"
                        data-live-search="true" data-live-search-style="begins"
                        data-first_name="first_name" data-last_name="last_name"
                        title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>'>
                        <option value="None" selected>None</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermidiate">Intermidiate</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Expert/Leader">Expert/Leader</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

</form>


<script>
    //after selecting Company then Employee will be loaded
    $('#companyId').change(function() 
        {
            var companyId = $(this).val();
            if (companyId) 
            {

                $.get("<?php echo e(route('performance.indicator.get-designation-by-company')); ?>",{company_id:companyId}, function (data) 
                {
                    // console.log(data);
                    $('#designationId-edit').empty().html(data); //
                });
            }
            else{
                $('#designationId-edit').empty().html('<option>--Select --</option>');
            }
        })
</script><?php /**PATH D:\xampp\htdocs\Lion_Coders\08.01.2020\peoplepro\resources\views/performance/indicator/show-data.blade.php ENDPATH**/ ?>