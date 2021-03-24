<?php $__env->startSection('title','Contact'); ?>

<?php $__env->startSection('content'); ?>
<section class="jumbotron">
    <div class="container">
        <h1 class="h4"><?php echo e(__('Contact Us')); ?></h1>
    </div>
</section>
<div class="container">
    <?php echo html_entity_decode($contact); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.Layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lion_Coders\Peoplepro\Running_File\peoplepro\resources\views/frontend/cms/contact.blade.php ENDPATH**/ ?>