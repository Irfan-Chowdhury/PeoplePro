<div class="row">
    <div class="col-md-3">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-details-employee')): ?>
            <ul class="nav nav-tabs vertical" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="salary-tab" data-toggle="tab" href="#Salary" role="tab"
                       aria-controls="Salary" aria-selected="true"><?php echo e(__('Basic Salary')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('salary_allowance.show',$employee)); ?>" id="salary_allowance-tab"
                       data-toggle="tab" data-table="salary_allowance" data-target="#Salary_allowance" role="tab"
                       aria-controls="Salary_allowance" aria-selected="false"><?php echo e(trans('file.Allowances')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('salary_commission.show',$employee)); ?>" id="salary_commission-tab"
                       data-toggle="tab" data-table="salary_commission" data-target="#Salary_commission" role="tab"
                       aria-controls="Salary_commission" aria-selected="false"><?php echo e(trans('file.Commissions')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('salary_loan.show',$employee)); ?>" id="salary_loan-tab"
                       data-toggle="tab" data-table="salary_loan" data-target="#Salary_loan" role="tab"
                       aria-controls="Salary_loan" aria-selected="false"><?php echo e(trans('file.Loan')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('salary_deduction.show',$employee)); ?>" id="salary_deduction-tab"
                       data-toggle="tab" data-table="salary_deduction" data-target="#Salary_deduction" role="tab"
                       aria-controls="Salary_deduction" aria-selected="false"><?php echo e(__('Statutory Deductions')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('other_payment.show',$employee)); ?>" id="other_payment-tab"
                       data-toggle="tab" data-table="other_payment" data-target="#Other_payment" role="tab"
                       aria-controls="Other_payment" aria-selected="false"><?php echo e(__('Other Payment')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('salary_overtime.show',$employee)); ?>" id="salary_overtime-tab"
                       data-toggle="tab" data-table="salary_overtime" data-target="#Salary_overtime" role="tab"
                       aria-controls="Salary_overtime" aria-selected="false"><?php echo e(__('Overtime')); ?></a>
                </li>
            </ul>
        <?php endif; ?>
    </div>

    <div class="col-md-9">
        <div class="tab-content" id="myTabContent">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('set-salary')): ?>
            <div class="tab-pane fade show active" id="Salary" role="tabpanel" aria-labelledby="salary-tab">
                <!--Contents for Basic starts here-->
                <?php echo e(trans('file.Update')); ?> <?php echo e(trans('file.Salary')); ?>

                <hr>

                <div class="modal-body">
                    <span id="salary_form_result"></span>
                    <form method="post" id="salary_sample_form" class="form-horizontal" autocomplete="off">

                        <?php echo csrf_field(); ?>
                        <div class="row">

                            <div class="col-md-4 form-group">
                                <label><?php echo e(__('Payslip Type')); ?> *</label>
                                <input type="hidden" name="payslip_type_hidden"
                                       value="<?php echo e($employee->payslip_type ?? ''); ?>"/>
                                <select name="payslip_type" id="payslip_type" required class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="begins"
                                        title="<?php echo e(__('Selecting',['key'=>__('Payslip Type')])); ?>...">
                                    <option value="Monthly"><?php echo e(__('Monthly Payslip')); ?></option>
                                    <option value="Hourly"><?php echo e(__('Hourly Payslip')); ?></option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <?php if(config('variable.currency_format')==='suffix'): ?>
                                    <label><?php echo e(__('Basic Salary')); ?> (<?php echo e(config('variable.currency')); ?>)</label>
                                <?php else: ?>
                                    <label>(<?php echo e(config('variable.currency')); ?>) <?php echo e(__('Basic Salary')); ?></label>
                                <?php endif; ?>

                                <input type="text" name="basic_salary" id="basic_salary"
                                       placeholder="<?php echo e(__('Basic Salary')); ?>"
                                       required class="form-control" value="<?php echo e($employee->basic_salary ?? ''); ?>">
                            </div>


                        </div>

                        <div class="container mt-30px">
                            
                            <span class="text-danger"><i>[NB: If you didn't pay the employee's previous due, the current amount will be treated as the previous amount.]</i></span> <br><br>
                            <div class="form-group">
                                <input type="submit" class="btn btn-warning" value=<?php echo e(trans('file.Add')); ?> />
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <?php endif; ?>


            <div class="tab-pane fade" id="Salary_allowance" role="tabpanel" aria-labelledby="salary_allowance-tab">
                <?php echo e(__('All allowances')); ?>

                <hr>

                <?php echo $__env->make('employee.salary.allowance.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            </div>
            <div class="tab-pane fade" id="Salary_commission" role="tabpanel" aria-labelledby="Salary_commission-tab">
                <?php echo e(__('All commission')); ?>

                <hr>

                <?php echo $__env->make('employee.salary.commission.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            </div>

            <div class="tab-pane fade" id="Salary_loan" role="tabpanel" aria-labelledby="Salary_loan-tab">
                <?php echo e(__('All Loan')); ?>

                <hr>

                <?php echo $__env->make('employee.salary.loan.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            </div>


            <div class="tab-pane fade" id="Salary_deduction" role="tabpanel" aria-labelledby="Salary_deduction-tab">
                <?php echo e(__('All Statutory Deduction')); ?>

                <hr>

                <?php echo $__env->make('employee.salary.deduction.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="tab-pane fade" id="Other_payment" role="tabpanel" aria-labelledby="Other_payment-tab">
                <?php echo e(__('Other Payment')); ?>

                <hr>

                <?php echo $__env->make('employee.salary.other_payment.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="tab-pane fade" id="Salary_overtime" role="tabpanel" aria-labelledby="Salary_overtime-tab">
                <?php echo e(__('Overtime')); ?>

                <hr>
                <?php echo $__env->make('employee.salary.overtime.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</div>

<script>
$('select[name="payslip_type"]').val($('input[name="payslip_type_hidden"]').val());
</script>

<?php /**PATH C:\laragon\www\peoplepro\resources\views/employee/salary/index.blade.php ENDPATH**/ ?>