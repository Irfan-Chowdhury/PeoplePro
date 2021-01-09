<?php $__env->startSection('content'); ?>

<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    
    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">Performance Appraisal</h4>
            <div id="success_alert" role="alert"></div>
        <br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModalForm"><i class="fa fa-plus"></i><?php echo e(__(' Add New')); ?></button>
        
    </div>

    <div class="table-responsive">
        <table id="appraisalTable" class="table">
            <thead>
                <tr>
                    
                    
                    <th>SL</th>
                    <th><?php echo e(trans('file.Company')); ?></th>
                    <th><?php echo e(trans('file.Employee')); ?></th>
                    <th><?php echo e(trans('file.Department')); ?></th>
                    <th><?php echo e(trans('file.Designation')); ?></th>
                    <th>Appraisal Date</th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
        </table>
    </div>
</section>


<?php echo $__env->make('performance.appraisal.create-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<script type="text/javascript">
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#appraisalTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('performance.appraisal.index')); ?>",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'company_name', name: 'company_name'},
                {data: 'employee_name', name: 'employee_name'},
                {data: 'department_name', name: 'department_name'},
                {data: 'designation_name', name: 'designation_name'},
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

        });

        //after selecting Company then Employee will be loaded
        $('#companyId').change(function(){

            var companyId = $(this).val();
            console.log(companyId);

            if (companyId) 
            {
                $.get("<?php echo e(route('performance.appraisal.get-employee')); ?>",{company_id:companyId}, function (data) 
                {
                    console.log(data);
                    $('#employeeId').empty().html(data); 
                });
            }else{
                $('#employeeId').empty().html('<option>--Select --</option>');
            }
        })


        //----------Insert Data----------------------
        $("#save-button").on("click",function(e){
            e.preventDefault();
            var companyId = $("#companyId").val();
            
            $.ajax({
                url: "<?php echo e(route('performance.appraisal.store')); ?>",
                type: "POST",
                data: $('#submitForm').serialize(),
                success: function(data){
                    console.log(data);
                    // if (data.errors) {
                    //     $("#alertMessage").html(data.errors) //Check in create modal
                    // }
                    if(data.success){
                        table.draw();
                        $('#submitForm').trigger("reset");
                        $("#createModalForm").modal('hide');
                        $('#success_alert').fadeIn("slow"); //Check in top in this blade
                        $('#success_alert').addClass('alert alert-success').html(data.success);
                        setTimeout(function() {
                            $('#success_alert').fadeOut("slow");
                        }, 3000);
                    }
                }
            });
        });





</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lion-Coders\PeoplePro-Related\08.01.2020\peoplepro\resources\views/performance/appraisal/index.blade.php ENDPATH**/ ?>