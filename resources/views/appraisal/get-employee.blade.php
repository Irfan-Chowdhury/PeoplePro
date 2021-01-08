<option value="">-- Select --</option>
@foreach($employees as $employee)
    <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}} </option>
@endforeach