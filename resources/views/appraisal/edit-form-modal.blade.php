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