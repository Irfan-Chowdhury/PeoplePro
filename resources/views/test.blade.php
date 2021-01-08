@extends('layout.main')
@section('content')



    <section>

        <div class="container-fluid"><span id="general_result"></span></div>




        <div class="table-responsive">
            <table id="employee-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Name')}}</th>
                    <th>{{trans('file.Company')}}</th>
                    <th>{{trans('file.Department')}}</th>
                    <th>{{trans('file.Designation')}}</th>
                    <th>{{trans('file.Phone')}}</th>
                    <th>{{trans('file.Email')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>

            </table>
        </div>
    </section>


@endsection