<?php if(session()->has('msg')): ?>
    <div class="alert alert-<?php echo e(session('type')); ?> alert-dismissible text-center">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button><?php echo session('msg'); ?></div>
<?php endif; ?>
<?php /**PATH /var/www/html/peoplepro/peoplepro_latest/resources/views/shared/flash_message.blade.php ENDPATH**/ ?>