<?php if(session()->has('msg')): ?>
    <div class="alert alert-<?php echo e(session('type')); ?> alert-dismissible text-center">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button><?php echo e(session('msg')); ?></div>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\Lion_Coders\09.01.2020\peoplepro\resources\views/shared/flash_message.blade.php ENDPATH**/ ?>