<?php $__env->startSection('content'); ?>



    <section>

        <div class="container-fluid"><span id="general_result"></span></div>


        <div class="container-fluid mb-3">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-employee')): ?>
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> <?php echo e(__('Add Employee')); ?></button>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-employee')): ?>
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> <?php echo e(__('Bulk delete')); ?></button>
            <?php endif; ?>
        </div>


        <div class="table-responsive">
            <table id="employee-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Name')); ?></th>
                    <th><?php echo e(trans('file.Company')); ?></th>
                    <th><?php echo e(trans('file.Department')); ?></th>
                    <th><?php echo e(trans('file.Designation')); ?></th>
                    <th><?php echo e(trans('file.Phone')); ?></th>
                    <th><?php echo e(trans('file.Email')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
                </thead>

            </table>
        </div>
    </section>



    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(__('Add Employee')); ?></h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="employee-close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal">

                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('First Name')); ?> *</label>
                                <input type="text" name="first_name" id="first_name" placeholder="<?php echo e(__('First Name')); ?>"
                                       required class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Last Name')); ?> *</label>
                                <input type="text" name="last_name" id="last_name" placeholder="<?php echo e(__('Last Name')); ?>"
                                       required class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Email')); ?> *</label>
                                <input type="email" name="email" id="email" placeholder="example@example.com" required
                                       class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Phone')); ?> *</label>
                                <input type="text" name="contact_no" id="contact_no"
                                       placeholder="<?php echo e(trans('file.Phone')); ?>" required
                                       class="form-control" value="<?php echo e(old('contact_no')); ?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Date Of Birth')); ?> *</label>
                                <input type="text" name="date_of_birth" id="date_of_birth" required autocomplete="off"
                                       class="form-control date" value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Gender')); ?> *</label>
                                <select name="gender" id="gender" required class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="begins"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Gender')])); ?>...">
                                    <option value="Male"><?php echo e(trans('file.Male')); ?></option>
                                    <option value="Female"><?php echo e(trans('file.Female')); ?></option>
                                    <option value="Other"><?php echo e(trans('file.Other')); ?></option>
                                </select>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Company')); ?></label>
                                    <select name="company_id" id="company_id" required
                                            class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="begins"
                                            data-shift_name="shift_name" data-dependent="department_name"
                                            title="<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>...">
                                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Department')); ?></label>
                                    <select name="department_id" id="department_id"
                                            class="selectpicker form-control designation"
                                            data-live-search="true" data-live-search-style="begins"
                                            data-designation_name="designation_name"
                                            title="<?php echo e(__('Selecting',['key'=>trans('file.Department')])); ?>...">
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Designation')); ?></label>
                                <select name="designation_id" id="designation_id" class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="begins"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Designation')])); ?>...">
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Office Shift')); ?></label>
                                <select name="office_shift_id" id="office_shift_id" class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="begins"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Office Shift')])); ?>...">
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Username')); ?> *</label>
                                <input type="text" name="username" id="username"
                                       placeholder="<?php echo e(__('Unique Value',['key'=>trans('file.Username')])); ?>"
                                       required class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Role')); ?> *</label>
                                <select name="role_users_id" id="role_users_id" required
                                        class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="begins"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Role')])); ?>...">
                                    <option value="1">Admin</option>
                                    <option value="2">Employee</option>
                                </select>
                            </div>

                            
                            
                            
                            
                            
                            
                            
                            
                            
                            


                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Password')); ?> *</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                           placeholder="<?php echo e(trans('file.Password')); ?>"
                                           required class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Confirm Password')); ?> *</label>
                                <div class="input-group">
                                    <input id="confirm_pass" type="password"
                                           class="form-control "
                                           name="password_confirmation" placeholder="<?php echo e(__('Re-type Password')); ?>"
                                           required autocomplete="new-password">
                                </div>
                                <div class="form-group">
                                    <div class="registrationFormAlert" id="divCheckPasswordMatch">
                                    </div>
                                </div>
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="action"/>
                                    <input type="hidden" name="hidden_id" id="hidden_id"/>
                                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                           value="<?php echo e(trans('file.Add')); ?>" />
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>








    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title"><?php echo e(trans('file.Confirmation')); ?></h2>
                    <button type="button" class="employee-close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;"><?php echo e(__('Are you sure you want to remove this data?')); ?></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button"
                            class="btn btn-danger"><?php echo e(trans('file.OK')); ?></button>
                    <button type="button" class="close btn-default"
                            data-dismiss="modal"><?php echo e(trans('file.Cancel')); ?></button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function () {


            var date = $('.date');
            date.datepicker({
                format: '<?php echo e(env('Date_Format_JS')); ?>',
                autoclose: true,
                todayHighlight: true
            });


            var table_table = $('#employee-table').DataTable({
                initComplete: function () {
                    this.api().columns([2, 4]).every(function () {
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
                    url: "<?php echo e(route('employees.index')); ?>",
                },

                columns: [

                    {
                        data: null,
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                    {
                        data: 'company',
                        name: 'company',
                    },
                    {
                        data: 'department',
                        name: 'department',
                    },
                    {
                        data: 'designation',
                        name: 'designation',
                    },
                    {
                        data: 'contact_no',
                        name: 'contact_no',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ],


                "order": [],
                'language': {
                    'lengthMenu': '_MENU_ <?php echo e(__('records per page')); ?>',
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
                        'targets': [0, 7],
                    },
                    {
                        'render': function (data, type, row, meta) {
                            if (type === 'display') {
                                data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                            }

                            return data;
                        },
                        'checkboxes': {
                            'selectRow': true,
                            'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                        },
                        'targets': [0]
                    }
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


        $('#create_record').click(function () {

            $('.modal-title').text("Add Employee");
            $('#action_button').val('<?php echo e(trans('file.Add')); ?>');
            $('#action').val('<?php echo e(trans('file.Add')); ?>');
            $('#formModal').modal('show');
        });

        $('#sample_form').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo e(route('employees.store')); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    var html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#sample_form')[0].reset();
                        $('select').selectpicker('refresh');
                        $('.date').datepicker('update');
                        $('#employee-table').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        });


        let employee_delete_id;

        $(document).on('click', '.delete', function () {
            employee_delete_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('<?php echo e(__('DELETE Record')); ?>');
            $('#ok_button').text('<?php echo e(trans('file.OK')); ?>');

        });


        $(document).on('click', '#bulk_delete', function () {

            var id = [];
            let table = $('#employee-table').DataTable();
            id = table.rows({selected: true}).ids().toArray();
            if (id.length > 0) {
                if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Employee')])); ?>')) {
                    $.ajax({
                        url: '<?php echo e(route('mass_delete_employees')); ?>',
                        method: 'POST',
                        data: {
                            employeeIdArray: id
                        },
                        success: function (data) {
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                            }
                            if (data.error) {
                                html = '<div class="alert alert-danger">' + data.error + '</div>';
                            }
                            table.ajax.reload();
                            table.rows('.selected').deselect();
                            $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);

                        }

                    });
                }
            } else {
                alert('<?php echo e(__('Please select atleast one checkbox')); ?>');
            }
        });


        $('#close').click(function () {
            $('#sample_form')[0].reset();
            $('select').selectpicker('refresh');
            $('.date').datepicker('update');
            $('#employee-table').DataTable().ajax.reload();
        });

        $('#ok_button').click(function () {
            let target = "<?php echo e(route('employees.index')); ?>/" + employee_delete_id + '/delete';
            $.ajax({
                url: target,
                beforeSend: function () {
                    $('#ok_button').text('<?php echo e(trans('file.Deleting...')); ?>');
                },
                success: function (data) {
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    setTimeout(function () {
                        $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        $('#confirmModal').modal('hide');
                        $('#employee-table').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });




        $('#confirm_pass').on('input', function () {

            if ($('input[name="password"]').val() != $('input[name="password_confirmation"]').val())
                $("#divCheckPasswordMatch").html('<?php echo e(__('Password does not match! please type again')); ?>');
            else
                $("#divCheckPasswordMatch").html('<?php echo e(__('Password matches!')); ?>');

        });


        $('.dynamic').change(function () {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let dependent = $(this).data('dependent');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "<?php echo e(route('dynamic_department')); ?>",
                    method: "POST",
                    data: {value: value, _token: _token, dependent: dependent},
                    success: function (result) {

                        $('select').selectpicker("destroy");
                        $('#department_id').html(result);
                        $('select').selectpicker();

                    }
                });
            }
        });

        $('.dynamic').change(function () {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let dependent = $(this).data('shift_name');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "<?php echo e(route('dynamic_office_shifts')); ?>",
                    method: "POST",
                    data: {value: value, _token: _token, dependent: dependent},
                    success: function (result) {
                        $('select').selectpicker("destroy");
                        $('#office_shift_id').html(result);
                        $('select').selectpicker();
                    }
                });
            }
        });

        $('.designation').change(function () {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let designation_name = $(this).data('designation_name');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "<?php echo e(route('dynamic_designation_department')); ?>",
                    method: "POST",
                    data: {value: value, _token: _token, designation_name: designation_name},
                    success: function (result) {
                        $('select').selectpicker("destroy");
                        $('#designation_id').html(result);
                        $('select').selectpicker();

                    }
                });
            }
        });


    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lion-Coders\PeoplePro-Related\10.01.2020-with Progress\peoplepro\resources\views/employee/index.blade.php ENDPATH**/ ?>