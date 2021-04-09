<?php

namespace App\Http\Controllers;

use App\company;
use App\Employee;
use App\FinanceBankCash;
use App\FinanceExpense;
use App\FinanceTransaction;
use App\Http\traits\TotalSalaryTrait;
use App\Payslip;
use App\SalaryLoan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use Throwable;

use App\Http\traits\MonthlyWorkedHours;
use App\SalaryAllowance;
use App\SalaryBasic;
use App\SalaryCommission;

class PayrollController extends Controller {

	//
	use TotalSalaryTrait;
	use MonthlyWorkedHours;

	public function index(Request $request)
	{
		$logged_user = auth()->user();
		$companies = company::all();

		$selected_date = empty($request->filter_month_year) ? now()->format('F-Y') : $request->filter_month_year;
		$first_date = date('Y-m-d', strtotime('first day of ' . $selected_date));
		$last_date = date('Y-m-d', strtotime('last day of ' . $selected_date));

        //---------- Test -------
        // $selected_date = '2021-05-01';
        // $first_date = '2021-03-01';
        // $selected_date = 'March-2021';
		// $nmonth = date('m',strtotime($selected_date));
		// return $nmonth ;

		// $salary_basic = SalaryBasic::where('first_date','<=',$first_date)->select('employee_id')->distinct()->get();
		// $salary_basic = SalaryBasic::where('first_date','<=',$first_date)->distinct()->pluck('employee_id');
		// return $salary_basic;

        // $paid_employees = Payslip::where('month_year',$selected_date)->pluck('employee_id');

        // $employee = Employee::with([
        //             'salaryBasic' => function ($query) 
        //             {	
		// 				$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
		// 				// $query->select('first_date')->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
							
        //             },
        //             'allowances' => function ($query) 
		// 			{
		// 				$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
		// 			},
		// 			'commissions'=> function ($query)
		// 			{
		// 				$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
		// 			},
		// 			'loans', 'deductions','overtimes', 'otherPayments',
        //             'payslips' => function ($query) use ($selected_date)
        //             {
        //                 $query->where('month_year', $selected_date);
        //             },
        //             // 'employeeAttendance' => function ($query) use ($first_date, $last_date){
        //             //     $query->whereBetween('attendance_date', [$first_date, $last_date]);
        //             // }
		// 			])
        //             ->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
		// // 				->whereNotIn('id',$paid_employees)
		// // 				->get();
        //             ->where('id',9)->first();

        // return $employee->commissions;

		
		// //allowances
		// $allowance_amount = 0;
		// if (!$employee->allowances->isEmpty()) {
		// 	foreach($employee->allowances as $key => $item) {
		// 		if($item->first_date <= $first_date){
		// 			$allowance_amount = SalaryAllowance::where('month_year',$item->month_year)->where('employee_id',$item->employee_id)->sum('allowance_amount');
		// 		}
		// 	}
		// }

		// return $allowance_amount;

		// if (!empty($data_month_year)) {
        //     return $data_month_year;
		// }
		// else {
		// 	foreach($employees[0]->salaryBasic as $key => $salaryBasic)
		// 	if ($salaryBasic->first_date) {
		// 		# code...
		// 	}
		// }

		//$nmonth = date('m',strtotime($data_month_year));
		//return $employees[0]->salaryBasic;
        //return $employees[0]->salaryBasic[0]->month_year;
		

        //---------- Test -------



		if ($logged_user->can('view-paylist'))
		{
			if (request()->ajax())
			{
				$paid_employees = Payslip::where('month_year',$selected_date)->pluck('employee_id');
				
				$salary_basic_employees = SalaryBasic::where('first_date','<=',$first_date)->distinct()->pluck('employee_id');


				if (!empty($request->filter_company && $request->filter_department))
				{
					$employees = Employee::with(['salaryBasic' => function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'allowances' => function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'commissions'=> function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},  
						'loans', 'deductions', 'overtimes', 'otherPayments',
						'payslips' => function ($query) use ($selected_date)
						{
							$query->where('month_year', $selected_date);
						},
						'employeeAttendance' => function ($query) use ($first_date, $last_date){
							$query->whereBetween('attendance_date', [$first_date, $last_date]);
						}])
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
						->where('company_id', $request->filter_company)
						->where('department_id', $request->filter_department)
						->whereIn('id',$salary_basic_employees)
						->whereNotIn('id',$paid_employees)
						->get();

				} elseif (!empty($request->filter_company))
				{
					$employees = Employee::with(['salaryBasic' => function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'allowances' => function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'commissions'=> function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						}, 
						'loans', 'deductions', 'overtimes', 'otherPayments',
						'payslips' => function ($query) use ($selected_date)
						{
							$query->where('month_year', $selected_date);
						},
						'employeeAttendance' => function ($query) use ($first_date, $last_date){
							$query->whereBetween('attendance_date', [$first_date, $last_date]);
						}])
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
						->where('company_id', $request->filter_company)
						->whereIn('id',$salary_basic_employees)
						->whereNotIn('id',$paid_employees)
						->get();
				} else
				{
					$employees = Employee::with(['salaryBasic' => function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'allowances' => function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'commissions'=> function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'loans', 'deductions', 'overtimes', 'otherPayments',
						'payslips' => function ($query) use ($selected_date)
						{
							$query->where('month_year', $selected_date);
						},
						'employeeAttendance' => function ($query) use ($first_date, $last_date){
							$query->whereBetween('attendance_date', [$first_date, $last_date]);
						}])
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
                        ->whereIn('id',$salary_basic_employees)
						->whereNotIn('id',$paid_employees)
						// ->where('id',9)
						->get();
				}

				return datatables()->of($employees)
					->setRowId(function ($pay_list)
					{
						return $pay_list->id;
					})
					->addColumn('employee_name', function ($row)
					{
						return $row->full_name;
					})
					->addColumn('payslip_type', function ($row) use ($first_date)
					{
                        foreach ($row->salaryBasic as $salaryBasic) {
                            if($salaryBasic->first_date <= $first_date)
                            {
                                $payslip_type = $salaryBasic->payslip_type; //payslip_type
                            }
                        }
						return $payslip_type;
					})
					->addColumn('basic_salary', function ($row) use ($first_date)
					{
                        foreach ($row->salaryBasic as $salaryBasic) {
                            if($salaryBasic->first_date <= $first_date)
                            {
                                $basicsalary = $salaryBasic->basic_salary; //basic salary
                            }
                        }
						return $basicsalary;
					})
					->addColumn('net_salary', function ($row)  use ($first_date)
					{
						//payslip_type & basic_salary
						foreach ($row->salaryBasic as $salaryBasic) {
                            if($salaryBasic->first_date <= $first_date){
                                $payslip_type = $salaryBasic->payslip_type; 
								$basicsalary = $salaryBasic->basic_salary;
                            }
                        }

						//allowances
						$allowance_amount = 0;
						if (!$row->allowances->isEmpty()) {
							foreach($row->allowances as $item) {
								if($item->first_date <= $first_date){
									// $allowance_amount = SalaryAllowance::where('month_year',$item->month_year)->where('employee_id',$item->employee_id)->sum('allowance_amount');
									$allowance_amount = 0;
									foreach($row->allowances as $value) {
										if($value->first_date <= $first_date){
											if ($item->first_date == $value->first_date) {
												$allowance_amount += $value->allowance_amount;
											}
										}
									}
								}
							}
						}
						
						//commission
						$commission_amount = 0;
						if (!$row->commissions->isEmpty()) {
							foreach($row->commissions as $item) {
								if($item->first_date <= $first_date){
									// $commission_amount = SalaryCommission::where('month_year',$item->month_year)->where('employee_id',$item->employee_id)->sum('commission_amount');
									$commission_amount = 0;
									foreach($row->commissions as $value) {
										if($value->first_date <= $first_date){
											if ($item->first_date == $value->first_date) {
												$commission_amount += $value->commission_amount;
											}
										}
									}
								}
							}
						}
						
						//Net Salary
						if ($payslip_type == 'Monthly'){
							$total_salary = $this->totalSalary($row, $payslip_type, $basicsalary, $allowance_amount, $commission_amount);
						} 
						else{
							$total = 0;
							$total_hours = $this->totalWorkedHours($row);

							sscanf($total_hours, '%d:%d', $hour, $min);
							//converting in minute
							$total += $hour * 60 + $min;
							$total_salary = $this->totalSalary($row, $payslip_type, $basicsalary, $allowance_amount, $commission_amount, $total);
						}

						return $total_salary;

						// if ($row->payslip_type == 'Monthly')
						// {
						// 	$total_salary = $this->totalSalary($row);
						// } else
						// {
						// 	$total = 0;
						// 	$total_hours = $this->totalWorkedHours($row);

						// 	sscanf($total_hours, '%d:%d', $hour, $min);
						// 	//converting in minute
						// 	$total += $hour * 60 + $min;
						// 	$total_salary = $this->totalSalary($row, $total);
						// }

					})
					->addColumn('status', function ($row)
					{
						foreach ($row->payslips as $payslip)
						{
							$status = $payslip->status;

							return $status;
						}
					})
					->addColumn('action', function ($data)
					{
						if (auth()->user()->can('view-paylist'))
						{
							if (auth()->user()->can('make-payment'))
							{
								$button = '<button type="button" name="view" id="' . $data->id . '" class="details btn btn-primary btn-sm" title="Details"><i class="dripicons-preview"></i></button>';
								$button .= '&nbsp;&nbsp;';
								$button .= '<button type="button" name="payment" id="' . $data->id . '" class="generate_payment btn btn-secondary btn-sm" title="generate_payment"><i class="fa fa-money"></i></button>';
							} else
							{
								$button = '';
							}
							return $button;
						} else
						{
							return '';
						}
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('salary.pay_list.index', compact('companies'));
		}

		return abort('403', __('You are not authorized'));
	}


	// public function index(Request $request)
	// {
	// 	$logged_user = auth()->user();
	// 	$companies = company::all();

	// 	$selected_date = empty($request->filter_month_year) ? now()->format('F-Y') : $request->filter_month_year;

	// 	$first_date = date('Y-m-d', strtotime('first day of ' . $selected_date));
	// 	$last_date = date('Y-m-d', strtotime('last day of ' . $selected_date));


	// 	if ($logged_user->can('view-paylist'))
	// 	{
	// 		if (request()->ajax())
	// 		{

	// 			if (!empty($request->filter_company && $request->filter_department))
	// 			{
	// 				$employees = Employee::with(['allowances', 'loans', 'deductions', 'commissions', 'overtimes', 'otherPayments',
	// 					'payslips' => function ($query) use ($selected_date)
	// 					{
	// 						$query->where('month_year', $selected_date);
	// 					},
	// 					'employeeAttendance' => function ($query) use ($first_date, $last_date){
	// 						$query->whereBetween('attendance_date', [$first_date, $last_date]);
	// 					}])
	// 					->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
	// 					->where('company_id', $request->filter_company)
	// 					->where('department_id', $request->filter_department)
	// 					->get();

	// 			} elseif (!empty($request->filter_company))
	// 			{
	// 				$employees = Employee::with(['allowances', 'loans', 'deductions', 'commissions', 'overtimes', 'otherPayments',
	// 					'payslips' => function ($query) use ($selected_date)
	// 					{
	// 						$query->where('month_year', $selected_date);
	// 					},
	// 					'employeeAttendance' => function ($query) use ($first_date, $last_date){
	// 						$query->whereBetween('attendance_date', [$first_date, $last_date]);
	// 					}])
	// 					->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
	// 					->where('company_id', $request->filter_company)
	// 					->get();
	// 			} else
	// 			{
	// 				$employees = Employee::with(['allowances', 'loans', 'deductions',
	// 					'commissions', 'overtimes', 'otherPayments',
	// 					'payslips' => function ($query) use ($selected_date)
	// 					{
	// 						$query->where('month_year', $selected_date);
	// 					},
	// 					'employeeAttendance' => function ($query) use ($first_date, $last_date){
	// 						$query->whereBetween('attendance_date', [$first_date, $last_date]);
	// 					}])
	// 					->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
	// 					->get();
	// 			}


	// 			return datatables()->of($employees)
	// 				->setRowId(function ($pay_list)
	// 				{
	// 					return $pay_list->id;
	// 				})
	// 				->addColumn('employee_name', function ($row)
	// 				{
	// 					return $row->full_name;
	// 				})
	// 				->addColumn('net_salary', function ($row)
	// 				{
	// 					if ($row->payslip_type == 'Monthly')
	// 					{
	// 						$total_salary = $this->totalSalary($row);
	// 					} else
	// 					{
	// 						$total = 0;
	// 						$total_hours = $this->totalWorkedHours($row);

	// 						sscanf($total_hours, '%d:%d', $hour, $min);
	// 						//converting in minute
	// 						$total += $hour * 60 + $min;
	// 						$total_salary = $this->totalSalary($row, $total);
	// 					}

	// 					return $total_salary;

	// 				})
	// 				->addColumn('status', function ($row)
	// 				{
	// 					foreach ($row->payslips as $payslip)
	// 					{
	// 						$status = $payslip->status;

	// 						return $status;
	// 					}
	// 				})
	// 				->addColumn('action', function ($data)
	// 				{
	// 					if (auth()->user()->can('view-paylist'))
	// 					{
	// 						$status = 0;
	// 						$payslip_key = 0;
	// 						foreach ($data->payslips as $payslip)
	// 						{
	// 							$payslip_key = $payslip->payslip_key;
	// 							$status = $payslip->status;
	// 						}
	// 						if ($status == 1)
	// 						{
	// 							$button = '<a id="' . $payslip_key . '" class="payslip btn btn-info btn-sm" title="Payslip" href="' . route('payslip_details.show', $payslip_key) . '"><i class="dripicons-user-id"></i></a>';
	// 							$button .= '&nbsp;&nbsp;';
	// 							$button .= '<a id="' . $payslip_key . '" class="download btn-sm" style="background:#FF7588; color:#fff" title="Download" href="' . route('payslip.pdf', $payslip_key) . '"><i class="dripicons-download"></i></a>';
	// 						} else
	// 						{
	// 							if (auth()->user()->can('make-payment'))
	// 							{
	// 								$button = '<button type="button" name="view" id="' . $data->id . '" class="details btn btn-primary btn-sm" title="Details"><i class="dripicons-preview"></i></button>';
	// 								$button .= '&nbsp;&nbsp;';
	// 								$button .= '<button type="button" name="payment" id="' . $data->id . '" class="generate_payment btn btn-secondary btn-sm" title="generate_payment"><i class="fa fa-money"></i></button>';
	// 							} else
	// 							{
	// 								$button = '';
	// 							}
	// 						}

	// 						return $button;
	// 					} else
	// 					{
	// 						return '';
	// 					}
	// 				})
	// 				->rawColumns(['action'])
	// 				->make(true);
	// 		}

	// 		return view('salary.pay_list.index', compact('companies'));
	// 	}

	// 	return abort('403', __('You are not authorized'));
	// }


	public function paySlip(Request $request)
	{
		$month_year = $request->filter_month_year;
		$first_date = date('Y-m-d', strtotime('first day of ' . $month_year));
		$last_date = date('Y-m-d', strtotime('last day of ' . $month_year));

		$employee = Employee::with(['salaryBasic' => function ($query)
			{
				$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
			},
			'allowances' => function ($query)
			{
				$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
			},
			'commissions'=> function ($query)
			{
				$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
			}, 
			'loans', 'deductions', 'overtimes', 'otherPayments', 'designation', 'department', 'user',
			'employeeAttendance' => function ($query) use ($first_date, $last_date){
				$query->whereBetween('attendance_date', [$first_date, $last_date]);
			}])
			->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type', 'designation_id', 'department_id', 'joining_date')
			->findOrFail($request->id);

		//payslip_type && salary_basic
		foreach ($employee->salaryBasic as $salaryBasic) {
			if($salaryBasic->first_date <= $first_date){
				$basic_salary = $salaryBasic->basic_salary;
				$payslip_type = $salaryBasic->payslip_type;
			}
		}

		//allowances
		if (!$employee->allowances->isEmpty()) {
			foreach($employee->allowances as $item) {
				if($item->first_date <= $first_date){
					$allowances = array();
					foreach($employee->allowances as $key => $value) {
						if($value->first_date <= $first_date){
							//$allowances = array();
							if ($item->first_date == $value->first_date) {
								$allowances[] =  $employee->allowances[$key];
							}
						}
					}
					
				}
			}
		}else {
			$allowances = [];
		}
		
		
		//commissions
		if (!$employee->commissions->isEmpty()) {
			foreach($employee->commissions as $item) {
				if($item->first_date <= $first_date){
					$commissions = array();
					foreach($employee->commissions as $key => $value) {
						if($value->first_date <= $first_date){
							//$commissions = array();
							if ($item->first_date == $value->first_date) {
								$commissions[] =  $employee->commissions[$key];
							}
						}
					}
					
				}
			}
		}else {
			$commissions = [];
		}


		$data = [];
		// $data['basic_salary'] = $employee->basic_salary; //will be deleted---- 
		// $data['basic_total'] = $employee->basic_salary; //will be deleted---- 
		// $data['allowances'] = $employee->allowances; //will be deleted---- 
		// $data['commissions']  = $employee->commissions; //will be deleted---- 
		$data['basic_salary'] = $basic_salary; //----New Correction ---
		$data['basic_total']  = $basic_salary; //----New Correction ---
		$data['allowances']   = $allowances;  //----New Correction ---
		$data['commissions']  = $commissions; //----New Correction ---
		$data['loans']        = $employee->loans;
		$data['deductions']   = $employee->deductions;
		$data['overtimes']    = $employee->overtimes;
		$data['other_payments'] = $employee->otherPayments;

		$data['employee_id']          = $employee->id;
		$data['employee_full_name']   = $employee->full_name;
		$data['employee_designation'] = $employee->designation->designation_name;
		$data['employee_department']  = $employee->department->department_name;
		$data['employee_join_date']   = $employee->joining_date;
		$data['employee_username']    = $employee->user->username;
		$data['employee_pp']          = $employee->user->profile_photo ?? '';

		// $data['payslip_type'] = $employee->payslip_type; //will be deleted---- 
		$data['payslip_type'] = $payslip_type;

		// if ($employee->payslip_type === 'Hourly') //will be deleted---- 
		if ($payslip_type === 'Hourly') //----New Correction ---
		{
			$total = 0;
			$total_hours_worked = $this->totalWorkedHours($employee);
			$data['monthly_worked_hours'] = $total_hours_worked;
			//formatting in hour:min and separating them
			sscanf($total_hours_worked, '%d:%d', $hour, $min);
			//converting in minute
			$total += $hour * 60 + $min;

			// $data['monthly_worked_amount'] = ($employee->basic_salary / 60) * $total; //will be deleted---- 
			$data['monthly_worked_amount'] = ($basic_salary / 60) * $total; //----New Correction ---

			$data['basic_total'] = $data['monthly_worked_amount'];
		}

		return response()->json(['data' => $data]);
	}

	public function paySlipGenerate(Request $request)
	{
		$month_year = $request->filter_month_year;
		$first_date = date('Y-m-d', strtotime('first day of ' . $month_year));
		$last_date = date('Y-m-d', strtotime('last day of ' . $month_year));

		$employee = Employee::with(['salaryBasic' => function ($query)
			{
				$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
			},
			'allowances' => function ($query)
			{
				$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
			},
			'commissions' => function ($query) 
			{
				$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
			}, 
			'loans', 'deductions', 'overtimes', 'otherPayments', 'designation', 'department', 'user',
			'employeeAttendance' => function ($query) use ($first_date, $last_date){
				$query->whereBetween('attendance_date', [$first_date, $last_date]);
			}])
			->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type', 'designation_id', 'department_id', 'joining_date')
			->findOrFail($request->id);


		//payslip_type & basic_salary
		foreach ($employee->salaryBasic as $salaryBasic) {
			if($salaryBasic->first_date <= $first_date)
			{
				$basic_salary = $salaryBasic->basic_salary;
				$payslip_type = $salaryBasic->payslip_type;
			}
		}

		//allowance
		$allowance_amount = 0;
		if (!$employee->allowances->isEmpty()) {
			foreach($employee->allowances as $key => $item) {
				if($item->first_date <= $first_date){
					$allowance_amount = SalaryAllowance::where('month_year',$item->month_year)->where('employee_id',$item->employee_id)->sum('allowance_amount');
				}
			}
		}
		
		//Commision
		$commission_amount = 0;
		if (!$employee->allowances->isEmpty()) {
			foreach($employee->allowances as $key => $item) {
				if($item->first_date <= $first_date){
					$commission_amount = SalaryCommission::where('month_year',$item->month_year)->where('employee_id',$item->employee_id)->sum('commission_amount');
				}
			}
		}

		$data = [];
		$data['employee']         = $employee->id;
		// $data['basic_salary']  = $employee->basic_salary; //will be deleted---- 
		// $data['total_allowance']  = $employee->allowances->sum('allowance_amount'); //will be deleted---- 
		// $data['total_commission'] = $employee->commissions->sum('commission_amount'); //will be deleted---- 
		$data['basic_salary']     = $basic_salary;  //----New Correction ---
		$data['total_allowance']  = $allowance_amount;
		$data['total_commission'] = $commission_amount;
		$data['monthly_payable']  = $employee->loans->sum('monthly_payable');
		$data['amount_remaining'] = $employee->loans->sum('amount_remaining');
		$data['total_deduction']  = $employee->deductions->sum('deduction_amount');
		$data['total_overtime']   = $employee->overtimes->sum('overtime_amount');
		$data['total_other_payment'] = $employee->otherPayments->sum('other_payment_amount');
		// $data['payslip_type']     = $employee->payslip_type; //will be deleted---- 
		$data['payslip_type']     = $payslip_type;

		// if ($employee->payslip_type == 'Monthly') //will be deleted---- 
		if ($payslip_type == 'Monthly') //----New Correction ---
		{
			// $data['total_salary'] = $this->totalSalary($employee); //will be deleted---- 
			$data['total_salary'] = $this->totalSalary($employee, $payslip_type, $basic_salary,$allowance_amount,$commission_amount);
		} else
		{
			$total = 0;
			$total_hours = $this->totalWorkedHours($employee);
			sscanf($total_hours, '%d:%d', $hour, $min);
			//converting in minute
			$total += $hour * 60 + $min;
			$data['total_hours'] = $total_hours;
			$data['worked_amount'] = ($data['basic_salary'] / 60) * $total;
			$data['total_salary'] = $this->totalSalary($employee,$payslip_type, $basic_salary, $allowance_amount, $commission_amount, $total);
		}
		return response()->json(['data' => $data]);
	}


	public function payEmployee($id, Request $request)
	{
		// return response()->json($request->month_year);
		
		$logged_user = auth()->user();

		if ($logged_user->can('make-payment'))
		{
			$first_date = date('Y-m-d', strtotime('first day of ' . $request->month_year));

			DB::beginTransaction();
				try
				{
					$employee = Employee::with(['allowances' => function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'commissions' => function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						}, 
						// 'allowances:id,employee_id,allowance_title,allowance_amount',
						// 'commissions:id,employee_id,commission_title,commission_amount',
						'loans:id,employee_id,loan_title,loan_amount,time_remaining,amount_remaining,monthly_payable',
						'deductions:id,employee_id,deduction_title,deduction_amount',
						'overtimes:id,employee_id,overtime_title,no_of_days,overtime_hours,overtime_rate,overtime_amount',
						'otherPayments:id,employee_id,other_payment_title,other_payment_amount'])
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
						->findOrFail($id);

					// //allowances
					if (!$employee->allowances->isEmpty()) {
						foreach($employee->allowances as $item) {
							if($item->first_date <= $first_date){
								$allowances = array();
								foreach($employee->allowances as $key => $value) {
									if($value->first_date <= $first_date){
										if ($item->first_date == $value->first_date) {
											$allowances[] =  $employee->allowances[$key];
										}
									}
								}
							}
						}
					}else {
						$allowances = [];
					}

					//commissions
					if (!$employee->commissions->isEmpty()) {
						foreach($employee->commissions as $item) {
							if($item->first_date <= $first_date){
								$commissions = array();
								foreach($employee->commissions as $key => $value) {
									if($value->first_date <= $first_date){
										if ($item->first_date == $value->first_date) {
											$commissions[] =  $employee->commissions[$key];
										}
									}
								}
							}
						}
					}else {
						$commissions = [];
					}


					$data = [];
					$data['payslip_key'] = Str::random('20');
					$data['payslip_number'] = mt_rand(1000000000,9999999999);
					// $data['payment_type'] = $employee->payslip_type; //will be deleted---- 
					// $data['basic_salary'] = $employee->basic_salary; //will be deleted---- 
					// $data['allowances'] = $employee->allowances; //will be deleted---- 
					//$data['commissions'] = $employee->commissions; //will be deleted---- 
					$data['payment_type'] = $request->payslip_type;
					$data['basic_salary'] = $request->basic_salary;
					
					$data['allowances']  = $allowances;
					$data['commissions'] = $commissions;
					$data['loans'] = $employee->loans;
					$data['deductions'] = $employee->deductions;
					$data['overtimes'] = $employee->overtimes;
					$data['other_payments'] = $employee->otherPayments;
					$data['month_year'] = $request->month_year;
					$data['net_salary'] = $request->net_salary;
					$data['status'] = 1;
					$data['employee_id'] = $employee->id;
					$data['hours_worked'] = $request->worked_hours;

					if ($data['payment_type'] == NULL) {
						return response()->json(['payment_type_error' => __('Please select a payslip-type for this employee.')]);
					}


					$account_balance = DB::table('finance_bank_cashes')->where('id', config('variable.account_id'))->pluck('account_balance')->first();

					if ((int)$account_balance < (int)$request->net_salary)
					{
						return response()->json(['error' => 'requested balance is less then available balance']);
					}

					$new_balance = (int)$account_balance - (int)$request->net_salary;

					$finance_data = [];

					$finance_data['account_id'] = config('variable.account_id');
					$finance_data['amount'] = $request->net_salary;
					$finance_data ['expense_date'] = now()->format(env('Date_Format'));
					$finance_data ['expense_reference'] = trans('file.Payroll');


					FinanceBankCash::whereId($finance_data['account_id'])->update(['account_balance' => $new_balance]);

					$Expense = FinanceTransaction::create($finance_data);

					$finance_data['id'] = $Expense->id;

					FinanceExpense::create($finance_data);

					if ($employee->loans)
					{
						foreach ($employee->loans as $loan)
						{
							if($loan->time_remaining === '0')
							{
								$amount_remaining = 0;
								$time_remaining = 0;
								$monthly_payable = 0;
							}
							else
							{
								$amount_remaining = $loan->amount_remaining - $loan->monthly_payable;
								$time_remaining = $loan->time_remaining - 1;
								$monthly_payable = $loan->monthly_payable;
							}
							SalaryLoan::whereId($loan->id)->update(['amount_remaining' => $amount_remaining, 'time_remaining' => $time_remaining,
								'monthly_payable' => $monthly_payable]);
						}
						$employee_loan = Employee::with('loans:id,employee_id,loan_title,loan_amount,time_remaining,amount_remaining,monthly_payable')
							->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
							->findOrFail($id);
						$data['loans'] = $employee_loan->loans;
					}
					Payslip::create($data);

					DB::commit();

				} catch (Exception $e)
				{
					DB::rollback();
					return response()->json(['error' => $e->getMessage()]);
				} catch (Throwable $e)
				{
					DB::rollback();
					return response()->json(['error' => $e->getMessage()]);
				}

				return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);

	}


