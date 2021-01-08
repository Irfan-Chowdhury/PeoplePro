<form action="" method="POST" id="submitEditForm">
    <?php echo csrf_field(); ?>
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Goal Type</b></label>
        <div class="col-sm-10">
            <input type="text" class="form-control goal_type_edit" name="goal_type" id="goalEditType" value="<?php echo e($data->goal_type); ?>">
            <input type="hidden" name="goal_type_id" id="goalTypeId" value="<?php echo e($data->id); ?>">
            <div class="invalid-feedback">
                <p id="error_edit_message"></p>
            </div>
        </div>
    </div>
</form>

<?php /**PATH D:\xampp\htdocs\Lion_Coders\08.01.2020\peoplepro\resources\views/performance/goal-type/show-data.blade.php ENDPATH**/ ?>