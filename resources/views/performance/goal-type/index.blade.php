@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    
    <div class="container-fluid mb-3">

        <h4 class="font-weight-bold mt-3">Goal Type</h4>
        <div id="success_alert" role="alert">

        </div>
        <br>
        
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>{{__(' Add New Type')}}</button>
        <button type="button" class="btn btn-danger"><i class="fa fa-minus-circle"></i>{{__(' Bulk Delete')}}</button>

    </div>

    <div class="container">
        <div class="table-responsive">
            <table id="goalTypeTable" class="table">
                <thead>
                    <tr>
                        {{-- <th class="not-exported"></th> --}}
                        {{-- <th><input type="checkbox"></th> --}}
                        <th>SL</th>
                        <th>Type</th>
                        <th class="not-exported">{{trans('file.action')}}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>

@include('performance.goal-type.create-modal')
@include('performance.goal-type.edit-modal')
@include('performance.goal-type.delete-confirm-modal')



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
            ajax: "{{ route('performance.goal-type.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'goal_type', name: 'goal_type'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ],
            "order": [],
                'language': {
                    'lengthMenu': '_MENU_ {{__("records per page")}}',
                    "info": '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
                    "search": '{{trans("file.Search")}}',
                    'paginate': {
                        'previous': '{{trans("file.Previous")}}',
                        'next': '{{trans("file.Next")}}'
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
                url: "{{route('performance.goal-type.store')}}",
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
            $('#EditformModal').modal('show');
            var goalTypeId = $(this).data("id");
            var element = this;
            console.log(goalTypeId)

            $.ajax({
                url: "{{route('performance.goal-type.edit')}}",
                type: "GET",
                data: {goal_type_id:goalTypeId},
                success: function(data){
                    // console.log(data);
                    $('#edit-body').html(data);                    
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
                url: "{{route('performance.goal-type.update')}}",
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
                    url: "{{route('performance.goal-type.delete')}}",
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

        

    });
</script>

@endsection