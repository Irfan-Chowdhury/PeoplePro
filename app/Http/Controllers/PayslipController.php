<?php

namespace App\Http\Controllers;


use App\Employee;
use App\Payslip;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\traits\MonthlyWorkedHours;


class PayslipController extends Controller {

	use MonthlyWorkedHours;

	public function index()
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-payslip'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Payslip::with( ['employee:id,first_name,last_name,company_id,department_id','employee.company','employee.department'])->latest('created_at'))
					->setRowId(function ($payslip)
					{
						return $payslip->id;
					})
					->addColumn('employee_name', function ($row)
					{
						return $row->employee->full_name;
					})
					->addColumn('company', function ($row)
					{
						$company_name = $row->employee->company->company_name ?? '';
						$department_name = $row->employee->department->department_name ?? '';
						return $company_name . ' (' . $department_name . ')';
					})
					->addColumn('net_payable', function ($row)
					{
						return $row->net_salary;
					})
					->addColumn('action', function ($data)
					{
							$button  = '<a id="' . $data->payslip_key . '" class="show btn btn-primary btn-sm" href="' . route('payslip_details.show', $data->payslip_key) . '"><i class="dripicons-preview"></i></a>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<a id="' . $data->payslip_key . '" class="download btn btn-info btn-sm" href="' . route('payslip.pdf', $data->payslip_key) . '"><i class="dripicons-download"></i></a>';
							return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('salary.payslip.index');
		}

		return abort('403', __('You are not authorized'));
	}

	public function show(Payslip $payslip){


		$employee = Employee::with('user:id,username','company:id,company_name','department:id,department_name','designation:id,designation_name')
			->select('id','first_name','last_name','joining_date','contact_no','company_id','department_id','designation_id', 'payslip_type')
			->where('id',$payslip->employee_id)->first();
		$total_minutes = 0 ;
		$total_hours = $this->totalWorkedHours($employee);
		sscanf($total_hours, '%d:%d', $hour, $min);
		//converting in minute
		$total_minutes += $hour * 60 + $min;
		$amount_hours = ($payslip->basic_salary / 60 ) * $total_minutes;

		return view('salary.payslip.show',compact('payslip','employee','total_hours','amount_hours'));
	}



	public function delete(Payslip $payslip){
		if ($payslip->exists)
		{
			$payslip->delete();

			return response()->json(['success' => __('Payslip Deleted successfully')]);
		}
		return response()->json(['error' => 'Operation Unsuccessful']);
	}


	public function printPdf(Payslip $payslip){

		$employee = Employee::with('user:id,username','company.Location.country',
			'department:id,department_name','designation:id,designation_name')
			->select('id','first_name','last_name','joining_date','contact_no','company_id','department_id','designation_id','payslip_type')
			->where('id',$payslip->employee_id)->first()->toArray();

		$employee_new = Employee::findOrFail($payslip->employee_id);

		$total_minutes = 0 ;
		$total_hours = $this->totalWorkedHours($employee_new);
		sscanf($total_hours, '%d:%d', $hour, $min);
		//converting in minute
		$total_minutes += $hour * 60 + $min;
		$amount_hours = ($payslip->basic_salary / 60 ) * $total_minutes;
		$employee['hours_amount'] = $amount_hours;

		PDF::setOptions(['dpi' => 10, 'defaultFont' => 'sans-serif','tempDir'=>storage_path('temp')]);
        $pdf = PDF::loadView('salary.payslip.pdf', $payslip,$employee);
        return $pdf->stream();
	}

}

