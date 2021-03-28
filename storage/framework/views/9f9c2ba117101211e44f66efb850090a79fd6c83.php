
$('#employee_payslip-table').DataTable().clear().destroy();


var table_table = $('#employee_payslip-table').DataTable({
    initComplete: function () {
        this.api().columns([0]).every(function () {
            var column = this;
            var select = $('<select><option value=""></option></select>')
                .appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });

            column.data().unique().sort().each(function (d, j) {
                select.append('<option value="' + d + '">' + d + '</option>');
                $('select').selectpicker('refresh');
            });
        });
    },
    responsive: true,
    fixedHeader: {
        header: true,
        footer: true
    },
    processing: true,
    serverSide: true,
    ajax: {
        url: "<?php echo e(route('employee_payslip.index',$employee->id)); ?>",
    },

    columns: [
        {
            data: 'net_salary',
            name: 'net_salary',
render: function (data) {
if ('<?php echo e(config('variable.currency_format') ==='suffix'); ?>') {
return data + ' <?php echo e(config('variable.currency')); ?>';
} else {
return '<?php echo e(config('variable.currency')); ?> ' + data;

}
}
        },
        {
            data: 'month_year',
            name: 'month_year',
        },
        {
            data: 'created_at',
            name: 'created_at',

        },
        {
            data: 'status',
            name: 'status',
render: function (data) {
if (data === 1) {
return "<td><div class = 'badge badge-success'><?php echo e(trans('file.Paid')); ?></div>"
    } else {
    return "<td><div class = 'badge badge-danger'><?php echo e(trans('file.Unpaid')); ?></div>"
    }
    }
    },        {
            data: 'action',
            name: 'action',
            orderable: false
        }
    ],


    "order": [],
    'language': {
        'lengthMenu': '_MENU_ <?php echo e(__("records per page")); ?>',
        "info": '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
        "search": '<?php echo e(trans("file.Search")); ?>',
        'paginate': {
            'previous': '<?php echo e(trans("file.Previous")); ?>',
            'next': '<?php echo e(trans("file.Next")); ?>'
        }
    },
    'columnDefs': [
        {
            "orderable": false,
            'targets': [0, 4],
        },
    ],


    'select': {style: 'multi', selector: 'td:first-child'},
    'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
    dom: '<"row"lfB>rtip',
    buttons: [
        {
            extend: 'pdf',
            text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
            exportOptions: {
                columns: ':visible:Not(.not-exported)',
                rows: ':visible'
            },
        },
        {
            extend: 'csv',
            text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
            exportOptions: {
                columns: ':visible:Not(.not-exported)',
                rows: ':visible'
            },
        },
        {
            extend: 'print',
            text: '<i title="print" class="fa fa-print"></i>',
            exportOptions: {
                columns: ':visible:Not(.not-exported)',
                rows: ':visible'
            },
        },
        {
            extend: 'colvis',
            text: '<i title="column visibility" class="fa fa-eye"></i>',
            columns: ':gt(0)'
        },
    ],
});
new $.fn.dataTable.FixedHeader(table_table);

