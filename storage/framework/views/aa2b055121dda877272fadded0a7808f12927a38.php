<option value="">-- Select Employee--</option>
<?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($item->id); ?>"><?php echo e($item->first_name.' '.$item->last_name); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\xampp\htdocs\Lion-Coders\PeoplePro-Related\08.01.2020\peoplepro\resources\views/performance/appraisal/get-employee.blade.php ENDPATH**/ ?>