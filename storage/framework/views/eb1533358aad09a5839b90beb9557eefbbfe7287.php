<?php $__env->startSection('content'); ?>


    <section>

        <div class="container-fluid"><span id="general_result"></span></div>

        <div class="table-responsive">
            <table id="payslips-table" class="table ">
                <thead>
                <tr>
                    <th>Payslip Number</th>
                    <th>Bank Account</th>
                    <th><?php echo e(trans('file.Employee')); ?></th>
                    <th class="text-center" >Salary Details</th>
                    <th class="text-center" >Salary Month</th>
                    <th><?php echo e(__('Payment Date')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
                </thead>

            </table>
        </div>
    </section>

    <script type="text/javascript">
        (function($) {  
            "use strict";

            $(document).ready(function () {

                var table_table = $('#payslips-table').DataTable({
                    initComplete: function () {
                        this.api().columns([1]).every(function () {
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
                        url: "<?php echo e(route('payment_history.index')); ?>",
                    },

                    columns: [
                        // {
                        //     data: 'id',
                        //     name: 'id',
                        // },
                        {
                            data: 'payslip_number',
                            name: 'payslip_number',
                        },
                        {
                            data: 'bank_account',
                            name: 'bank_account',
                        },
                        {
                            data: 'employee_name',
                            name: 'employee_name',
                        },
                        {
                            data: 'salary_details',
                            name: 'salary_details',
                        },
                        {
                            data: 'month_year',
                            name: 'month_year',
                        },
                        // {
                        //     data: 'net_payable',
                        //     name: 'net_payable',
                        //     render: function (data) {
                        //         if ("<?php echo e(config('variable.currency_format') ==='suffix'); ?>") {
                        //             return data + " <?php echo e(config('variable.currency')); ?>";
                        //         } else {
                        //             return "<?php echo e(config('variable.currency')); ?> " + data;

                        //         }
                        //     }
                        // },
                        {
                            data: 'created_at',
                            name: 'created_at',

                        },
                        {
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
                            'targets': [0,3,4,5],
                            "className": "text-center"
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
            });



            $('.close').on('click', function () {
                $('#payslips-table').DataTable().ajax.reload();
            });
        })(jQuery); 
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lion_Coders\Peoplepro\Running_File\peoplepro\resources\views/salary/payslip/index.blade.php ENDPATH**/ ?>