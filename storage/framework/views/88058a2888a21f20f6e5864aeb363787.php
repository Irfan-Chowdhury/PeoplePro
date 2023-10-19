<?php $__env->startSection('content'); ?>

<section class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <img class="card-img-top" src="<?php echo e(asset('logo/peopleprosaas.png')); ?>" style="width:300px" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Peplepro SaaS</h5>
                    <p class="card-text">Take care of all your products, sales, purchases, stores related tasks from an easy-to-use platform, from anywhere you want, anytime you want.</p>
                    <a href="#" class="btn btn-danger p-2">Demo</a>
                    <a href="#" class="btn btn-info p-2">CodeCanyon</a>
                    <a href="#" class="btn btn-warning p-2">Documentation</a>
                    <a href="#" class="btn btn-primary p-2">Go to Install</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro_testsaas/resources/views/addons/saas/index.blade.php ENDPATH**/ ?>