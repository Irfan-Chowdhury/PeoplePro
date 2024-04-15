<?php if($errors->any()): ?>
    <div class="alert alert-danger text-left">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span><?php echo e($error); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/peoplepro/peopleprohrm/resources/views/shared/errors.blade.php ENDPATH**/ ?>