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


class PayrollController extends Controller {

	//
	use TotalSalaryTrait;
	use MonthlyWorkedHours;

	public function index(Request $request)
	{

		$logged_user = auth()->user();
		$companies = company::all();

		$selected_date = empty($request->filter_month_year) ? now()->format('F-Y') : $request->filter_month_year ;


		if ($logged_user->can('view-paylist'))
		{
			if (request()->ajax())
			{

				if (!empty($request->filter_company && $request->filter_department))
				{

					$employees = Employee::with(['allowances', 'loans', 'deductions', 'commissions', 'overtimes', 'otherPayments',
						'payslips' => function ($query) use ($selected_date)
						{
							$query->where('month_year', $selected_date);
						}])
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
						->where('company_id', $request->filter_company)
						->where('department_id', $request->filter_department)
						->get();

				} elseif (!empty($request->filter_company))
				{
					$employees = Employee::with(['allowances', 'loans', 'deductions', 'commissions', 'overtimes', 'otherPayments',
						'payslips' => function ($query) use ($selected_date)
						{
							$query->where('month_year', $selected_date);
						}])
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
						->where('company_id', $request->filter_company)
						->get();
				} else
				{
					$employees = Employee::with(['allowances', 'loans', 'deductions',
						'commissions', 'overtimes', 'otherPayments',
						'payslips' => function ($query) use ($selected_date)
						{
							$query->where('month_year', $selected_date);
						}])
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')->get();
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
					->addColumn('net_salary', function ($row)
					{
						if ($row->payslip_type == 'Monthly')
						{
							$total_salary = $this->totalSalary($row);
						} else
						{
							$total = 0;
							$total_hours = $this->totalWorkedHours($row);

							sscanf($total_hours, '%d:%d', $hour, $min);
							//converting in minute
							$total += $hour * 60 + $min;
							$total_salary = $this->totalSalary($row, $total);
						}

						return $total_salary;

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
							$button = '<button type="button" name="view" id="' . $data->id . '" class="details btn btn-primary btn-sm"><i class="dripicons-preview"></i></button>';
							$button .= '&nbsp;&nbsp;';
							$status = 0;
							$payslip_key = 0;
							foreach ($data->payslips as $payslip)
							{
								$payslip_key = $payslip->payslip_key;
								$status = $payslip->status;
							}
							if ($status == 1)
							{
								$button .= '<a id="' . $payslip_key . '" class="payslip btn btn-info btn-sm" href="' . route('payslip_details.show', $payslip_key) . '"><i class="dripicons-user-id"></i></a>';
								$button .= '&nbsp;&nbsp;';
								$button .= '<a id="' . $payslip_key . '" class="download btn btn-info btn-sm" href="' . route('payslip.pdf', $payslip_key) . '"><i class="dripicons-download"></i></a>';
							} else
							{
								if (auth()->user()->can('make-payment'))
								{
									$button .= '<button type="button" name="payment" id="' . $data->id . '" class="generate_payment btn btn-secondary btn-sm"><i class="fa fa-money"></i></button>';
								} else
								{
									$button = '';
								}
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

	public function paySlip($id)
	{

		$employee = Employee::with('allowances', 'loans', 'deductions', 'commissions', 'overtimes', 'otherPayments', 'designation', 'department', 'user')
			->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type', 'designation_id', 'department_id', 'joining_date')
			->findOrFail($id);

		$data = [];
		$data['basic_salary'] = $employee->basic_salary;
		$data['basic_total'] = $employee->basic_salary;
		$data['allowances'] = $employee->allowances;
		$data['commissions'] = $employee->commissions;
		$data['loans'] = $employee->loans;
		$data['deductions'] = $employee->deductions;
		$data['overtimes'] = $employee->overtimes;
		$data['other_payments'] = $employee->otherPayments;

		$data['employee_id'] = $employee->id;
		$data['employee_full_name'] = $employee->full_name;
		$data['employee_designation'] = $employee->designation->designation_name;
		$data['employee_department'] = $employee->department->department_name;
		$data['employee_join_date'] = $employee->joining_date;
		$data['employee_username'] = $employee->user->username;
		$data['employee_pp'] = $employee->user->profile_photo ?? '';

		$data['payslip_type'] = $employee->payslip_type;

		if ($employee->payslip_type === 'Hourly')
		{
			$total = 0;
			$total_hours_worked = $this->totalWorkedHours($employee);
			$data['monthly_worked_hours'] = $total_hours_worked;
			//formatting in hour:min and separating them
			sscanf($total_hours_worked, '%d:%d', $hour, $min);
			//converting in minute
			$total += $hour * 60 + $min;

			$data['monthly_worked_amount'] = ($employee->basic_salary / 60) * $total;

			$data['basic_total'] = $data['monthly_worked_amount'];
		}


		return response()->json(['data' => $data]);

	}


	public function paySlipGenerate($id)
	{
		$employee = $employee = Employee::with('allowances', 'loans', 'deductions', 'commissions', 'overtimes', 'otherPayments', 'payslips')
			->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
			->findOrFail($id);
		$data = [];

		$data['employee'] = $employee->id;
		$data['basic_salary'] = $employee->basic_salary;
		$data['total_allowance'] = $employee->allowances->sum('allowance_amount');
		$data['total_commission'] = $employee->commissions->sum('commission_amount');
		$data['monthly_payable'] = $employee->loans->sum('monthly_payable');
		$data['amount_remaining'] = $employee->loans->sum('amount_remaining');
		$data['total_deduction'] = $employee->deductions->sum('deduction_amount');
		$data['total_overtime'] = $employee->overtimes->sum('overtime_amount');
		$data['total_other_payment'] = $employee->otherPayments->sum('other_payment_amount');
		$data['payslip_type'] = $employee->payslip_type;

		if ($employee->payslip_type == 'Monthly')
		{
			$data['total_salary'] = $this->totalSalary($employee);
		} else
		{
			$total = 0;
			$total_hours = $this->totalWorkedHours($employee);
			sscanf($total_hours, '%d:%d', $hour, $min);
			//converting in minute
			$total += $hour * 60 + $min;
			$data['total_hours'] = $total_hours;
			$data['worked_amount'] = ($data['basic_salary'] / 60) * $total;
			$data['total_salary'] = $this->totalSalary($employee, $total);
		}

		return response()->json(['data' => $data]);
	}

	public function payEmployee($id, Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('make-payment'))
		{
			DB::beginTransaction();
				try
				{
					$employee = Employee::with('allowances:id,employee_id,allowance_title,allowance_amount',
						'loans:id,employee_id,loan_title,loan_amount,time_remaining,amount_remaining,monthly_payable',
						'deductions:id,employee_id,deduction_title,deduction_amount',
						'commissions:id,employee_id,commission_title,commission_amount',
						'overtimes:id,employee_id,overtime_title,no_of_days,overtime_hours,overtime_rate,overtime_amount',
						'otherPayments:id,employee_id,other_payment_title,other_payment_amount')
						->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
						->findOrFail($id);


					$data = [];
					$data['payslip_key'] = Str::random('20');
					$data['payslip_number'] = mt_rand(1000000000,9999999999);
					$data['payment_type'] = $employee->payslip_type;
					$data['basic_salary'] = $employee->basic_salary;
					$data['allowances'] = $employee->allowances;
					$data['commissions'] = $employee->commissions;
					$data['loans'] = $employee->loans;
					$data['deductions'] = $employee->deductions;
					$data['overtimes'] = $employee->overtimes;
					$data['other_payments'] = $employee->otherPayments;
					$data['month_year'] = $request->month_year;
					$data['net_salary'] = $request->net_salary;
					$data['status'] = 1;
					$data['employee_id'] = $employee->id;

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

	// //----Old----
	// public function payBulk(Request $request)
	// {
	// 	$logged_user = auth()->user();
	// 	if ($logged_user->can('make-bulk_payment'))
	// 	{
	// 		if (request()->ajax())
	// 		{

	// 			$paid_employee = Payslip::where('month_year', $request->month_year)->pluck('employee_id');

	// 			if (!empty($request->filter_company && $request->filter_department))
	// 			{
	// 				$employees = Employee::with('allowances:id,employee_id,allowance_title,allowance_amount',
	// 					'loans:id,employee_id,loan_title,loan_amount',
	// 					'deductions:id,employee_id,deduction_title,deduction_amount',
	// 					'commissions:id,employee_id,commission_title,commission_amount',
	// 					'overtimes:id,employee_id,overtime_title,no_of_days,overtime_hours,overtime_rate,overtime_amount',
	// 					'otherPayments:id,employee_id,other_payment_title,other_payment_amount'
	// 				)
	// 					->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
	// 					->where('company_id', $request->filter_company)
	// 					->where('department_id', $request->filter_department)
	// 					->whereNotIn('id', $paid_employee)
	// 					->get();
	// 			} elseif (!empty($request->filter_company))
	// 			{
	// 				$employees = Employee::with('allowances:id,employee_id,allowance_title,allowance_amount',
	// 					'loans:id,employee_id,loan_title,loan_amount',
	// 					'deductions:id,employee_id,deduction_title,deduction_amount',
	// 					'commissions:id,employee_id,commission_title,commission_amount',
	// 					'overtimes:id,employee_id,overtime_title,no_of_days,overtime_hours,overtime_rate,overtime_amount',
	// 					'otherPayments:id,employee_id,other_payment_title,other_payment_amount'
	// 				)
	// 					->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
	// 					->where('company_id', $request->filter_company)
	// 					->whereNotIn('id', $paid_employee)
	// 					->get();
	// 			} else
	// 			{
	// 				$employees = Employee::with('allowances:id,employee_id,allowance_title,allowance_amount',
	// 					'loans:id,employee_id,loan_title,loan_amount',
	// 					'deductions:id,employee_id,deduction_title,deduction_amount',
	// 					'commissions:id,employee_id,commission_title,commission_amount',
	// 					'overtimes:id,employee_id,overtime_title,no_of_days,overtime_hours,overtime_rate,overtime_amount',
	// 					'otherPayments:id,employee_id,other_payment_title,other_payment_amount'
	// 				)
	// 					->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
	// 					->whereNotIn('id', $paid_employee)
	// 					->get();
	// 			}


	// 			if ($employees->isEmpty())
	// 			{
	// 				return response()->json(['error' => 'Selected Employees are already Paid']);
	// 			}


	// 			DB::beginTransaction();
	// 				try
	// 				{
	// 					$total_sum = 0;
	// 					foreach ($employees as $employee)
	// 					{
	// 						if ($employee->payslip_type == 'Monthly')
	// 						{
	// 							$net_salary = $this->totalSalary($employee);
	// 						} else
	// 						{
	// 							$total = 0;
	// 							$total_hours = $this->totalWorkedHours($employee);
	// 							sscanf($total_hours, '%d:%d', $hour, $min);
	// 							//converting in minute
	// 							$total += $hour * 60 + $min;
	// 							$net_salary = $this->totalSalary($employee, $total);
	// 						}
	// 						$data = [];
	// 						$data['payslip_key'] = Str::random('20');
	// 						$data['payment_type'] = $employee->payslip_type;
	// 						$data['basic_salary'] = $employee->basic_salary;
	// 						$data['allowances'] = $employee->allowances;
	// 						$data['commissions'] = $employee->commissions;
	// 						$data['loans'] = $employee->loans;
	// 						$data['deductions'] = $employee->deductions;
	// 						$data['overtimes'] = $employee->overtimes;
	// 						$data['other_payments'] = $employee->otherPayments;
	// 						$data['month_year'] = $request->month_year;
	// 						$data['net_salary'] = $net_salary;
	// 						$data['status'] = 1;
	// 						$data['employee_id'] = $employee->id;

	// 						$total_sum = $total_sum + $net_salary;

	// 						if ($employee->loans)
	// 						{
	// 							foreach ($employee->loans as $loan)
	// 							{
	// 								if($loan->time_remaining === '0')
	// 								{
	// 									$amount_remaining = 0;
	// 									$time_remaining = 0;
	// 									$monthly_payable = 0;
	// 								}
	// 								else
	// 								{
	// 									$amount_remaining = $loan->amount_remaining - $loan->monthly_payable;
	// 									$time_remaining = $loan->time_remaining - 1;
	// 									$monthly_payable = $loan->monthly_payable;
	// 								}
	// 								SalaryLoan::whereId($loan->id)->update(['amount_remaining' => $amount_remaining, 'time_remaining' => $time_remaining,
	// 									'monthly_payable' => $monthly_payable]);
	// 							}
	// 							$employee_loan = Employee::with('loans:id,employee_id,loan_title,loan_amount,time_remaining,amount_remaining,monthly_payable')
	// 								->select('id', 'first_name', 'last_name', 'basic_salary', 'payslip_type')
	// 								->findOrFail($employee->id);
	// 							$data['loans'] = $employee_loan->loans;
	// 						}

	// 						Payslip::create($data);

	// 					}

	// 					$account_balance = DB::table('finance_bank_cashes')->where('id', config('variable.account_id'))->pluck('account_balance')->first();

	// 					if ((int)$account_balance < $total_sum)
	// 					{
	// 						throw new Exception("requested balance is less then available balance");
	// 					}

	// 					$new_balance = (int)$account_balance - (int)$total_sum;

	// 					$finance_data = [];

	// 					$finance_data['account_id'] = config('variable.account_id');
	// 					$finance_data['amount'] = $total_sum;
	// 					$finance_data ['expense_date'] = now()->format(env('Date_Format'));
	// 					$finance_data ['expense_reference'] = trans('file.Payroll');


	// 					FinanceBankCash::whereId($finance_data['account_id'])->update(['account_balance' => $new_balance]);

	// 					$Expense = FinanceTransaction::create($finance_data);

	// 					$finance_data['id'] = $Expense->id;

	// 					FinanceExpense::create($finance_data);

	// 					DB::commit();
	// 				} catch (Exception $e)
	// 				{
	// 					DB::rollback();
	// 					return response()->json(['error' =>  $e->getMessage()]);
	// 				} catch (Throwable $e)
	// 				{
	// 					DB::rollback();
	// 					return response()->json(['error' => $e->getMessage()]);
	// 				}

	// 				return response()->json(['success' => __('Paid Successfully')]);
	// 		}
	// 	}

	// 	return response()->json(['error' => __('Error')]);
	// }
}
