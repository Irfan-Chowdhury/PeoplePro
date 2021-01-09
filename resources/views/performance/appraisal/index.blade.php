@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    
    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">Performance Appraisal</h4>
            <div id="success_alert" role="alert"></div>
        <br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModalForm"><i class="fa fa-plus"></i>{{__(' Add New')}}</button>
        {{-- <button type="button" class="btn btn-danger"><i class="fa fa-minus-circle"></i>{{__(' Bulk Delete')}}</button> --}}
    </div>

    <div class="table-responsive">
        <table id="appraisalTable" class="table">
            <thead>
                <tr>
                    {{-- <th class="not-exported"></th> --}}
                    {{-- <th><input type="checkbox"></th> --}}
                    <th>SL</th>
                    <th>{{trans('file.Company')}}</th>
                    <th>{{trans('file.Employee')}}</th>
                    <th>{{trans('file.Department')}}</th>
                    <th>{{trans('file.Designation')}}</th>
                    <th>Appraisal Date</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
        </table>
    </div>
</section>


@include('performance.appraisal.create-modal')
@include('performance.appraisal.edit-modal')
@include('performance.indicator.delete-modal')

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
            ajax: "{{ route('performance.appraisal.index') }}",
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

    // });

        //after selecting Company then Employee will be loaded
        $('#companyId').change(function(){
            var companyId = $(this).val();
            console.log(companyId);

            if (companyId){
                $.get("{{route('performance.appraisal.get-employee')}}",{company_id:companyId}, function (data){
                    console.log(data);
                    $('#employeeId').empty().html(data); 
                });
            }else{
                $('#employeeId').empty().html('<option>--Select --</option>');
            }
        });


        //----------Insert Data----------------------
        $("#save-button").on("click",function(e){
            e.preventDefault();
            
            $.ajax({
                url: "{{route('performance.appraisal.store')}}",
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
                        $("#alertMessage").removeClass('bg-danger text-center text-light p-1');
                    }
                }
            });
        });


        //---------- Edit Data ----------
        $(document).on("click",".edit",function(e){
            e.preventDefault();
            $('#EditformModal').modal('show');
            var appraisalId = $(this).data("id");
            var element = this;
            console.log(appraisalId)

            $.ajax({
                url: "{{route('performance.appraisal.edit')}}",
                type: "GET",
                data: {appraisal_id:appraisalId},
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
                url: "{{route('performance.appraisal.update')}}",
                type: "POST",
                data: $('#updatetForm').serialize(),
                success: function(data){
                    console.log(data);
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
        var appraisalIdDelete = $(this).data("id");
        var element = this;
        // console.log(goalTypeIdDelete);

        $("#deleteSubmit").on("click",function(e){
            $.ajax({
                url: "{{route('performance.appraisal.delete')}}",
                type: "GET",
                data: {appraisal_id:appraisalIdDelete},
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