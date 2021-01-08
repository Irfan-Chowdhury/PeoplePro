<?php


namespace App\Http\traits;





Trait TotalSalaryTrait {



	public function totalSalary($employee,$total_minutes =1){

		if($employee->payslip_type == 'Monthly')
		{
			$total = $employee->basic_salary + $employee->allowances->sum('allowance_amount') + $employee->commissions->sum('commission_amount')
				- $employee->loans->sum('monthly_payable') - $employee->deductions->sum('deduction_amount')
				+ $employee->otherPayments->sum('other_payment_amount') + $employee->overtimes->sum('overtime_amount');
		}
		else
		{

			$total =  ($employee->basic_salary / 60) * $total_minutes + $employee->allowances->sum('allowance_amount') + $employee->commissions->sum('commission_amount')
				- $employee->loans->sum('monthly_payable') - $employee->deductions->sum('deduction_amount')
				+ $employee->otherPayments->sum('other_payment_amount') + $employee->overtimes->sum('overtime_amount');
		}
		return $total;
	}

}