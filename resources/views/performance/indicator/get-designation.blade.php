<option value="">-- Select --</option>
@foreach($designations as $designation)
        <option value="{{$designation->id}}">{{$designation->designation_name}}</option>
    @endforeach