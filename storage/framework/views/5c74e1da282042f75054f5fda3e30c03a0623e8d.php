<?php $__env->startSection('content'); ?>


<section>

        <div class="container-fluid"><span id="general_result"></span></div>

        <div class="container-fluid mb-3">
            
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> <?php echo e(__('Add New')); ?></button>

            
            
                
        </div>



        <div class="table-responsive">
            <table id="employee-table" class="table ">
                <thead>
                <tr>
                    
                    <th>SL</th>
                    <th><?php echo e(trans('file.Company')); ?></th>
                    <th><?php echo e(trans('file.Employee')); ?></th>
                    <th><?php echo e(trans('file.Department')); ?></th>
                    <th><?php echo e(trans('file.Designation')); ?></th>
                    <th><?php echo e(__('Appraisal Date')); ?></th>
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
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(__('Add Company')); ?></h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="submit_form" class="form-horizontal">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Company</b></label>
                                    <select name="company_id" id="company_id" class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="begins"
                                            data-first_name="first_name" data-last_name="last_name"
                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>...'>
                                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo e(__('Employee')); ?></label>
                                    
                                    <select name="employee_id" id="employee_id" class=" form-control">
                                            <option value="">-- Select --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Customer Experience</b></label>
                                    <select name="customer_experience" id="customer_experience" class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="begins"
                                            data-first_name="first_name" data-last_name="last_name"
                                            title='<?php echo e(__('--Select Experinece--')); ?>'>
                                        <option value="None">None</option>
                                        <option value="Begginer">Begginer</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                        <option value="Expert/Leader">Expert/Leader</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Marketing</b></label>
                                    <select name="marketing" id="marketing" class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="begins"
                                            data-first_name="first_name" data-last_name="last_name"
                                            title='<?php echo e(__('--Select Marketing--')); ?>'>
                                        <option value="None">None</option>
                                        <option value="Begginer">Begginer</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                        <option value="Expert/Leader">Expert/Leader</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Administration</b></label>
                                    <select name="administration" id="administration" class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="begins"
                                            data-first_name="first_name" data-last_name="last_name"
                                            title='<?php echo e(__('--Select Administration--')); ?>'>
                                        <option value="None">None</option>
                                        <option value="Begginer">Begginer</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                        <option value="Expert/Leader">Expert/Leader</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Professionalism</b></label>
                                    <select name="professionalism" id="professionalism" class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="begins"
                                            data-first_name="first_name" data-last_name="last_name"
                                            title='<?php echo e(__('--Select Professionalism--')); ?>'>
                                        <option value="None">None</option>
                                        <option value="Begginer">Begginer</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                        <option value="Expert/Leader">Expert/Leader</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Integrity</b></label>
                                    <select name="integrity" id="integrity" class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="begins"
                                            data-first_name="first_name" data-last_name="last_name"
                                            title='<?php echo e(__('--Select Integrity--')); ?>'>
                                        <option value="None">None</option>
                                        <option value="Begginer">Begginer</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                        <option value="Expert/Leader">Expert/Leader</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Attendance</b></label>
                                    <select name="attendance" id="attendance" class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="begins"
                                            data-first_name="first_name" data-last_name="last_name"
                                            title='<?php echo e(__('--Select Attendance--')); ?>'>
                                        <option value="None">None</option>
                                        <option value="Begginer">Begginer</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                        <option value="Expert/Leader">Expert/Leader</option>
                                    </select>
                                </div>
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="action"/>
                                    <input type="hidden" name="hidden_id" id="hidden_id"/>
                                    <input type="submit" name="action_button" id="submit" class="btn btn-warning" value=<?php echo e(trans('file.Add')); ?> />
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
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center"><?php echo e(__('Are you sure you want to remove this data?')); ?></h4>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="ok_button" id="ok_button" class="btn btn-danger"><?php echo e(trans('file.OK')); ?>'
                    </button>
                    <button type="button" class="close btn-default"
                            data-dismiss="modal"><?php echo e(trans('file.Cancel')); ?></button>
                </div>
            </div>
        </div>
    </div> 


    <script type="text/javascript">
        (function($) {  


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#employee-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "<?php echo e(route('employee-appraisal.index')); ?>",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'company', name: 'company'},
                    {data: 'employee', name: 'employee'},
                    {data: 'department', name: 'department'},
                    {data: 'designation', name: 'designation'},
                    {data: 'date', name: 'date'},
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: true, 
                        searchable: true
                    },
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
                    ]
            });



            // "use strict";
            // $(document).ready(function () {

            //     $('#employee-table').DataTable({
            //         initComplete: function () {
            //             this.api().columns([2, 4]).every(function () {
            //                 var column = this;
            //                 var select = $('<select><option value=""></option></select>')
            //                     .appendTo($(column.footer()).empty())
            //                     .on('change', function () {
            //                         var val = $.fn.dataTable.util.escapeRegex(
            //                             $(this).val()
            //                         );

            //                         column
            //                             .search(val ? '^' + val + '$' : '', true, false)
            //                             .draw();
            //                     });

            //                 column.data().unique().sort().each(function (d, j) {
            //                     select.append('<option value="' + d + '">' + d + '</option>');
            //                     $('select').selectpicker('refresh');
            //                 });
            //             });
            //         },
            //         responsive: true,
            //         fixedHeader: {
            //             header: true,
            //             footer: true
            //         },
            //         serverSide: true,
            //         ajax: {
            //             url: "<?php echo e(route('employee-appraisal.index')); ?>",
            //         },
            //         createdRow: function (row, data, dataIndex) {
            //             $(row).find('td:eq(0) .dt-checkboxes').attr('data-id', data.id);
            //         },
            //         columns: [

            //             // {
            //             //     data: null,
            //             //     orderable: false,
            //             //     searchable: false
            //             // },
            //             {
            //                 data: 'company',
            //                 name: 'company',

            //             },
            //             {
            //                 data: 'employee',
            //                 name: 'employee'
            //             },
            //             {
            //                 data: 'department',
            //                 name: 'department'
            //             },
            //             {
            //                 data: 'designation',
            //                 name: 'designation'
            //             },
            //             {
            //                 data: 'date',
            //                 name: 'date'
            //             },
            //             {
            //                 data: 'action',
            //                 name: 'action',
            //                 orderable: false
            //             }
            //         ],


            //         "order": [],
            //         'language': {
            //             'lengthMenu': '_MENU_ <?php echo e(__("records per page")); ?>',
            //             "info": '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
            //             "search": '<?php echo e(trans("file.Search")); ?>',
            //             'paginate': {
            //                 'previous': '<?php echo e(trans("file.Previous")); ?>',
            //                 'next': '<?php echo e(trans("file.Next")); ?>'
            //             }
            //         },
            //         'columnDefs': [
            //             {
            //                 "orderable": false,
            //                 'targets': [0, 9]
            //             },
            //             // {
            //             //     'render': function (data, type, row, meta) {
            //             //         if (type === 'display') {
            //             //             data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
            //             //         }

            //             //         return data;
            //             //     },
            //             //     'checkboxes': {
            //             //         'selectRow': true,
            //             //         'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
            //             //     },
            //             //     'targets': [0]
            //             // }
            //         ],


            //         'select': {style: 'multi', selector: 'td:first-child'},
            //         'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
            //         dom: '<"row"lfB>rtip',
            //         buttons: [
            //             {
            //                 extend: 'pdf',
            //                 text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
            //                 exportOptions: {
            //                     columns: ':visible:Not(.not-exported)',
            //                     rows: ':visible'
            //                 },
            //             },
            //             {
            //                 extend: 'csv',
            //                 text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
            //                 exportOptions: {
            //                     columns: ':visible:Not(.not-exported)',
            //                     rows: ':visible'
            //                 },
            //             },
            //             {
            //                 extend: 'print',
            //                 text: '<i title="print" class="fa fa-print"></i>',
            //                 exportOptions: {
            //                     columns: ':visible:Not(.not-exported)',
            //                     rows: ':visible'
            //                 },
            //             },
            //             {
            //                 extend: 'colvis',
            //                 text: '<i title="column visibility" class="fa fa-eye"></i>',
            //                 columns: ':gt(0)'
            //             },
            //         ],
            //     });

            // });


            $('#create_record').click(function () {
                $('.modal-title').text('<?php echo e(__('Add Department')); ?>');
                $('#action_button').val('<?php echo e(trans("file.Add")); ?>');
                $('#action').val('<?php echo e(trans("file.Add")); ?>');
                $('#formModal').modal('show');
            });

             //after selecting Company then Employee will be loaded
            $('#company_id').change(function() 
            {
                var company_id = $(this).val();
                if (company_id) 
                {

                    $.get("<?php echo e(route('employee-appraisal.getEmployee')); ?>",{company_id:company_id}, function (data) 
                    {
                        console.log(data);
                        $('#employee_id').empty().html(data); //
                    });
                }
                // else{
                //     $('#company_id').empty().html('<option>--Select --</option>');
                // }
            })

            $("#submit").on("click",function(e){
                e.preventDefault();
                $.ajax({
                        url: "<?php echo e(route('employee-appraisal.store')); ?>",
                        type: "POST",
                        data: $('#submit_form').serialize(),
                        success: function (data) {
                            console.log(data);
                            $('#submit_form').trigger("reset");
                            $('#formModal').modal('hide');
                            // $('#submit_form').trigger("reset"); //For will be empty after save data
                            // $('#response').fadeIn();
                            // $('#response').removeClass('error-msg').addClass('success-msg').html(data);
                            // setTimeout(function() {
                            //     $('#response').fadeOut("slow");
                            // }, 4000); //after 4 sesonds, message will be gone.
                        }
                    })
            });

            //Delete
            // $(document).on('click', '.delete', function () {
            //     // delete_id = $(this).attr('id');
            //     $('#confirmModal').modal('show');
            //     // $('.modal-title').text('<?php echo e(__('DELETE Record')); ?>');
            //     // $('#ok_button').text('<?php echo e(trans('file.OK')); ?>');
            // });

            //---------- Delete Data ----------
            $(document).on("click",".delete",function(e){

                $('#confirmModal').modal('show');
                var userId = $(this).data("id");
                var element = this;

                // console.log(userId);
                $("#ok_button").on("click",function(e){

                    $.ajax({
                        url: "<?php echo e(route('employee-appraisal.delete')); ?>",
                        type: "GET",
                        data: {id:userId},
                        success: function(data){
                            console.log(data);
                            $('#confirmModal').modal('hide');
                            // alert("Are you sure to delete ?");
                            // $(element).closest("tr").fadeOut(); //for animated
                            
                        }
                    });

                });

            });

        })(jQuery); 
    </script>


    <script>
    //     $(function () {

    //     //     $.ajaxSetup({
    //     //         headers: {
    //     //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     //         }
    //     //     });

    //     //     var table = $('#employee-table').DataTable({
    //     //         processing: true,
    //     //         serverSide: true,
    //     //         ajax: "<?php echo e(route('employee-appraisal.index')); ?>",
    //     //         columns: [
    //     //             {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    //     //             {data: 'company', name: 'company'},
    //     //             {data: 'employee', name: 'employee'},
    //     //             {data: 'department', name: 'department'},
    //     //             {data: 'designation', name: 'designation'},
    //     //             {data: 'customer_experience', name: 'customer_experience'},
    //     //             {data: 'marketing', name: 'marketing'},
    //     //             {data: 'action', name: 'action', orderable: false, searchable: false},
    //     //         ]
    //     //     });

    //     // });
    // </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lion_Coders\New Task\peoplepro\resources\views/appraisal/index.blade.php ENDPATH**/ ?>