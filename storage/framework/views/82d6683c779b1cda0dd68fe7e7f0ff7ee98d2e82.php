<?php $__env->startSection('title','Jobs'); ?>

<?php $__env->startSection('content'); ?>
<section class="jumbotron">
    <div class="container">
        <h1 class="h4"><?php echo e(__('We found')); ?> <?php echo e($job_posts->count()); ?> <?php echo e(__('active jobs')); ?></h1>
    </div>
</section>
<section>
    <!-- Recent Jobs -->
    <div class="container listings-container">
        <!-- Listing -->
        <div class="row">
            <div class="col-md-9 mt-3">
                <?php $__currentLoopData = $job_posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job_post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="job-listing card mb-5">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="<?php echo e(route('jobs.details',$job_post)); ?>">
                                    <h4><?php echo e($job_post->job_title); ?></h4></a>
                                <h6><?php echo e($job_post->Company->company_name ?? ''); ?></h6>
                            </div>
                            <div> 
                                <?php if($job_post->job_type === 'full_time'): ?>
                                <span class="badge badge-primary"><?php echo e(__('Full Time')); ?></span>
                                <?php elseif($job_post->job_type === 'part_time'): ?>
                                <span class="badge badge-primary"><?php echo e(__('Part Time')); ?></span>
                                <?php elseif($job_post->job_type === 'internship'): ?>
                                <span class="badge badge-primary"><?php echo e(trans('file.Internship')); ?></span>
                                <?php elseif($job_post->job_type === 'freelance'): ?>
                                <span class="badge badge-primary"><?php echo e(trans('file.Freelance')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <ul class="list-inline mb-0">
                            <li data-toggle="tooltip" data-placement="top" title="<?php echo e($job_post->no_of_vacancy); ?> <?php echo e(__('vacancy')); ?>"><i class="dripicons-user-group"></i> <?php echo e($job_post->no_of_vacancy); ?></li>
                            <li data-toggle="tooltip" data-placement="top" title="<?php echo e($job_post->min_experience); ?> <?php echo e(__('of experience')); ?>"><i class="dripicons-calendar"></i> <?php echo e($job_post->min_experience); ?></li>
                            <li data-toggle="tooltip" data-placement="top" title="<?php echo e(__('posted')); ?> <?php echo e($job_post->updated_at->diffForHumans()); ?>"><i class="dripicons-clock"></i> <?php echo e($job_post->updated_at->diffForHumans()); ?></li>
                        </ul>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="col-md-3 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e(trans('file.Category')); ?></h5>
                        <?php $__currentLoopData = $job_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('jobs.searchByCategory',$job_category->url)); ?>">
                                <p class="mb-1 text-muted"><?php echo e($job_category->job_category); ?></p>
                            </a>
                            <br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Job Type</h5>
                        <?php $__currentLoopData = $job_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('jobs.searchByJobType',$job_type->job_type)); ?>">
                            <p class="mb-1 text-muted"> 
                                <?php if($job_type->job_type === 'full_time'): ?>
                                    <?php echo e(__('Full Time')); ?>

                                <?php elseif($job_type->job_type === 'part_time'): ?>
                                    <?php echo e(__('Part Time')); ?>

                                <?php elseif($job_type->job_type === 'internship'): ?>
                                    <?php echo e(trans('file.Internship')); ?>

                                <?php elseif($job_type->job_type === 'freelance'): ?>
                                    <?php echo e(trans('file.Freelance')); ?>

                                <?php endif; ?>
                            </p>
                        </a>
                        <br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.Layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lion_Coders\Peoplepro\Running_File\peoplepro\resources\views/frontend/jobs/index.blade.php ENDPATH**/ ?>