	//--- Updated ----
	public function payBulk(Request $request)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('make-bulk_payment'))
		{
			if (request()->ajax())
			{

				$employeeArrayId = $request->all_checkbox_id;
				$paid_employee = Payslip::where('month_year', $request->month_year)->whereIn('employee_id',$employeeArrayId)->pluck('employee_id');
				$employeesId = Employee::whereIn('id',$employeeArrayId)->whereNotIn('id',$paid_employee)->pluck('id');

				if (!empty($request->filter_company && $request->filter_department)) //No Need
				{
					$employees = Employee::with('allowances:id,employee_id,allowance_title,allowance_amount',
						'loans:id,employee_id,loan_title,loan_amount',
						'deductions:id,employee_id,deduction_title,deduction_amount',
						'commissions:id,employee_id,commission_title,commission_amount',
						'overtimes:id,employee_id,overtime_title,no_of_days,overtime_hours,overtime_rate,overtime_amount',
						'otherPayments:id,employee_id,other_payment_title,other_payment_amount'
					)
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
						->where('company_id', $request->filter_company)
						->where('department_id', $request->filter_department)
						->whereIn('id', $employeesId)
						->get();
				} elseif (!empty($request->filter_company)) //No Need
				{
					$employees = Employee::with('allowances:id,employee_id,allowance_title,allowance_amount',
						'loans:id,employee_id,loan_title,loan_amount',
						'deductions:id,employee_id,deduction_title,deduction_amount',
						'commissions:id,employee_id,commission_title,commission_amount',
						'overtimes:id,employee_id,overtime_title,no_of_days,overtime_hours,overtime_rate,overtime_amount',
						'otherPayments:id,employee_id,other_payment_title,other_payment_amount'
					)
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
						->where('company_id', $request->filter_company)
						->whereIn('id', $employeesId)
						->get();
				} else
				{
					$employees = Employee::with('allowances:id,employee_id,allowance_title,allowance_amount',
						'loans:id,employee_id,loan_title,loan_amount',
						'deductions:id,employee_id,deduction_title,deduction_amount',
						'commissions:id,employee_id,commission_title,commission_amount',
						'overtimes:id,employee_id,overtime_title,no_of_days,overtime_hours,overtime_rate,overtime_amount',
						'otherPayments:id,employee_id,other_payment_title,other_payment_amount'
					)
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
						->whereIn('id', $employeesId)
						->get();
				}

				if ($employees->isEmpty())
				{
					return response()->json(['error' => 'Selected employees are already Paid']);
				}


				DB::beginTransaction();
					try
					{
						$total_sum = 0;
						foreach ($employees as $employee)
						{
							if ($employee->payslip_type == 'Monthly')
							{
								$net_salary = $this->totalSalary($employee);
							} else
							{
								$total = 0;
								$total_hours = $this->totalWorkedHours($employee);
								sscanf($total_hours, '%d:%d', $hour, $min);
								//converting in minute
								$total += $hour * 60 + $min;
								$net_salary = $this->totalSalary($employee, $total);
							}
							$data = [];
							$data['payslip_key'] = Str::random('20');
							$data['payslip_number'] = mt_rand(1000000000,9999999999);//Added
							$data['payment_type'] = $employee->payslip_type;
							$data['basic_salary'] = $employee->basic_salary;
							$data['allowances'] = $employee->allowances;
							$data['commissions'] = $employee->commissions;
							$data['loans'] = $employee->loans;
							$data['deductions'] = $employee->deductions;
							$data['overtimes'] = $employee->overtimes;
							$data['other_payments'] = $employee->otherPayments;
							$data['month_year'] = $request->month_year;
							$data['net_salary'] = $net_salary;
							$data['status'] = 1;
							$data['employee_id'] = $employee->id;

							$total_sum = $total_sum + $net_salary;

							if ($employee->loans)
							{
								foreach ($employee->loans as $loan)
								{
									if($loan->time_remaining === '0')
									{
										$amount_remaining = 0;
										$time_remaining = 0;
										$monthly_payable = 0;
									}
									else
									{
										$amount_remaining = $loan->amount_remaining - $loan->monthly_payable;
										$time_remaining = $loan->time_remaining - 1;
										$monthly_payable = $loan->monthly_payable;
									}
									SalaryLoan::whereId($loan->id)->update(['amount_remaining' => $amount_remaining, 'time_remaining' => $time_remaining,
										'monthly_payable' => $monthly_payable]);
								}
								$employee_loan = Employee::with('loans:id,employee_id,loan_title,loan_amount,time_remaining,amount_remaining,monthly_payable')
									->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
									->findOrFail($employee->id);
								$data['loans'] = $employee_loan->loans;
							}

							if ($data['payment_type'] == NULL) { //New
								return response()->json(['payment_type_error' => __('Please select payslip-type for the employees.')]);
							}

							Payslip::create($data);

						}

						$account_balance = DB::table('finance_bank_cashes')->where('id', config('variable.account_id'))->pluck('account_balance')->first();

						if ((int)$account_balance < $total_sum)
						{
							throw new Exception("requested balance is less then available balance");
						}

						$new_balance = (int)$account_balance - (int)$total_sum;

						$finance_data = [];

						$finance_data['account_id'] = config('variable.account_id');
						$finance_data['amount'] = $total_sum;
						$finance_data ['expense_date'] = now()->format(env('Date_Format'));
						$finance_data ['expense_reference'] = trans('file.Payroll');


						FinanceBankCash::whereId($finance_data['account_id'])->update(['account_balance' => $new_balance]);

						$Expense = FinanceTransaction::create($finance_data);

						$finance_data['id'] = $Expense->id;

						FinanceExpense::create($finance_data);

						DB::commit();
					} catch (Exception $e)
					{
						DB::rollback();
						return response()->json(['error' =>  $e->getMessage()]);
					} catch (Throwable $e)
					{
						DB::rollback();
						return response()->json(['error' => $e->getMessage()]);
					}

					return response()->json(['success' => __('Paid Successfully')]);
			}
		}

		return response()->json(['error' => __('Error')]);
	}
}



// $ip_server = $_SERVER['REMOTE_ADDR'];
// $ip_server = $_SERVER['HTTP_CLIENT_IP'];
// $ip_server = $_SERVER['HTTP_X_FORWARDED_FOR'];
// $ip_server = gethostbyaddr($_SERVER['REMOTE_ADDR']);
// $ip_server = gethostbyaddr($_SERVER['REMOTE_HOST']);
// $myPublicIP = trim(shell_exec("dig +short myip.opendns.REMOTE_HOSTcom @resolver1.opendns.com"));
// return "Server IP Address is: ". $ip_server;

// $ipaddress = '';
// if (isset($_SERVER['HTTP_CLIENT_IP']))
// 	$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
// else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
// 	$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
// else if(isset($_SERVER['HTTP_X_FORWARDED']))
// 	$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
// else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
// 	$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
// else if(isset($_SERVER['HTTP_FORWARDED']))
// 	$ipaddress = $_SERVER['HTTP_FORWARDED'];
// else if(isset($_SERVER['REMOTE_ADDR']))
// 	$ipaddress = $_SERVER['REMOTE_ADDR'];
// else
// 	$ipaddress = 'UNKNOWN';
// return $ipaddress;

