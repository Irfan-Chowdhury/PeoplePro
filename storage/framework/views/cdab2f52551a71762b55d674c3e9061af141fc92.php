<?php $__env->startSection('content'); ?>

<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    
    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">Performance Indicator</h4>
        <div id="success_alert" role="alert"></div>
        <br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModalForm"><i class="fa fa-plus"></i><?php echo e(__(' Add New Indicator')); ?></button>
        
    </div>

    <div class="table-responsive">
        <table id="indicatorTable" class="table">
            <thead>
                <tr>
                    
                    
                    <th>SL</th>
                    <th><?php echo e(trans('file.Designation')); ?></th>
                    <th><?php echo e(trans('file.Company')); ?></th>
                    <th><?php echo e(trans('file.Department')); ?></th>
                    <th>Added By</th>
                    <th>Created_At</th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
        </table>
    </div>
</section>

<?php echo $__env->make('performance.indicator.create-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('performance.indicator.edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('performance.indicator.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<script type="text/javascript">
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var table = $('#indicatorTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('performance.indicator.index')); ?>",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'designation_name', name: 'designation_name'},
                {data: 'company_name',     name: 'company_name'},
                {data: 'department_name',  name: 'department_name'},
                {data: 'added_by',    name: 'added_by'},
                {data: 'created_at',  name: 'created_at'},
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


        //after selecting Company then Designation will be loaded
        $('#companyId').change(function() {
            var companyId = $(this).val();
            if (companyId){
                $.get("<?php echo e(route('performance.indicator.get-designation-by-company')); ?>",{company_id:companyId}, function (data) {
                    // console.log(data);
                    $('#designationId').empty().html(data); //
                });
            }else{
                $('#designationId').empty().html('<option>--Select --</option>');
            }
        });

        //----------Insert Data----------------------
        $("#save-button").on("click",function(e){
            e.preventDefault();
            var companyId = $("#companyId").val();
            
            $.ajax({
                url: "<?php echo e(route('performance.indicator.store')); ?>",
                type: "POST",
                data: $('#submitForm').serialize(),
                success: function(data){
                    console.log(data);
                    if (data.errors) {
                        $("#alertMessage").addClass('bg-danger text-center text-light p-1').html(data.errors) //Check in create modal
                    }
                    else if(data.success){
                        table.draw();
                        $('#submitForm').trigger("reset");
                        $("#createModalForm").modal('hide');
                        $('#success_alert').fadeIn("slow"); //Check in top in this blade
                        $('#success_alert').addClass('alert alert-success').html(data.success);
                        setTimeout(function() {
                            $('#success_alert').fadeOut("slow");
                        }, 3000);
                        ("#alertMessage").removeClass('bg-danger text-center text-light p-1');
                    }
                }
            });
        });


        //---------- Edit Data ----------
        $(document).on("click",".edit",function(e){
            e.preventDefault();
            $('#EditformModal').modal('show');
            var indicatorId = $(this).data("id");
            var element = this;
            console.log(indicatorId)

            $.ajax({
                url: "<?php echo e(route('performance.indicator.edit')); ?>",
                type: "GET",
                data: {indicator_id:indicatorId},
                success: function(data){
                    console.log(data)
                    $('#edit-body').html(data);                   
                }
            });
        });

        // ---------- Update by Id----------
        $("#update-button").on("click",function(e){
            e.preventDefault();

            $.ajax({
                url: "<?php echo e(route('performance.indicator.update')); ?>",
                type: "POST",
                data: $('#updatetForm').serialize(),
                success: function(data){
                    console.log(data);
                    
                    // if (data.errors) {
                    //     $(".goal_type_edit").addClass('is-invalid');
                    //     $("#error_edit_message").html(data.errors) //Check in edit modal
                    // }
                    if(data.success)
                    {
                        table.draw();
                        $('#updatetForm').trigger("reset");
                        $("#EditformModal").modal('hide');
                        $('#success_alert').fadeIn("slow"); //Check in top in this blade
                        $('#success_alert').addClass('alert alert-success').html(data.success);
                        setTimeout(function() {
                            $('#success_alert').fadeOut("slow");
                        }, 3000);
                    } 
                }
            });
        });

        //---------- Delete Data ----------
        $(document).on("click",".delete",function(e){

            $('#confirmDeleteModal').modal('show');
            var indicatorIdDelete = $(this).data("id");
            var element = this;
            // console.log(goalTypeIdDelete);

            $("#deleteSubmit").on("click",function(e){
                $.ajax({
                    url: "<?php echo e(route('performance.indicator.delete')); ?>",
                    type: "GET",
                    data: {indicator_id:indicatorIdDelete},
                    success: function(data){
                        console.log(data);
                        if(data.success)
                        {
                            table.draw();
                            $("#confirmDeleteModal").modal('hide');
                            $('#success_alert').fadeIn("slow"); //Check in top in this blade
                            $('#success_alert').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#success_alert').fadeOut("slow");
                            }, 3000);
                        }                        
                    }
                });

            });

        });

        

    });
</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lion_Coders\09.01.2020\peoplepro\resources\views/performance/indicator/index.blade.php ENDPATH**/ ?>