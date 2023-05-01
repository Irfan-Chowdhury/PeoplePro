<div class="tab-pane fade" id="versionUpgradeSetting" role="tabpanel" aria-labelledby="version-upgrade-setting">
    <div class="card">
        <h4 class="card-header p-3"><b><?php echo app('translator')->get('file.Version Upgrade Setting'); ?></b></h4>
        <hr>
        <div class="card-body">
            <form action="<?php echo e(route('admin.version-upgrade-setting.submit')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <!----------------------------------- Files ------------------------------------------>

                <h5><b><?php echo app('translator')->get('Files'); ?></b></h5>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <div class="filesArea">
                            <?php if(isset($versionUpgradeSettings->files)): ?>
                                <?php $__currentLoopData = $versionUpgradeSettings->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row">
                                        <div class="col-8 form-group">
                                            <label><?php echo e(__('file.File Name')); ?></label>
                                            <input value="<?php echo e($item->file_name); ?>" type="text" name="file_name[]" class="form-control" placeholder="<?php echo e(__('file.Type File Name')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('file.Delete'); ?></label><br>
                                            <span class="btn btn-default btn-sm del-row"><i class="dripicons-trash"></i></span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-8 form-group">
                                        <label><?php echo e(__('file.File Name')); ?></label>
                                        <input type="text" name="file_name[]" class="form-control" placeholder="<?php echo e(__('file.Type File Name')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo app('translator')->get('file.Delete'); ?></label><br>
                                        <span class="btn btn-default btn-sm del-row"><i class="dripicons-trash"></i></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <span class="btn btn-link add-more" id="addMoreFile"><i class="dripicons-plus"></i> <?php echo app('translator')->get('file.Add More'); ?></span>
                    </div>
                </div>

                <!----------------------------------- Change Log ------------------------------------------>
                <hr>
                <h5><b><?php echo app('translator')->get('file.Logs'); ?></b></h5>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <div class="logArea">
                            <?php if(isset($versionUpgradeSettings->logs)): ?>
                                <?php $__currentLoopData = $versionUpgradeSettings->logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row">
                                        <div class="col-8 form-group">
                                            <label><?php echo e(__('file.Type Log')); ?></label>
                                            <input value="<?php echo e($item->text); ?>" type="text" name="text[]" class="form-control" placeholder="<?php echo e(__('file.Type Log')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('file.Delete'); ?></label><br>
                                            <span class="btn btn-default btn-sm del-row-log"><i class="dripicons-trash"></i></span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-8 form-group">
                                        <label><?php echo e(__('file.Type Log')); ?></label>
                                        <input type="text" name="text[]" class="form-control" placeholder="<?php echo e(__('file.Type Log')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo app('translator')->get('file.Delete'); ?></label><br>
                                        <span class="btn btn-default btn-sm del-row-log"><i class="dripicons-trash"></i></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <span class="btn btn-link add-more" id="addMoreLog"><i class="dripicons-plus"></i> <?php echo app('translator')->get('file.Add More'); ?></span>
                    </div>
                </div>

                <div class="form-group row">
                    <button type="submit" class="btn btn-primary btn-lg btn-block"><?php echo app('translator')->get('file.Submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /opt/lampp/htdocs/peoplepro/resources/views/developer_section/version_upgrade_setting.blade.php ENDPATH**/ ?>