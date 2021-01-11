<form action="" method="POST" id="updatetForm">
    <?php echo csrf_field(); ?> 

    <input type="hidden" name="indicator_id" id="indicatorId" value="<?php echo e($indicator->id); ?>">
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Company</b></label>
        <div class="col-sm-6">
            

            <select name="company_id" id="companyIdEdit" class="form-control">
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
            <select name="designation_id" id="designationIdEdit" class="form-control">
                <option value="<?php echo e($indicator->designation_id); ?>"><?php echo e($indicator->designation->designation_name); ?></option>
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
                    <select name="customer_experience" id="customerExperience" class="form-control">
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
                    <select name="administrator" id="administrator" class="form-control">
                        <?php if($indicator->administrator == 'None'): ?>
                            <option value="<?php echo e($indicator->administrator); ?>" selected><?php echo e($indicator->administrator); ?></option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->administrator == 'Beginner'): ?>
                            <option value="None" selected>None</option>
                            <option value="<?php echo e($indicator->administrator); ?>" selected><?php echo e($indicator->administrator); ?></option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->administrator == 'Intermidiate'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="<?php echo e($indicator->administrator); ?>" selected><?php echo e($indicator->administrator); ?></option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->administrator == 'Advanced'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="<?php echo e($indicator->administrator); ?>" selected><?php echo e($indicator->administrator); ?></option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->administrator == 'Expert/Leader'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="<?php echo e($indicator->administrator); ?>" selected><?php echo e($indicator->administrator); ?></option>
                        <?php endif; ?>
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
                    <select name="professionalism" id="professionalism" class="form-control">
                        <?php if($indicator->professionalism == 'None'): ?>
                            <option value="<?php echo e($indicator->professionalism); ?>" selected><?php echo e($indicator->professionalism); ?></option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->professionalism == 'Beginner'): ?>
                            <option value="None" selected>None</option>
                            <option value="<?php echo e($indicator->professionalism); ?>" selected><?php echo e($indicator->professionalism); ?></option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->professionalism == 'Intermidiate'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="<?php echo e($indicator->professionalism); ?>" selected><?php echo e($indicator->professionalism); ?></option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->professionalism == 'Advanced'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="<?php echo e($indicator->professionalism); ?>" selected><?php echo e($indicator->professionalism); ?></option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->professionalism == 'Expert/Leader'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="<?php echo e($indicator->professionalism); ?>" selected><?php echo e($indicator->professionalism); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Integrity</b></label>
                <div class="col-sm-6">
                    <select name="integrity" id="integrity" class="form-control">
                        <?php if($indicator->integrity == 'None'): ?>
                            <option value="<?php echo e($indicator->integrity); ?>" selected><?php echo e($indicator->integrity); ?></option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->integrity == 'Beginner'): ?>
                            <option value="None" selected>None</option>
                            <option value="<?php echo e($indicator->integrity); ?>" selected><?php echo e($indicator->integrity); ?></option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->integrity == 'Intermidiate'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="<?php echo e($indicator->integrity); ?>" selected><?php echo e($indicator->integrity); ?></option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->integrity == 'Advanced'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="<?php echo e($indicator->integrity); ?>" selected><?php echo e($indicator->integrity); ?></option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->integrity == 'Expert/Leader'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="<?php echo e($indicator->integrity); ?>" selected><?php echo e($indicator->integrity); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Attendance</b></label>
                <div class="col-sm-6">
                    <select name="attendance" id="attendance" class="form-control">
                        <?php if($indicator->attendance == 'None'): ?>
                            <option value="<?php echo e($indicator->attendance); ?>" selected><?php echo e($indicator->attendance); ?></option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->attendance == 'Beginner'): ?>
                            <option value="None" selected>None</option>
                            <option value="<?php echo e($indicator->attendance); ?>" selected><?php echo e($indicator->attendance); ?></option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->attendance == 'Intermidiate'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="<?php echo e($indicator->attendance); ?>" selected><?php echo e($indicator->attendance); ?></option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->attendance == 'Advanced'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="<?php echo e($indicator->attendance); ?>" selected><?php echo e($indicator->attendance); ?></option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        <?php elseif($indicator->attendance == 'Expert/Leader'): ?>
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="<?php echo e($indicator->attendance); ?>" selected><?php echo e($indicator->attendance); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

</form>


<script>
    $('#companyIdEdit').change(function() {   
        var companyIdEdit = $(this).val();

        if (companyIdEdit){
            $.get("<?php echo e(route('performance.indicator.get-designation-by-company')); ?>",{company_id:companyIdEdit}, function (data){
                console.log(data);
                $('#designationIdEdit').empty().html(data);
            });
        }else{
            $('#designationIdEdit').empty().html('<option>--Select Student Type--</option>');
        }
    })
</script><?php /**PATH C:\xampp\htdocs\Lion-Coders\PeoplePro-Related\10.01.2020\peoplepro\resources\views/performance/indicator/show-data.blade.php ENDPATH**/ ?>