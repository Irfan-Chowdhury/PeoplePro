@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    
    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">Goal Tracking</h4><br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>{{__(' Add New Goal')}}</button>
        <button type="button" class="btn btn-danger"><i class="fa fa-minus-circle"></i>{{__(' Bulk Delete')}}</button>
    </div>

    @include('performance.goal-tracking.create-modal')
    @include('performance.goal-tracking.edit-modal')
    @include('performance.goal-tracking.delete-modal')

    <div class="table-responsive">
        <table id="employee-table" class="table">
            <thead>
                <tr>
                    {{-- <th class="not-exported"></th> --}}
                    <th><input type="checkbox"></th>
                    <th>SL</th>
                    <th>Goal Type</th>
                    <th>Company</th>
                    <th>Target Achievement</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Progress</th>
                    {{-- <th class="not-exported">{{trans('file.action')}}</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>1</td>
                    <td>XYZ</td>
                    <td>HARSALE</td>
                    <td>Success</td>
                    <td>Jan-06-2021</td>
                    <td>Jan-07-2021</td>
                    <td>Completed 80%</td>
                    <td>
                        {{-- <button class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View Details"><i class="dripicons-preview"></i></button> --}}
                        <button class="edit btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" data-placement="top" title="Edit"><i class="dripicons-pencil"></i></button>
                        <button class="edit btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-placement="top" title="Delete"><i class="dripicons-trash"></i></button>
                    </td>
                </tr>
            </tbody>


        </table>
    </div>
    



</section>

@endsection