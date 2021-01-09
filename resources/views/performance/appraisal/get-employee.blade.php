<option value="">-- Select Employee--</option>
@foreach ($employees as $item)
    <option value="{{$item->id}}">{{$item->first_name.' '.$item->last_name}}</option>
@endforeach