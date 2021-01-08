<?php


namespace App\Http\traits;



Trait MonthlyWorkedHours {

	public function totalWorkedHours($employee)
	{
		$total = 0;
		$current_year =  date('Y');
		$current_month =  date('m');


		$att = $employee->load( ['employeeAttendance' => function ($query) use ($current_year, $current_month)
		{
			$query->whereYear('attendance_date',$current_year)->whereMonth('attendance_date',$current_month);
		},]);



		foreach ($att->employeeAttendance as $a)
		{
			sscanf($a->total_work, '%d:%d', $hour, $min);
			$total += $hour * 60 + $min;

		}

		if ($h = floor($total / 60))
		{
			$total %= 60;
		}
		$sum_total = sprintf('%02d:%02d', $h, $total);

		return $sum_total;
	}

}