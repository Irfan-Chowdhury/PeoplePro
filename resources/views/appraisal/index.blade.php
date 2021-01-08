@extends('layout.main')
@section('content')


<section>

        <div class="container-fluid"><span id="general_result"></span></div>

        <div class="container-fluid mb-3">
            
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> {{__('Add New')}}</button>
            
                {{-- <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> {{__('Bulk delete')}}</button> --}}

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button>

        </div>

        {{-- ------------------- Testing ----------- --}}

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                ...
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            </div>
        </div>

        {{-- ------------------- Testing ----------- --}}


        



        <div class="table-responsive">
            <table id="employee-table" class="table ">
                <thead>
                <tr>
                    {{-- <th class="not-exported"></th> --}}
                    <th>SL</th>
                    <th>{{trans('file.Company')}}</th>
                    <th>{{trans('file.Employee')}}</th>
                    <th>{{trans('file.Department')}}</th>
                    <th>{{trans('file.Designation')}}</th>
                    <th>{{__('Appraisal Date')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>


            </table>
        </div>

    </section>



    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Add New')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="submit_form" class="form-horizontal">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Company</b></label>
                                    <select name="company_id" id="company_id" class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="begins"
                                            data-first_name="first_name" data-last_name="last_name"
                                            title='{{__('Selecting',['key'=>trans('file.Company')])}}...'>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->company_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('Employee')}}</label>
                                    {{-- <select name="employee_id" id="employee_id" class=" form-control"
                                            data-live-search="true" data-live-search-style="begins"
                                            title='{{__('Select Employee')}}...'>
                                    </select> --}}
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
                                            title='{{__('--Select Experinece--')}}'>
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
                                            title='{{__('--Select Marketing--')}}'>
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
                                            title='{{__('--Select Administration--')}}'>
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
                                            title='{{__('--Select Professionalism--')}}'>
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
                                            title='{{__('--Select Integrity--')}}'>
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
                                            title='{{__('--Select Attendance--')}}'>
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
                                    <input type="submit" name="action_button" id="submit" class="btn btn-warning" value={{trans('file.Add')}} />
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


    {{-- Delete Confirm --}}
    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{trans('file.Confirmation')}}</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center">{{__('Are you sure you want to remove this data?')}}</h4>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="ok_button" id="ok_button" class="btn btn-danger">{{trans('file.OK')}}'
                    </button>
                    <button type="button" class="close btn-default"
                            data-dismiss="modal">{{trans('file.Cancel')}}</button>
                </div>
            </div>
        </div>
    </div> 


    {{-- Edit Modal --}}
    {{-- @include('appraisal.edit-form-modal') --}}

    <div id="EditformModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
    
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Edit Appraisal')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>
    
                <div class="modal-body" id="editModal">
                    <span id="form_result"></span>
                    
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
                ajax: "{{ route('employee-appraisal.index') }}",
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



            

            //----- Create --------
            $('#create_record').click(function () {
                $('.modal-title').text('{{__('Add Appraisal')}}');
                $('#action_button').val('{{trans("file.Add")}}');
                $('#action').val('{{trans("file.Add")}}');
                $('#formModal').modal('show');
            });

             //after selecting Company then Employee will be loaded
            $('#company_id').change(function() 
            {
                var company_id = $(this).val();
                if (company_id) 
                {

                    $.get("{{route('employee-appraisal.getEmployee')}}",{company_id:company_id}, function (data) 
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
                        url: "{{route('employee-appraisal.store')}}",
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
            //     // $('.modal-title').text('{{__('DELETE Record')}}');
            //     // $('#ok_button').text('{{trans('file.OK')}}');
            // });

            //---------- Delete Data ----------
            $(document).on("click",".delete",function(e){

                $('#confirmModal').modal('show');
                var userId = $(this).data("id");
                var element = this;

                // console.log(userId);
                $("#ok_button").on("click",function(e){

                    $.ajax({
                        url: "{{route('employee-appraisal.delete')}}",
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



            // ------ Edit -----
            $(document).on("click",".edit",function(e){

                $('#EditformModal').modal('show');
                var userId = $(this).data("id");
                var element = this;



                // console.log(userId);
                $("#ok_button").on("click",function(e){

                    $.ajax({
                        url: "{{route('employee-appraisal.delete')}}",
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
    //     //         ajax: "{{ route('employee-appraisal.index')}}",
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
@endsection