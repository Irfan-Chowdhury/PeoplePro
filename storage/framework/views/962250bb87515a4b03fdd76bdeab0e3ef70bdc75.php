<?php $__env->startSection('content'); ?>

<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    
    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">Goal Tracking</h4>
        <div id="success_alert" role="alert"></div>
        <br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModalForm"><i class="fa fa-plus"></i><?php echo e(__(' Add New Goal')); ?></button>
        
    </div>

    <div class="table-responsive">
        <table id="goalTrackingTable" class="table">
            <thead>
                <tr>
                    
                    
                    <th>SL</th>
                    <th>Goal Type</th>
                    <th>Company</th>
                    <th>Target Achievement</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Progress</th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                    
                </tr>
            </thead>
        </table>
    </div>
    
</section>


<?php echo $__env->make('performance.goal-tracking.create-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('performance.goal-tracking.edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('performance.goal-tracking.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#goalTrackingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('performance.goal-tracking.index')); ?>",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'goal_type', name: 'goal_type'},
                {data: 'company_name', name: 'company_name'},
                {data: 'target_achievement', name: 'target_achievement'},
                {data: 'start_date', name: 'start_date'},
                {data: 'end_date', name: 'end_date'},
                {data: 'progress', name: 'progress'},
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

        //----------Insert Data----------------------
        $("#save-button").on("click",function(e){
            e.preventDefault();
            
            $.ajax({
                url: "<?php echo e(route('performance.goal-tracking.store')); ?>",
                type: "POST",
                data: $('#submitForm').serialize(),
                success: function(data){
                    console.log(data);
                    if (data.errors) {
                        $("#alertMessageBox").addClass('bg-danger text-center p-1') //Check in create modal
                        $("#alertMessage").html(data.errors) //Check in create modal
                    }
                    else if(data.success){
                        console.log(data.success);

                        table.draw();
                        $('#submitForm').trigger("reset");
                        $("#createModalForm").modal('hide');
                        $('#success_alert').fadeIn("slow"); //Check in top in this blade
                        $('#success_alert').addClass('alert alert-success').html(data.success);
                        setTimeout(function() {
                            $('#success_alert').fadeOut("slow");
                        }, 3000);
                        $("#alertMessage").removeClass('bg-danger text-center text-light p-1');
                    }
                }
            });
        });

        //---------- Edit Data ----------
        $(document).on("click",".edit",function(e){
            e.preventDefault();
            $('#EditformModal').modal('show');
            var goalTrackingId = $(this).data("id");
            var element = this;
            console.log(goalTrackingId)

            $.ajax({
                url: "<?php echo e(route('performance.goal-tracking.edit')); ?>",
                type: "GET",
                data: {goal_tracking_id:goalTrackingId},
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
                url: "<?php echo e(route('performance.goal-tracking.update')); ?>",
                type: "POST",
                data: $('#updatetEditForm').serialize(),
                success: function(data){
                    console.log(data);
                    if(data.success)
                    {
                        table.draw();
                        $('#updatetEditForm').trigger("reset");
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
            var goalTrackingIdDelete = $(this).data("id");
            var element = this;
            // console.log(goalTypeIdDelete);

            $("#deleteSubmit").on("click",function(e){
                $.ajax({
                    url: "<?php echo e(route('performance.goal-tracking.delete')); ?>",
                    type: "GET",
                    data: {goal_tracking_id:goalTrackingIdDelete},
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
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lion-Coders\PeoplePro-Related\10.01.2020\peoplepro\resources\views/performance/goal-tracking/index.blade.php ENDPATH**/ ?>