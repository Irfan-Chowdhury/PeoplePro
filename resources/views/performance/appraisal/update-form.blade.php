<form action="" method="POST" id="updatetForm">
    @csrf 
    <input type="hidden" name="appraisal_id" value="{{$appraisal->id}}">
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Company</b></label>
        <div class="col-sm-6">
            <select name="company_id" id="companyIdEdit" class="form-control">
                @foreach ($companies as $company)
                    <option value="{{$company->id}}" {{ $company->id == $appraisal->company_id ? 'selected="selected"' : '' }}>{{$company->company_name}}</option>
                @endforeach
            </select>                     
        </div>
    </div>

    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Employee</b></label>
        <div class="col-sm-6" id="designation-selection">
            <select name="employee_id" id="employeeIdEdit" class="form-control">
                <option value="{{$appraisal->employee_id}}">{{ $appraisal->employee->first_name.' '.$appraisal->employee->last_name }}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Select Date</b></label>
        <div class="col-sm-6" id="designation-selection">
            <input type="text" class="form-control"  name="date" id="date" readonly value="{{ $appraisal->date}}">
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
                        @if ($appraisal->customer_experience == 'None')
                            <option value="{{$appraisal->customer_experience}}" selected>{{$appraisal->customer_experience}}</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->customer_experience == 'Beginner')
                            <option value="None" selected>None</option>
                            <option value="{{$appraisal->customer_experience}}" selected>{{$appraisal->customer_experience}}</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->customer_experience == 'Intermidiate')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="{{$appraisal->customer_experience}}" selected>{{$appraisal->customer_experience}}</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->customer_experience == 'Advanced')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="{{$appraisal->customer_experience}}" selected>{{$appraisal->customer_experience}}</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->customer_experience == 'Expert/Leader')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="{{$appraisal->customer_experience}}" selected>{{$appraisal->customer_experience}}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Marketing</b></label>
                <div class="col-sm-6">
                    <select name="marketing" id="marketing" class="form-control">
                        @if ($appraisal->marketing == 'None')
                            <option value="{{$appraisal->marketing}}" selected>{{$appraisal->marketing}}</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->marketing == 'Beginner')
                            <option value="None" selected>None</option>
                            <option value="{{$appraisal->marketing}}" selected>{{$appraisal->marketing}}</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->marketing == 'Intermidiate')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="{{$appraisal->marketing}}" selected>{{$appraisal->marketing}}</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->marketing == 'Advanced')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="{{$appraisal->marketing}}" selected>{{$appraisal->marketing}}</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->marketing == 'Expert/Leader')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="{{$appraisal->marketing}}" selected>{{$appraisal->marketing}}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Administration</b></label>
                <div class="col-sm-6">
                    <select name="administration" id="administration" class="form-control">
                        @if ($appraisal->administration == 'None')
                            <option value="{{$appraisal->administration}}" selected>{{$appraisal->administration}}</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->administration == 'Beginner')
                            <option value="None" selected>None</option>
                            <option value="{{$appraisal->administration}}" selected>{{$appraisal->administration}}</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->administration == 'Intermidiate')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="{{$appraisal->administration}}" selected>{{$appraisal->administration}}</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->administration == 'Advanced')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="{{$appraisal->administration}}" selected>{{$appraisal->administration}}</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->administration == 'Expert/Leader')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="{{$appraisal->administration}}" selected>{{$appraisal->administration}}</option>
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
                        @if ($appraisal->professionalism == 'None')
                            <option value="{{$appraisal->professionalism}}" selected>{{$appraisal->professionalism}}</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->professionalism == 'Beginner')
                            <option value="None" selected>None</option>
                            <option value="{{$appraisal->professionalism}}" selected>{{$appraisal->professionalism}}</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->professionalism == 'Intermidiate')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="{{$appraisal->professionalism}}" selected>{{$appraisal->professionalism}}</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->professionalism == 'Advanced')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="{{$appraisal->professionalism}}" selected>{{$appraisal->professionalism}}</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->professionalism == 'Expert/Leader')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="{{$appraisal->professionalism}}" selected>{{$appraisal->professionalism}}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Integrity</b></label>
                <div class="col-sm-6">
                    <select name="integrity" id="integrity" class="form-control">
                        @if ($appraisal->integrity == 'None')
                            <option value="{{$appraisal->integrity}}" selected>{{$appraisal->integrity}}</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->integrity == 'Beginner')
                            <option value="None" selected>None</option>
                            <option value="{{$appraisal->integrity}}" selected>{{$appraisal->integrity}}</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->integrity == 'Intermidiate')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="{{$appraisal->integrity}}" selected>{{$appraisal->integrity}}</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->integrity == 'Advanced')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="{{$appraisal->integrity}}" selected>{{$appraisal->integrity}}</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->integrity == 'Expert/Leader')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="{{$appraisal->integrity}}" selected>{{$appraisal->integrity}}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-6 col-form-label"><b>Attendance</b></label>
                <div class="col-sm-6">
                    <select name="attendance" id="attendance" class="form-control">
                        @if ($appraisal->attendance == 'None')
                            <option value="{{$appraisal->attendance}}" selected>{{$appraisal->attendance}}</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->attendance == 'Beginner')
                            <option value="None" selected>None</option>
                            <option value="{{$appraisal->attendance}}" selected>{{$appraisal->attendance}}</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->attendance == 'Intermidiate')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="{{$appraisal->attendance}}" selected>{{$appraisal->attendance}}</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->attendance == 'Advanced')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="{{$appraisal->attendance}}" selected>{{$appraisal->attendance}}</option>
                            <option value="Expert/Leader">Expert/Leader</option>
                        @elseif ($appraisal->attendance == 'Expert/Leader')
                            <option value="None" selected>None</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermidiate">Intermidiate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="{{$appraisal->attendance}}" selected>{{$appraisal->attendance}}</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Remarks</b></label>
        <div class="col-sm-12">
            <textarea name="remarks" id="remarks" rows="5" class="form-control" placeholder="Remarks">{{$appraisal->remarks}}</textarea>
        </div>
    </div>

</form>


<script>
    //after selecting Company then Employee will be loaded
    $('#companyIdEdit').change(function(){
            var companyId = $(this).val();
            console.log(companyId);
            
            if (companyId){
                $.get("{{route('performance.appraisal.get-employee')}}",{company_id:companyId}, function (data){
                    console.log(data);
                    $('#employeeIdEdit').empty().html(data); 
                });
            }else{
                $('#employeeIdEdit').empty().html('<option>--Select --</option>');
            }
        });
</script>