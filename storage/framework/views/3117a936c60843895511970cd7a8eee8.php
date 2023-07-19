<?php $__env->startSection('title_front','Home'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <?php echo html_entity_decode($home); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.Layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-L-10.15/resources/views/frontend/cms/home.blade.php ENDPATH**/ ?>