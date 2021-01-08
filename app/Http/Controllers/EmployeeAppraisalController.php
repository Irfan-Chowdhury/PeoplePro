<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\EmployeeAppraisal;
use App\company;
use App\Employee;

class EmployeeAppraisalController extends Controller
{
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data = EmployeeAppraisal::orderBy('id','DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" name="edit" data-id="'.$row->id.'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" name="delete" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        
        $companies = company::all();

        return view('appraisal.index',compact('companies'));
    }

    public function getEmployee(Request $request)
    {
        if ($request->ajax()) //this way is better
        {
            $employees = Employee::where('company_id',$request->company_id)
                                ->get();

            return view('appraisal.get-employee',compact('employees'));
            // return response()->json($employees);
        }
        
    }

    public function store(Request $request)
    {
        // return response()->json("Done");

        // if ($request->ajax()) //this way is better
        // {
            $company = company::find($request->company_id);
            $employee = Employee::find($request->employee_id);

            $employeeAppraisal = new EmployeeAppraisal();
            // $employeeAppraisal->company_id = $request->company_id;
            // $employeeAppraisal->company_id = $request->employee_id;

            $employeeAppraisal->company = $company->company_name;
            $employeeAppraisal->employee = $employee->first_name.' '.$employee->last_name;
            $employeeAppraisal->department = $employee->department->department_name;
            $employeeAppraisal->designation = $employee->designation->designation_name;
            $employeeAppraisal->customer_experience = $request->customer_experience;
            $employeeAppraisal->marketing = $request->marketing;
            $employeeAppraisal->administration = $request->administration;
            $employeeAppraisal->professionalism = $request->professionalism;
            $employeeAppraisal->integrity  = $request->integrity;
            $employeeAppraisal->attendance = $request->attendance;
            $employeeAppraisal->date = date("Y-m-d");
            $employeeAppraisal->save();

            return response()->json("Done");
        // }
        
    }

    public function delete(Request $request)
    {
        $employeeAppraisal = EmployeeAppraisal::find($request->id);
        // $employeeAppraisal->delete();

        return response()->json($request->id);
    }
}
