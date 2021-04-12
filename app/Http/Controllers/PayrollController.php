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
use App\SalaryDeduction;
use App\SalaryOtherPayment;

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
        // $selected_date = 'April-2021';
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
		// 			'commissions'=> function ($query) use ($first_date)
		// 			{
		// 				$query->where('first_date', $first_date);
		// 			},
		// 			'deductions'=> function ($query)
		// 			{
		// 				$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
		// 			},
		// 			'otherPayments'=> function ($query) use ($first_date)
		// 			{
		// 				$query->where('first_date', $first_date);
		// 			},
        //             'loans'=> function ($query) use ($first_date)
		// 			{
		// 				$query->where('first_date','<=', $first_date)
		// 				->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
		// 			},
		// 			'overtimes'=> function ($query) use ($selected_date)
		// 			{
		// 				$query->where('month_year', $selected_date);
		// 			},
        //             'payslips' => function ($query) use ($selected_date)
        //             {
        //                 $query->where('month_year', $selected_date);
        //             },
        //             // 'employeeAttendance' => function ($query) use ($first_date, $last_date){
        //             //     $query->whereBetween('attendance_date', [$first_date, $last_date]);
        //             // }
		// 			])
        //             ->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type','pension_type','pension_amount')
		// // 				->whereNotIn('id',$paid_employees)
		// // 				->get();
        //             ->where('id',11)->first();

        // //return $employee->allowances->sum('allowance_amount');

        //  foreach ($employee->salaryBasic as $salaryBasic) {
        //     if($salaryBasic->first_date <= $first_date){
        //         $payslip_type = $salaryBasic->payslip_type;
        //         $basic_salary = $salaryBasic->basic_salary;
        //     }
        // }

        // //allowances
		// $allowance_amount = 0;
		// if (!$employee->allowances->isEmpty()) {
		// 	foreach($employee->allowances as $key => $item) {
		// 		if($item->first_date <= $first_date){
		// 			$allowance_amount = SalaryAllowance::where('month_year',$item->month_year)->where('employee_id',11)->sum('allowance_amount');
		// 		}
		// 	}
		// }


		// $deduction_amount = 0;
		// if (!$employee->deductions->isEmpty()) {
		// 	foreach($employee->deductions as $key => $item) {
		// 		if($item->first_date <= $first_date){
		// 			$deduction_amount = SalaryDeduction::where('month_year',$item->month_year)->where('employee_id',$item->employee_id)->sum('deduction_amount');
		// 		}
		// 	}
		// }

        // $total = 0 + $allowance_amount + $employee->commissions->sum('commission_amount')
        // - $employee->loans->sum('monthly_payable')
        // - $deduction_amount - 0 // (basic_salary - pension_amount)
        // + $employee->otherPayments->sum('other_payment_amount') + $employee->overtimes->sum('overtime_amount');

        // // return $basic_salary; //100
        // // return $allowance_amount; //250
        // // return $employee->commissions->sum('commission_amount'); //0
        // // return $employee->loans->sum('monthly_payable'); //0
        // // return $deduction_amount; // 10
        // // return $employee->otherPayments->sum('other_payment_amount'); // 0
        // // return $employee->overtimes->sum('overtime_amount'); // 0
        // return $total;




        // if ($employee->percentage) {
        //     $pension_amount =  ($basicsalary * $employee->pension_amount) /100.00;
        // } else {
        //     $pension_amount = $employee->pension_amount;
        // }

        // return $pension_amount;



		//allowances
		// $loans_amount = 0;
		// if (!$employee->loans->isEmpty()) {
		// 	foreach($employee->loans as $key => $item) {
		// 		if($item->first_date <= $first_date){
		// 			$loans_amount += SalaryLoan::where('month_year',$item->month_year)->where('employee_id',$item->employee_id)->sum('monthly_payable');
		// 		}
		// 	}
		// }

		// return $loans_amount;

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
						'commissions'=> function ($query) use ($first_date)
            			{
            				$query->where('first_date', $first_date);
            			},
						'loans'=> function ($query) use ($first_date)
						{
							$query->where('first_date','<=', $first_date)
							->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'deductions'=> function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'otherPayments'=> function ($query) use ($first_date)
						{
							$query->where('first_date', $first_date);
						},
						'overtimes'=> function ($query) use ($selected_date)
						{
							$query->where('month_year', $selected_date);
						},
						'payslips' => function ($query) use ($selected_date)
						{
							$query->where('month_year', $selected_date);
						},
						'employeeAttendance' => function ($query) use ($first_date, $last_date){
							$query->whereBetween('attendance_date', [$first_date, $last_date]);
						}])
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type','pension_type','pension_amount')
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
						'commissions'=> function ($query) use ($first_date)
            			{
            				$query->where('first_date', $first_date);
            			},
						'loans'=> function ($query) use ($first_date)
						{
							$query->where('first_date','<=', $first_date)
							->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'deductions'=> function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'otherPayments'=> function ($query) use ($first_date)
						{
							$query->where('first_date', $first_date);
						},
						'overtimes'=> function ($query) use ($selected_date)
						{
							$query->where('month_year', $selected_date);
						},
						'payslips' => function ($query) use ($selected_date)
						{
							$query->where('month_year', $selected_date);
						},
						'employeeAttendance' => function ($query) use ($first_date, $last_date){
							$query->whereBetween('attendance_date', [$first_date, $last_date]);
						}])
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type','pension_type','pension_amount')
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
						'commissions'=> function ($query) use ($first_date)
                        {
                            $query->where('first_date', $first_date);
                        },
						'loans'=> function ($query) use ($first_date)
						{
							$query->where('first_date','<=', $first_date)
							->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'deductions'=> function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'otherPayments'=> function ($query) use ($first_date)
						{
							$query->where('first_date', $first_date);
						},
						'overtimes'=> function ($query) use ($selected_date)
						{
							$query->where('month_year', $selected_date);
						},
						'payslips' => function ($query) use ($selected_date)
						{
							$query->where('month_year', $selected_date);
						},
						'employeeAttendance' => function ($query) use ($first_date, $last_date){
							$query->whereBetween('attendance_date', [$first_date, $last_date]);
						}])
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type','pension_type','pension_amount')
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

                        //Pension Amount
                        if ($row->pension_type=="percentage") {
                            $pension_amount =  ($basicsalary * $row->pension_amount) /100;
                        } else {
                            $pension_amount = $row->pension_amount;
                        }

                        $type              = "getAmount";
						$allowance_amount  = $this->allowances($row, $first_date, $type);
						$deduction_amount  = $this->deductions($row, $first_date, $type);

						//Net Salary
						if ($payslip_type == 'Monthly'){
							$total_salary = $this->totalSalary($row, $payslip_type, $basicsalary, $allowance_amount, $deduction_amount, $pension_amount);
						}
						else{
							$total = 0;
							$total_hours = $this->totalWorkedHours($row);

							sscanf($total_hours, '%d:%d', $hour, $min);
							//converting in minute
							$total += $hour * 60 + $min;
							$total_salary = $this->totalSalary($row, $payslip_type, $basicsalary, $allowance_amount, $deduction_amount, $pension_amount, $total);
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
			'commissions'=> function ($query) use ($first_date)
            {
                $query->where('first_date', $first_date);
            },
			'loans'=> function ($query) use ($first_date)
            {
                $query->where('first_date','<=', $first_date)
                ->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
            },
			'deductions'=> function ($query)
			{
				$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
			},
			'otherPayments'=> function ($query) use ($first_date)
			{
				$query->where('first_date', $first_date);
			},
			'overtimes'=> function ($query) use ($month_year)
			{
				$query->where('month_year', $month_year);
			},
			'designation', 'department', 'user',
			'employeeAttendance' => function ($query) use ($first_date, $last_date){
				$query->whereBetween('attendance_date', [$first_date, $last_date]);
			}])
			->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type','pension_type','pension_amount', 'designation_id', 'department_id', 'joining_date')
			->findOrFail($request->id);

		//payslip_type && salary_basic
		foreach ($employee->salaryBasic as $salaryBasic) {
			if($salaryBasic->first_date <= $first_date){
				$basic_salary = $salaryBasic->basic_salary;
				$payslip_type = $salaryBasic->payslip_type;
			}
		}

        //Pension Amount
        if ($employee->pension_type=="percentage") {
            $pension_amount =  ($basic_salary * $employee->pension_amount) /100.00;
        } else {
            $pension_amount = $employee->pension_amount;
        }


        $type          = "getArray";
        $allowances    = $this->allowances($employee, $first_date, $type);
        $deductions    = $this->deductions($employee, $first_date, $type);
		$data = [];
		// $data['basic_salary'] = $employee->basic_salary; //will be deleted----
		// $data['basic_total'] = $employee->basic_salary; //will be deleted----
		// $data['allowances'] = $employee->allowances; //will be deleted----
		// $data['commissions']  = $employee->commissions; //will be deleted----
		// $data['deductions']   = $employee->deductions; //will be deleted----
		// $data['other_payments'] = $employee->otherPayments; //will be deleted----
		$data['basic_salary'] = $basic_salary; //----New Correction ---
		$data['basic_total']  = $basic_salary; //----New Correction ---
		$data['allowances']   = $allowances;  //----New Correction ---
		$data['commissions']  = $employee->commissions;
		$data['loans']        = $employee->loans;
		$data['deductions']   = $deductions; //----New Correction ---
		$data['overtimes']    = $employee->overtimes;
		$data['other_payments'] = $employee->otherPayments;
		$data['pension_type']   = $employee->pension_type;
        $data['pension_amount'] = $pension_amount; //----New Added ---

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
			'commissions'=> function ($query) use ($first_date)
            {
                $query->where('first_date', $first_date);
            },
			'loans'=> function ($query) use ($first_date)
            {
                $query->where('first_date','<=', $first_date)
                ->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
            },
			'deductions' => function ($query)
			{
				$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
			},
			'otherPayments'=> function ($query) use ($first_date)
			{
				$query->where('first_date', $first_date);
			},
			'overtimes'=> function ($query) use ($month_year)
			{
				$query->where('month_year', $month_year);
			},
			'designation', 'department', 'user',
			'employeeAttendance' => function ($query) use ($first_date, $last_date){
				$query->whereBetween('attendance_date', [$first_date, $last_date]);
			}])
			->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type', 'designation_id', 'department_id', 'joining_date','pension_type','pension_amount')
			->findOrFail($request->id);


		//payslip_type & basic_salary
		foreach ($employee->salaryBasic as $salaryBasic) {
			if($salaryBasic->first_date <= $first_date)
			{
				$basic_salary = $salaryBasic->basic_salary;
				$payslip_type = $salaryBasic->payslip_type;
			}
		}

        //Pension Amount
        if ($employee->pension_type=="percentage") {
            $pension_amount =  ($basic_salary * $employee->pension_amount) /100;
        } else {
            $pension_amount = $employee->pension_amount;
        }

		//allowance
		// $allowance_amount = 0;
		// if (!$employee->allowances->isEmpty()) {
		// 	foreach($employee->allowances as $item) {
		// 		if($item->first_date <= $first_date){
		// 			$allowance_amount = SalaryAllowance::where('month_year',$item->month_year)->where('employee_id',$item->employee_id)->sum('allowance_amount');
		// 		}
		// 	}
		// }

		$type              = "getAmount";
        $allowance_amount  = $this->allowances($employee, $first_date, $type);
        $deduction_amount  = $this->deductions($employee, $first_date, $type);

		$data = [];
		$data['employee']         = $employee->id;
		$data['basic_salary']     = $basic_salary; //----New Correction ---
		$data['total_allowance']  = $allowance_amount; //----New Correction ---
		$data['total_commission'] = $employee->commissions->sum('commission_amount');
		$data['monthly_payable']  = $employee->loans->sum('monthly_payable');
		$data['amount_remaining'] = $employee->loans->sum('amount_remaining');
		$data['total_deduction']  = $deduction_amount; //----New Correction ---
		$data['total_overtime']   = $employee->overtimes->sum('overtime_amount');
		$data['total_other_payment'] =$employee->otherPayments->sum('other_payment_amount');
		$data['payslip_type']     = $payslip_type;
		$data['pension_amount']  = $pension_amount;

		if ($payslip_type == 'Monthly') //----New Correction ---
		{
			// $data['total_salary'] = $this->totalSalary($employee); //will be deleted----
			$data['total_salary'] = $this->totalSalary($employee, $payslip_type, $basic_salary,$allowance_amount, $deduction_amount ,$pension_amount);
		} else
		{
			$total = 0;
			$total_hours = $this->totalWorkedHours($employee);
			sscanf($total_hours, '%d:%d', $hour, $min);
			//converting in minute
			$total += $hour * 60 + $min;
			$data['total_hours'] = $total_hours;
			$data['worked_amount'] = ($data['basic_salary'] / 60) * $total;
			$data['total_salary'] = $this->totalSalary($employee,$payslip_type, $basic_salary, $allowance_amount, $deduction_amount, $pension_amount, $total);
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
						'commissions'=> function ($query) use ($first_date)
                        {
                            $query->where('first_date', $first_date);
                        },
						// 'allowances:id,employee_id,allowance_title,allowance_amount',
						// 'commissions:id,employee_id,commission_title,commission_amount',
						// 'deductions:id,employee_id,deduction_title,deduction_amount',
						// 'otherPayments:id,employee_id,other_payment_title,other_payment_amount'
						// 'overtimes:id,employee_id,overtime_title,no_of_days,overtime_hours,overtime_rate,overtime_amount'
						// 'loans:id,employee_id,loan_title,loan_amount,time_remaining,amount_remaining,monthly_payable',
                        'loans'=> function ($query) use ($first_date)
                        {
                            $query->where('first_date','<=', $first_date)
                            ->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
                        },'deductions' => function ($query)
						{
							$query->orderByRaw('DATE_FORMAT(first_date, "%y-%m")');
						},
						'otherPayments'=> function ($query) use ($first_date)
                        {
                            $query->where('first_date', $first_date);
                        },
						'overtimes'=> function ($query) use ($first_date)
						{
							$query->where('first_date', $first_date);
						}])
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type','pension_type','pension_amount')
						->findOrFail($id);


                    $type          = "getArray";
                    $allowances    = $this->allowances($employee, $first_date, $type); //getArray
                    $deductions    = $this->deductions($employee, $first_date, $type);

					$data = [];
					$data['payslip_key'] = Str::random('20');
					$data['payslip_number'] = mt_rand(1000000000,9999999999);
					// $data['payment_type'] = $employee->payslip_type; //will be deleted----
					// $data['basic_salary'] = $employee->basic_salary; //will be deleted----
					// $data['allowances'] = $employee->allowances; //will be deleted----
					//$data['commissions'] = $employee->commissions; //will be deleted----
					//$data['deductions'] = $employee->deductions; //will be deleted----
					//$data['other_payments'] = $employee->otherPayments; //will be deleted----

					$data['payment_type'] = $request->payslip_type; //----New Correction ---
					$data['basic_salary'] = $request->basic_salary; //----New Correction ---
					$data['allowances']  = $allowances; //----New Correction ---
					$data['commissions'] = $employee->commissions;
					$data['loans'] = $employee->loans;
					$data['deductions'] = $deductions; //----New Correction ---
					$data['overtimes'] = $employee->overtimes;
					$data['other_payments'] = $employee->otherPayments;
					$data['month_year'] = $request->month_year;
					$data['net_salary'] = $request->net_salary;
					$data['status'] = 1;
					$data['employee_id'] = $employee->id;
					$data['hours_worked'] = $request->worked_hours;
					$data['pension_amount'] = $request->pension_amount;

					if ($data['payment_type'] == NULL) { //No Need This Line
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




    protected function allowances($employee, $first_date, $type)
    {
        if ($type=="getArray") {
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
            return $allowances;
        }
        elseif ($type=="getAmount") {
            $allowance_amount = 0;
            if (!$employee->allowances->isEmpty()) {
                foreach($employee->allowances as $item) {
                    if($item->first_date <= $first_date){
                        // $allowance_amount = SalaryAllowance::where('month_year',$item->month_year)->where('employee_id',$item->employee_id)->sum('allowance_amount');
                        $allowance_amount = 0;
                        foreach($employee->allowances as $value) {
                            if($value->first_date <= $first_date){
                                if ($item->first_date == $value->first_date) {
                                    $allowance_amount += $value->allowance_amount;
                                }
                            }
                        }
                    }
                }
            }

            return $allowance_amount;
        }

    }

    protected function commissions($employee, $first_date, $type)
    {
        if ($type=="getAmount") {
            $commission_amount = 0;
            if (!$employee->commissions->isEmpty()) {
                foreach($employee->commissions as $item) {
                    if($item->first_date <= $first_date){
                        $commission_amount = 0;
                        foreach($employee->commissions as $value) {
                            if($value->first_date <= $first_date){
                                if ($item->first_date == $value->first_date) {
                                    $commission_amount += $value->commission_amount;
                                }
                            }
                        }
                    }
                }
            }
            return $commission_amount;
        }
        elseif($type=="getArray") {
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
            return $commissions;
        }
    }

    protected function deductions($employee, $first_date ,$type)
    {
        if ($type=="getAmount") {
            $deduction_amount = 0;
            if (!$employee->deductions->isEmpty()) {
                foreach($employee->deductions as $item) {
                    if($item->first_date <= $first_date){
                        $deduction_amount = 0;
                        foreach($employee->deductions as $value) {
                            if($value->first_date <= $first_date){
                                if ($item->first_date == $value->first_date) {
                                    $deduction_amount += $value->deduction_amount;
                                }
                            }
                        }
                    }
                }
            }
            return $deduction_amount;
        }
        elseif($type=="getArray") {
            if (!$employee->deductions->isEmpty()) {
                foreach($employee->deductions as $item) {
                    if($item->first_date <= $first_date){
                        $deductions = array();
                        foreach($employee->deductions as $key => $value) {
                            if($value->first_date <= $first_date){
                                if ($item->first_date == $value->first_date) {
                                    $deductions[] =  $employee->deductions[$key];
                                }
                            }
                        }

                    }
                }
            }else {
                $deductions = [];
            }
            return $deductions;
        }
    }

    protected function otherPayments($employee, $first_date, $type)
    {
        if ($type=="getAmount") {
            $other_payment_amount = 0;
            if (!$employee->otherPayments->isEmpty()) {
                foreach($employee->otherPayments as $item) {
                    if($item->first_date <= $first_date){
                        $other_payment_amount = 0;
                        foreach($employee->otherPayments as $value) {
                            if($value->first_date <= $first_date){
                                if ($item->first_date == $value->first_date) {
                                    $other_payment_amount += $value->other_payment_amount;
                                }
                            }
                        }
                    }
                }
            }
            return $other_payment_amount;
        }
        elseif($type=="getArray") {
            if (!$employee->otherPayments->isEmpty()) {
                foreach($employee->otherPayments as $item) {
                    if($item->first_date <= $first_date){
                        $otherPayments = array();
                        foreach($employee->otherPayments as $key => $value) {
                            if($value->first_date <= $first_date){
                                if ($item->first_date == $value->first_date) {
                                    $otherPayments[] =  $employee->otherPayments[$key];
                                }
                            }
                        }

                    }
                }
            }else {
                $otherPayments = [];
            }
            return $otherPayments;
        }
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

