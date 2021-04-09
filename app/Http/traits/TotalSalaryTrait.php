<?php


namespace App\Http\traits;





Trait TotalSalaryTrait {



	// public function totalSalary($employee,$total_minutes =1){

	// 	if($employee->payslip_type == 'Monthly')
	// 	{
	// 		$total = $employee->basic_salary + $employee->allowances->sum('allowance_amount') + $employee->commissions->sum('commission_amount')
	// 			- $employee->loans->sum('monthly_payable') - $employee->deductions->sum('deduction_amount')
	// 			+ $employee->otherPayments->sum('other_payment_amount') + $employee->overtimes->sum('overtime_amount');
	// 	}
	// 	else
	// 	{

	// 		$total =  ($employee->basic_salary / 60) * $total_minutes + $employee->allowances->sum('allowance_amount') + $employee->commissions->sum('commission_amount')
	// 			- $employee->loans->sum('monthly_payable') - $employee->deductions->sum('deduction_amount')
	// 			+ $employee->otherPayments->sum('other_payment_amount') + $employee->overtimes->sum('overtime_amount');
	// 	}
	// 	return $total;
	// }
	public function totalSalary($employee, $payslip_type , $basic_salary, $allowance_amount, $commission_amount, $total_minutes =1){

		if($payslip_type == 'Monthly')
		{
			$total = $basic_salary + $allowance_amount + $commission_amount
				- $employee->loans->sum('monthly_payable') - $employee->deductions->sum('deduction_amount')
				+ $employee->otherPayments->sum('other_payment_amount') + $employee->overtimes->sum('overtime_amount');
		}
		else
		{

			$total =  ($basic_salary / 60) * $total_minutes +  $allowance_amount + $commission_amount
				- $employee->loans->sum('monthly_payable') - $employee->deductions->sum('deduction_amount')
				+ $employee->otherPayments->sum('other_payment_amount') + $employee->overtimes->sum('overtime_amount');
		}
		return $total;
	}

}