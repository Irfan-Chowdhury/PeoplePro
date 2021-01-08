<option value="">-- Select --</option>
<?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->first_name.' '.$employee->last_name); ?> </option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH D:\xampp\htdocs\Lion_Coders\08.01.2020\peoplepro\resources\views/appraisal/get-employee.blade.php ENDPATH**/ ?>