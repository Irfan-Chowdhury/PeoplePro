<?php $__env->startSection('title','Home'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <?php echo html_entity_decode($home); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.Layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lion_Coders\Peoplepro\Running_File\peoplepro\resources\views/frontend/cms/home.blade.php ENDPATH**/ ?>