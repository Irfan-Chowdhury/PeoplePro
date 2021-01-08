@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid"><span id="general_result"></span></div>
    
    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">Performance Indicator</h4><br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>{{__(' Add New Indicator')}}</button>
        <button type="button" class="btn btn-danger"><i class="fa fa-minus-circle"></i>{{__(' Bulk Delete')}}</button>
    </div>

    @include('performance.indicator.create-modal')
    @include('performance.indicator.edit-modal')
    @include('performance.indicator.delete-modal')

    <div class="table-responsive">
        <table id="employee-table" class="table">
            <thead>
                <tr>
                    {{-- <th class="not-exported"></th> --}}
                    <th><input type="checkbox"></th>
                    <th>SL</th>
                    <th>Designation</th>
                    <th>Company</th>
                    <th>Department</th>
                    <th>Added By</th>
                    <th>Created_At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>1</td>
                    <td>Software Developer</td>
                    <td>HARSALE</td>
                    <td>CSE</td>
                    <td>Mainul Islam</td>
                    <td>Jan-06-2021</td>
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