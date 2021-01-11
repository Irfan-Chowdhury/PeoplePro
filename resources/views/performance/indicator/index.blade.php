@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    
    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">Performance Indicator</h4>
        <div id="success_alert" role="alert"></div>
        <br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModalForm"><i class="fa fa-plus"></i>{{__(' Add New Indicator')}}</button>
        {{-- <button type="button" class="btn btn-danger"><i class="fa fa-minus-circle"></i>{{__(' Bulk Delete')}}</button> --}}
    </div>

    <div class="table-responsive">
        <table id="indicatorTable" class="table">
            <thead>
                <tr>
                    {{-- <th class="not-exported"></th> --}}
                    {{-- <th><input type="checkbox"></th> --}}
                    <th>SL</th>
                    <th>{{trans('file.Designation')}}</th>
                    <th>{{trans('file.Company')}}</th>
                    <th>{{trans('file.Department')}}</th>
                    <th>Added By</th>
                    <th>Created_At</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
        </table>
    </div>
</section>

@include('performance.indicator.create-modal')
@include('performance.indicator.edit-modal')
@include('performance.indicator.delete-modal')


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
            ajax: "{{ route('performance.indicator.index') }}",
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


        //after selecting Company then Designation will be loaded
        $('#companyId').change(function() {
            var companyId = $(this).val();
            if (companyId){
                $.get("{{route('performance.indicator.get-designation-by-company')}}",{company_id:companyId}, function (data) {
                    // $('#designationId').empty().html(data); 
                    
                    let all_designations = '';
                    $.each(data.designations, function (index, value) {
                        all_designations += '<option value=' + value['id'] + '>' + value['designation_name'] + '</option>';
                    });
                    $('#designationId').selectpicker('refresh');
                    $('#designationId').empty().append(all_designations);
                    $('#designationId').selectpicker('refresh');
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
                url: "{{route('performance.indicator.store')}}",
                type: "POST",
                data: $('#submitForm').serialize(),
                success: function(data){
                    console.log(data);
                    if (data.errors) {
                        $("#alertMessage").addClass('bg-danger text-center text-light p-1').html(data.errors) //Check in create modal
                    }
                    else if(data.success){
                        table.draw();
                        $('#submitForm')[0].reset();
                        $('select').selectpicker('refresh');
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
            var indicatorId = $(this).data("id");
            var element = this;

            $.ajax({
                url: "{{route('performance.indicator.edit')}}",
                type: "GET",
                data: {id:indicatorId},
                success: function(data){
                    console.log(data)
                    $('#indicatorHiddenIdEdit').val(data.indicator.id);
                    $('#companyIdEdit').selectpicker('val', data.indicator.company_id);
                    
                    let all_designations = '';
                    $.each(data.designations, function (index, value) {
                        all_designations += '<option value=' + value['id'] + '>' + value['designation_name'] + '</option>';
                    });
                    $('#designationIdEdit').empty().append(all_designations);
                    $('#designationIdEdit').selectpicker('refresh');
                    $('#designationIdEdit').selectpicker('val', data.indicator.designation_id);
                    $('#designationIdEdit').selectpicker('refresh');


                    $('#customerExperienceEdit').selectpicker('val', data.indicator.customer_experience);
                    $('#marketingEdit').selectpicker('val', data.indicator.marketing);
                    $('#administratorEdit').selectpicker('val', data.indicator.administrator);
                    $('#professionalismEdit').selectpicker('val', data.indicator.professionalism);
                    $('#integrityEdit').selectpicker('val', data.indicator.integrity);
                    $('#attendanceEdit').selectpicker('val', data.indicator.attendance);
                    $('#EditformModal').modal('show');
                }
            });
        });


        // ---------- Update by Id----------
        $("#update-button").on("click",function(e){
            e.preventDefault();

            $.ajax({
                url: "{{route('performance.indicator.update')}}",
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
                    url: "{{route('performance.indicator.delete')}}",
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


        $('.dynamic').change(function () {
                if ($(this).val() !== '') {
                    let value = $(this).val();
                    let dependent = $(this).data('dependent');
                    let _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('performance.indicator.dynamic_designation') }}",
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

        

    });
</script>



@endsection