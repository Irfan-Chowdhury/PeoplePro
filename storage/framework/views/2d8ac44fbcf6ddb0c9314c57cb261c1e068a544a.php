<option value="">-- Select --</option>
<?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($designation->id); ?>"><?php echo e($designation->designation_name); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\xampp\htdocs\Lion-Coders\PeoplePro-Related\08.01.2020\peoplepro\resources\views/performance/indicator/get-designation.blade.php ENDPATH**/ ?>