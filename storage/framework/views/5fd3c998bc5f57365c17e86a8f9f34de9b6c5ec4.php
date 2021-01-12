<?php $__env->startSection('content'); ?>

<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    
    <div class="container-fluid mb-3">

        <h4 class="font-weight-bold mt-3">Goal Type</h4>
        <div id="success_alert" role="alert"></div>
        <br>
        
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i><?php echo e(__(' Add New Type')); ?></button>
        <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i class="fa fa-minus-circle"></i><?php echo e(__(' Bulk Delete')); ?></button>

    </div>

    <div class="container">
        <div class="table-responsive">
            <table id="goalTypeTable" class="table">
                <thead>
                    <tr>
                        
                        <th><input type="checkbox" name="checkedAll" id="checkedAll"/></th>
                        <th>SL</th>
                        <th>Type</th>
                        <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>

<?php echo $__env->make('performance.goal-type.create-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('performance.goal-type.edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('performance.goal-type.delete-confirm-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('performance.goal-type.delete-checkbox-confirm-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<script type="text/javascript">
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var table = $('#goalTypeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('performance.goal-type.index')); ?>",
            columns: [
                {data: 'checkbox', name: 'checkbox', orderable: true, searchable: true},
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'goal_type', name: 'goal_type'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ],

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
            var goalType = $("#goalType").val();
            
            $.ajax({
                url: "<?php echo e(route('performance.goal-type.store')); ?>",
                type: "POST",
                data: {goal_type:goalType},
                success: function(data){
                    // console.log(data);
                    if (data.errors) {
                        $("#goalType").addClass('is-invalid');
                        $("#message").html(data.errors) //Check in create modal
                    }
                    else if(data.success){
                        table.draw();
                        $('#submit_form').trigger("reset");
                        $("#createModal").modal('hide');
                        $('#success_alert').fadeIn("slow"); //Check in top in this blade
                        $('#success_alert').addClass('alert alert-success').html(data.success);
                        setTimeout(function() {
                            $('#success_alert').fadeOut("slow");
                        }, 3000);
                    }
                }
            });
        });


        //---------- Edit Data ----------
        $(document).on("click",".edit",function(e){
            var goalTypeId = $(this).data("id");
            var element = this;
            console.log(goalTypeId)

            $.ajax({
                url: "<?php echo e(route('performance.goal-type.edit')); ?>",
                type: "GET",
                data: {goal_type_id:goalTypeId},
                success: function(data){
                    // console.log(data);
                    $('#edit-body').html(data);      
                    $('#EditformModal').modal('show');              
                }
            });
        });

        //---------- Update by Id----------
        $("#update-button").on("click",function(e){
            e.preventDefault();
            var goalTypeId = $("#goalTypeId").val();
            var goalEditType   = $("#goalEditType").val();
            // console.log(goalTypeId);

            $.ajax({
                url: "<?php echo e(route('performance.goal-type.update')); ?>",
                type: "POST",
                data: {goal_type_id:goalTypeId, goal_type:goalEditType},
                success: function(data){
                    console.log(data);
                    
                    if (data.errors) {
                        $(".goal_type_edit").addClass('is-invalid');
                        $("#error_edit_message").html(data.errors) //Check in edit modal
                    }
                    else if(data.success)
                    {
                        table.draw();
                        $('#submitEditForm').trigger("reset");
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
            var goalTypeIdDelete = $(this).data("id");
            var element = this;
            // console.log(goalTypeIdDelete);

            $("#deleteSubmit").on("click",function(e){
                $.ajax({
                    url: "<?php echo e(route('performance.goal-type.delete')); ?>",
                    type: "GET",
                    data: {goal_type_id:goalTypeIdDelete},
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


        // $("#checkedAll").change(function() {
        //     if (this.checked) {
        //         $(".checkbox").each(function() {
        //             this.checked=true;
        //         });
        //     } else {
        //         $(".checkbox").each(function() {
        //             this.checked=false;
        //         });
        //     }
        // });


        // Multiple Data Delete using checkbox
        $("#bulk_delete").on("click",function(){
            var allCheckboxId = [];

            // Converted all checked checkbox's value into Array
            $(":checkbox:checked").each(function(key){
                allCheckboxId[key] =$(this).data("id");
            });
            console.log(allCheckboxId);

            if(allCheckboxId.length === 0){
                alert("Please Select at least one checkbox.");
            }
            else{
                $('#confirmDeleteCheckboxModal').modal('show');
                $("#deleteCheckboxSubmit").on("click",function(e){
                    $.ajax({
                        url : "<?php echo e(route('performance.goal-type.delete.checkbox')); ?>",
                        type : "GET",
                        data : {all_checkbox_id : allCheckboxId},
                        success : function(data){
                            console.log(data);
                            if(data.success)
                            {
                                table.draw();
                                $("#confirmDeleteCheckboxModal").modal('hide');
                                $('#success_alert').fadeIn("slow"); //Check in top in this blade
                                $('#success_alert').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#success_alert').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    });
                });
            }
        });
        

        

    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lion-Coders\PeoplePro-Related\10.01.2020-with Progress\peoplepro\resources\views/performance/goal-type/index.blade.php ENDPATH**/ ?>