$(document).on('click', '.show_payslip', function () {
    //individual salary id from pay_list table
    let id = $(this).attr('id');

    let currency_format = '<?php echo e(config('variable.currency_format')); ?>';


    //target contains payslip.show
    let target = '<?php echo e(route('paySlip.index')); ?>/' + id;

    $.ajax({
    url: target,
    dataType: "json",
    success: function (result) {
    $('#employee_username').html(result.data.employee_username);
    $('#employee_full_name').html(result.data.employee_full_name);
    $('#employee_designation').html(result.data.employee_designation);
    $('#employee_department').html(result.data.employee_department);
    $('#employee_join_date').html(result.data.employee_join_date);
    $('#employee_id').attr("href","<?php echo e(url('staff/employees/')); ?>/"+result.data.employee_id);
    if (result.data.employee_pp==='') {
    $('#employee_pp').html("<img src=<?php echo e(URL::to('/public')); ?>/uploads/profile_photos/avatar.jpg  width='100'  class='rounded-circle' />");
    }
    else {
    $('#employee_pp').html("<img src=<?php echo e(URL::to('/public')); ?>/uploads/profile_photos/" + result.data.employee_pp + " width='100'  class='rounded-circle' />");
    }


    let total_allowance = 0;
    (result.data.allowances).forEach(function (a) {
    total_allowance = total_allowance + parseFloat(a.allowance_amount);
    $('#allowance_info').append('<tr><td><strong>'+ a.allowance_title+ '---</strong><div class="pull-right">'+a.allowance_amount+'</div></td></tr>');
    });
    let total_commission = 0;
    (result.data.commissions).forEach(function (a) {
    total_commission = total_commission + parseFloat(a.commission_amount);
    $('#commission_info').append('<tr><td><strong>'+ a.commission_title+'---</strong><span class="pull-right">'+a.commission_amount+'</span></td></tr>');
    });
    let total_loan = 0;
    (result.data.loans).forEach(function (a) {
    total_loan = total_loan + parseFloat(a.monthly_payable);
    $('#loan_info').append('<tr>' +
        '<td><strong>Total Loan---     </strong> <div class="float-right">'+a.loan_amount+'</div></td>' +
        '<td><strong>Monthly Payable---     </strong> <div class="float-right">'+a.monthly_payable+'</div></td>' +
        '<td><strong>Installment Remaining---     </strong> <div class="float-right">'+a.time_remaining+'</div></td>' +
        '<td><strong>Amount Remaining---     </strong> <div class="float-right">'+a.amount_remaining+'</div></td>' +
        '</tr>');
    });
    let count = 0;
    let total_overtime = 0;
    (result.data.overtimes).forEach(function (a) {
    count = count +1;
    total_overtime = total_overtime + (parseFloat(a.overtime_rate) * parseInt(a.overtime_hours));
    $('#overtime_info').append(
    '<tr>'+
        '<td><strong>'+ count+'</strong></td>' +
        '<td><strong>'+ a.overtime_title+'</strong></td>' +
        '<td><strong>'+ a.no_of_days+'</strong></td>' +
        '<td><strong>'+ a.overtime_hours+'</strong></td>' +
        '<td><strong>'+ a.overtime_rate+'</strong></td>'+
        '</tr>'
    );

    });
    let total_deduction = 0;
    (result.data.deductions).forEach(function (a) {
    total_deduction = total_deduction + parseFloat(a.deduction_amount);
    $('#deduction_info').append('<tr><td><strong>'+ a.deduction_title+'---</strong> <span class="float-right">'+a.deduction_amount+'</span></td></tr>');
    });
    let total_other_payment = 0;
    (result.data.other_payments).forEach(function (a) {
    total_other_payment = total_other_payment + parseFloat(a.other_payment_amount);
    $('#other_payment_info').append('<tr><td><strong>'+ a.other_payment_title+'---</strong><div class="float-right">'+a.other_payment_amount+'</div></td></tr>');
    });

    let total_salary = result.data.basic_salary + total_allowance - total_loan + total_commission
    - total_deduction + total_other_payment + total_overtime;

    if (currency_format == 'suffix') {
    $('#basic_salary_amount').html(result.data.basic_salary + ' <?php echo e(config('variable.currency')); ?>');
    $('#total_allowance').html(total_allowance + ' <?php echo e(config('variable.currency')); ?>');
    $('#total_commission').html(total_commission + ' <?php echo e(config('variable.currency')); ?>');
    $('#total_loan').html(total_loan + ' <?php echo e(config('variable.currency')); ?>');
    $('#total_overtime').html(total_overtime + ' <?php echo e(config('variable.currency')); ?>');
    $('#total_deduction').html(total_deduction + ' <?php echo e(config('variable.currency')); ?>');
    $('#total_other_payment').html(total_other_payment + ' <?php echo e(config('variable.currency')); ?>');
    $('#total_salary').html(total_salary + ' <?php echo e(config('variable.currency')); ?>');
    }
    else {
    $('#basic_salary_amount').html('<?php echo e(config('variable.currency')); ?> ' + result.data.basic_salary);
    $('#total_allowance').html('<?php echo e(config('variable.currency')); ?> '+ total_allowance);
    $('#total_commission').html('<?php echo e(config('variable.currency')); ?> ' + total_commission);
    $('#total_loan').html('<?php echo e(config('variable.currency')); ?> '+ total_loan);
    $('#total_overtime').html('<?php echo e(config('variable.currency')); ?> '+ total_overtime);
    $('#total_deduction').html('<?php echo e(config('variable.currency')); ?> '+ total_deduction);
    $('#total_other_payment').html('<?php echo e(config('variable.currency')); ?> '+ total_other_payment);
    $('#total_salary').html('<?php echo e(config('variable.currency')); ?> '+ total_salary);
    }

            $('#salary_model').modal('show');
        }
    });
});


$('.payslip-close').click(function () {
    $('#allowance_info').html('');
    $('#commission_info').html('');
    $('#loan_info').html('');
    $('#deduction_info').html('');
    $('#overtime_info').html('');
    $('#other_payment_info').html('');
    $('#total_salary').html('');
    $('#total_deduction').html('');
    $('#total_allowance').html('');
    $('#total_loan').html('');
    $('#total_overtime').html('');
    $('#total_other_payment').html('');
    $('#total_commission').html('');
    $('#pay_list-table').DataTable().ajax.reload();

});


<?php /**PATH C:\laragon\www\peoplepro\resources\views/employee/payslip/index_js.blade.php ENDPATH**/ ?>