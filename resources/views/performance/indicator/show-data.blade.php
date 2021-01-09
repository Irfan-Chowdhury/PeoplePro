<form action="" method="POST" id="updatetForm">
    @csrf 

    <input type="hidden" name="indicator_id" id="indicatorId" value="{{$indicator->id}}">
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Company</b></label>
        <div class="col-sm-6">
            {{-- <select name="company_id" id="companyId" class="form-control selectpicker dynamic"
                data-live-search="true" data-live-search-style="begins" data-first_name="first_name"
                data-last_name="last_name" title='{{__('Selecting',['key'=>trans('file.Company')])}}'>
            </select>    --}}

            <select name="company_id" id="companyIdEdit" class="form-control">
                <option value="">-- Select --</option>
                @foreach ($companies as $company)
                    <option value="{{$company->id}}" {{ $company->id == $indicator->company_id ? 'selected="selected"' : '' }}>{{$company->company_name}}</option>
                @endforeach    
            </select>   
        </div>
    </div>

    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Designation</b></label>
        <div class="col-sm-6" id="designation-selection">
            <select name="designation_id" id="designationIdEdit" class="form-control">
                <option value="{{$indicator->designation_id}}">{{$indicator->designation->designation_name}}</option>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <h5><b>Technical Competencies</b></h5>
            <br>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Customer
                        Experience</b></label>
                <div class="col-sm-6">
                    <select name="customer_experience" id="customerExperience" class="form-control">
                        @if ($indicator->customer_experience == 'None')
                            <option value="{{$indicator->customer_experience}}" selected>{{$indicator->customer_experience}}</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->customer_experience == 'Beginner')
                            <option value="None" selected>None</option>
                            <option value="{{$indicator->customer_experience}}" selected>{{$indicator->customer_experience}}</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->customer_experience == 'Intermidiate')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="{{$indicator->customer_experience}}" selected>{{$indicator->customer_experience}}</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->customer_experience == 'Advanced')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="{{$indicator->customer_experience}}" selected>{{$indicator->customer_experience}}</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->customer_experience == 'Expert/Leader')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="{{$indicator->customer_experience}}" selected>{{$indicator->customer_experience}}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Marketing</b></label>
                <div class="col-sm-6">
                    <select name="marketing" id="marketing" class="form-control dynamic">
                        @if ($indicator->marketing == 'None')
                            <option value="{{$indicator->marketing}}" selected>{{$indicator->marketing}}</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->marketing == 'Beginner')
                            <option value="None" selected>None</option>
                            <option value="{{$indicator->marketing}}" selected>{{$indicator->marketing}}</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->marketing == 'Intermidiate')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="{{$indicator->marketing}}" selected>{{$indicator->marketing}}</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->marketing == 'Advanced')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="{{$indicator->marketing}}" selected>{{$indicator->marketing}}</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->marketing == 'Expert/Leader')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="{{$indicator->marketing}}" selected>{{$indicator->marketing}}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Administration</b></label>
                <div class="col-sm-6">
                    <select name="administrator" id="administrator" class="form-control">
                        @if ($indicator->administrator == 'None')
                            <option value="{{$indicator->administrator}}" selected>{{$indicator->administrator}}</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->administrator == 'Beginner')
                            <option value="None" selected>None</option>
                            <option value="{{$indicator->administrator}}" selected>{{$indicator->administrator}}</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->administrator == 'Intermidiate')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="{{$indicator->administrator}}" selected>{{$indicator->administrator}}</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->administrator == 'Advanced')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="{{$indicator->administrator}}" selected>{{$indicator->administrator}}</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->administrator == 'Expert/Leader')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="{{$indicator->administrator}}" selected>{{$indicator->administrator}}</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h5><b>Organizational Competencies</b></h5>
            <br>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Professionalism</b></label>
                <div class="col-sm-6">
                    <select name="professionalism" id="professionalism" class="form-control">
                        @if ($indicator->professionalism == 'None')
                            <option value="{{$indicator->professionalism}}" selected>{{$indicator->professionalism}}</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->professionalism == 'Beginner')
                            <option value="None" selected>None</option>
                            <option value="{{$indicator->professionalism}}" selected>{{$indicator->professionalism}}</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->professionalism == 'Intermidiate')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="{{$indicator->professionalism}}" selected>{{$indicator->professionalism}}</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->professionalism == 'Advanced')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="{{$indicator->professionalism}}" selected>{{$indicator->professionalism}}</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->professionalism == 'Expert/Leader')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="{{$indicator->professionalism}}" selected>{{$indicator->professionalism}}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Integrity</b></label>
                <div class="col-sm-6">
                    <select name="integrity" id="integrity" class="form-control">
                        @if ($indicator->integrity == 'None')
                            <option value="{{$indicator->integrity}}" selected>{{$indicator->integrity}}</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->integrity == 'Beginner')
                            <option value="None" selected>None</option>
                            <option value="{{$indicator->integrity}}" selected>{{$indicator->integrity}}</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->integrity == 'Intermidiate')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="{{$indicator->integrity}}" selected>{{$indicator->integrity}}</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->integrity == 'Advanced')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="{{$indicator->integrity}}" selected>{{$indicator->integrity}}</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->integrity == 'Expert/Leader')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="{{$indicator->integrity}}" selected>{{$indicator->integrity}}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Attendance</b></label>
                <div class="col-sm-6">
                    <select name="attendance" id="attendance" class="form-control">
                        @if ($indicator->attendance == 'None')
                            <option value="{{$indicator->attendance}}" selected>{{$indicator->attendance}}</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->attendance == 'Beginner')
                            <option value="None" selected>None</option>
                            <option value="{{$indicator->attendance}}" selected>{{$indicator->attendance}}</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->attendance == 'Intermidiate')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="{{$indicator->attendance}}" selected>{{$indicator->attendance}}</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->attendance == 'Advanced')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="{{$indicator->attendance}}" selected>{{$indicator->attendance}}</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($indicator->attendance == 'Expert/Leader')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="{{$indicator->attendance}}" selected>{{$indicator->attendance}}</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>

</form>


<script>
    $('#companyIdEdit').change(function() {   
        var companyIdEdit = $(this).val();

        if (companyIdEdit){
            $.get("{{route('performance.indicator.get-designation-by-company')}}",{company_id:companyIdEdit}, function (data){
                console.log(data);
                $('#designationIdEdit').empty().html(data);
            });
        }else{
            $('#designationIdEdit').empty().html('<option>--Select Student Type--</option>');
        }
    })
</script>