<?php $__env->startSection('content'); ?>
<?php $__env->startSection('title','Admin | Developer Section'); ?>


<?php echo $__env->make('includes.session_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<div class="container-fluid mb-3">
    <div class="row">
        <div class="col-4">
            <div class="card mb-0">
                <div id="collapse1" class="collapse show" aria-labelledby="generalSettings" data-parent="#accordion">
                    <div class="card-body">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="general-setting" data-toggle="list" href="#generalSetting" role="tab" aria-controls="home"><?php echo app('translator')->get('file.General Setting'); ?></a>
                            <a class="list-group-item list-group-item-action" id="bug-update-setting" data-toggle="list" href="#bugUpdateSetting" role="tab" aria-controls="home"><?php echo app('translator')->get('file.Bug Update Setting'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-8">
            <div class="tab-content" id="nav-tabContent">

                <!--General Setting-->
                <?php echo $__env->make('developer_section.general', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <!-- Bug Setting -->
                <?php echo $__env->make('developer_section.bug_update_setting', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    (function ($) {
        "use strict";

            $(document).on('click', '#addMoreFile', function(){
                console.log('ok');
                var rand = Math.floor(Math.random() * 90000) + 10000;
                $('.filesArea').append('<div class="row"><div class="col-8 form-group"><label><?php echo e(__('File Name')); ?></label><input type="text" name="file_name[]" required class="form-control" placeholder="<?php echo e(__('Type File Name')); ?>"></div><div class="form-group"><label>Delete</label><br><span class="btn btn-default btn-sm del-row"><i class="dripicons-trash"></i></span></div></div>');
            })
            $(document).on('click', '.del-row', function(){
                $(this).parent().parent().html('');
            })

            // Log
            $(document).on('click', '#addMoreLog', function(){
                console.log('ok');
                var rand = Math.floor(Math.random() * 90000) + 10000;
                $('.logArea').append('<div class="row"><div class="col-8 form-group"><label><?php echo e(__('File Name')); ?></label><input type="text" name="text[]" required class="form-control" placeholder="<?php echo e(__('Type File Name')); ?>"></div><div class="form-group"><label>Delete</label><br><span class="btn btn-default btn-sm del-row-log"><i class="dripicons-trash"></i></span></div></div>');
            })
            $(document).on('click', '.del-row-log', function(){
                $(this).parent().parent().html('');
            })
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/peoplepro/resources/views/developer_section/index.blade.php ENDPATH**/ ?>