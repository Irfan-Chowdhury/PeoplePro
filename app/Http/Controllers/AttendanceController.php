<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\company;
use App\Employee;
use App\Holiday;
use App\Imports\AttendancesImport;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

use App\Http\traits\MonthlyWorkedHours;

class AttendanceController extends Controller {

	use MonthlyWorkedHours;

	public $date_attendance = [];
	public $date_range = [];
	public $work_days = 0;

	public function index(Request $request)
	{


		$logged_user = auth()->user();
		//checking if date is selected else date is current
		if ($logged_user->can('view-attendance'))
		{
			$selected_date = Carbon::parse($request->filter_month_year)->format('Y-m-d') ?? now()->format('Y-m-d');

			$day = strtolower(Carbon::parse($request->filter_month_year)->format('l')) . '_in' ?? strtolower(now()->format('l')) . '_in';


			if (request()->ajax())
			{
				//employee attendance of selected date
				$employee = Employee::with(['officeShift', 'employeeAttendance' => function ($query) use ($selected_date)
					{
						$query->where('attendance_date', $selected_date);
					},
						'officeShift',
						'company:id,company_name',
						'employeeLeave' => function ($query) use ($selected_date)
						{
							$query->where('start_date', '>=', $selected_date)
								->where('end_date', '<=', $selected_date);
						}]
				)
					->select('id', 'company_id', 'first_name', 'last_name', 'office_shift_id')
					->where('joining_date', '<=', $selected_date)
					->get();


				$holidays = Holiday::select('id', 'company_id', 'start_date', 'end_date', 'is_publish')
					->where('start_date', '<=', $selected_date)
					->where('end_date', '>=', $selected_date)
					->where('is_publish', '=', 1)->first();


				return datatables()->of($employee)
					->setRowId(function ($employee)
					{
						return $employee->id;
					})
					->addColumn('employee_name', function ($employee)
					{
						return $employee->full_name;
					})
					->addColumn('company', function ($employee)
					{
						return $employee->company->company_name;
					})
					->addColumn('attendance_date', function ($employee) use ($selected_date)
					{
						//if there is no employee attendance
						if ($employee->employeeAttendance->isEmpty())
						{
							return Carbon::parse($selected_date)->format(env('Date_Format'));
						} else
						{
							//if there are employee attendance,get the first record
							$attendance_row = $employee->employeeAttendance->first();

							return $attendance_row->attendance_date;
						}
					})
					->addColumn('attendance_status', function ($employee) use ($holidays, $day)
					{
						//if there are employee attendance,get the first record
						if ($employee->employeeAttendance->isEmpty())
						{
							if (is_null($employee->officeShift->$day ?? null))
							{
								return __('Off Day');
							}

							if ($holidays)
							{
								if ($employee->company_id === $holidays->company_id)
								{
									return trans('file.Holiday');
								}
							}


							if ($employee->employeeLeave->isEmpty())
							{
								return trans('file.Absent');
							}

							return __('On leave');

						} else
						{
							$attendance_row = $employee->employeeAttendance->first();

							return $attendance_row->attendance_status;
						}
					})
					->addColumn('clock_in', function ($employee)
					{
						if ($employee->employeeAttendance->isEmpty())
						{
							return '---';
						} else
						{
							$attendance_row = $employee->employeeAttendance->first();

							return $attendance_row->clock_in;
						}
					})
					->addColumn('clock_out', function ($employee)
					{
						if ($employee->employeeAttendance->isEmpty())
						{
							return '---';
						} else
						{
							$attendance_row = $employee->employeeAttendance->last();

							return $attendance_row->clock_out;
						}
					})
					->addColumn('time_late', function ($employee)
					{
						if ($employee->employeeAttendance->isEmpty())
						{
							return '---';
						} else
						{
							$attendance_row = $employee->employeeAttendance->first();

							return $attendance_row->time_late;
						}
					})
					->addColumn('early_leaving', function ($employee)
					{
						if ($employee->employeeAttendance->isEmpty())
						{
							return '---';
						} else
						{
							$attendance_row = $employee->employeeAttendance->last();

							return $attendance_row->early_leaving;
						}
					})
					->addColumn('overtime', function ($employee)
					{
						if ($employee->employeeAttendance->isEmpty())
						{
							return '---';
						} else
						{

							$total = 0;
							foreach ($employee->employeeAttendance as $attendance_row)
							{
								sscanf($attendance_row->overtime, '%d:%d', $hour, $min);
								$total += $hour * 60 + $min;
							}
							if ($h = floor($total / 60))
							{
								$total %= 60;
							}

							return sprintf('%02d:%02d', $h, $total);
						}
					})
					->addColumn('total_work', function ($employee)
					{
						if ($employee->employeeAttendance->isEmpty())
						{
							return '---';
						} else
						{
							$total = 0;
							foreach ($employee->employeeAttendance as $attendance_row)
							{
								sscanf($attendance_row->total_work, '%d:%d', $hour, $min);
								$total += $hour * 60 + $min;
							}
							if ($h = floor($total / 60))
							{
								$total %= 60;
							}

							return sprintf('%02d:%02d', $h, $total);
						}
					})
					->addColumn('total_rest', function ($employee)
					{
						if ($employee->employeeAttendance->isEmpty())
						{
							return '---';
						} else
						{
							$total = 0;
							foreach ($employee->employeeAttendance as $attendance_row)
							{
								//formatting in hour:min and separating them
								sscanf($attendance_row->total_rest, '%d:%d', $hour, $min);
								//converting in minute
								$total += $hour * 60 + $min;
							}
							// if minute is greater than hour then $h= hour
							if ($h = floor($total / 60))
							{
								$total %= 60;
							}

							//returning back to hour:minute format
							return sprintf('%02d:%02d', $h, $total);
						}
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('timesheet.attendance.attendance');
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


	public function employeeAttendance(Request $request, $id)
	{


		$data = [];

		//current day
		$current_day = now()->format(env('Date_Format'));

		//getting the latest instance of employee_attendance
		$employee_attendance_last = Attendance::where('attendance_date', now()->format('Y-m-d'))
				->where('employee_id', $id)->orderBy('id', 'desc')->first() ?? null;



		//shift in-shift out timing
		try
		{
			$shift_in = new DateTime($request->office_shift_in);
			$shift_out = new DateTime($request->office_shift_out);
			$current_time = new DateTime(now());

		} catch (Exception $e)
		{
			return $e;
		}

		$data['employee_id'] = $id;
		$data['attendance_date'] = $current_day;


		//if employee attendance record was not found
		// FOR CLOCK IN
		if (!$employee_attendance_last)
		{
			// if employee is late
			if ($current_time > $shift_in)
			{
				$timeDifference = $shift_in->diff($current_time)->format('%H:%I');
				$data['clock_in'] = $current_time->format('H:i');
				$data['time_late'] = $timeDifference;
			} // if employee is early or on time
			else
			{
				$data['clock_in'] = $shift_in->format('H:i');
			}

			$data['attendance_status'] = 'present';
			$data['clock_in_out'] = 1;
			$data['clock_in_ip'] = $request->ip();

			//creating new attendance record

			Attendance::create($data);

			$this->setSuccessMessage(__('Clocked In Successfully'));

			return redirect()->back();
		}



		// if there is a record of employee attendance
		//FOR CLOCK OUT
		if ($employee_attendance_last)
		{
			//checking if the employee is not both clocked in + out (1)
			if ($employee_attendance_last->clock_in_out === 1)
			{
				// if employee is early leaving
				if ($current_time < $shift_out)
				{
					$timeDifference = $shift_out->diff($current_time)->format('%H:%I');
					$data['clock_out'] = $current_time->format('H:i');
					$data['early_leaving'] = $timeDifference;
				} // if employee is doing overtime
				elseif ($current_time > $shift_out)
				{
					$timeDifference = $shift_out->diff($current_time)->format('%H:%I');
					$data['clock_out'] = $current_time->format('H:i');
					$data['overtime'] = $timeDifference;
				} //if clocked out in time
				else
				{
					$data['clock_out'] = $shift_out->format('H:i');
				}

				try
				{
					// last clock in (needed for calculation of overtime after shift)
					$employee_last_clock_in = new DateTime($employee_attendance_last->clock_in);
				} catch (Exception $e)
				{
					return $e;
				}

				// if employee clocked in after shift time is over
				if ($employee_attendance_last->clock_in > $shift_out)
				{
					$data['overtime'] = $employee_last_clock_in->diff($current_time)->format('%H:%I');
				}


				$data['clock_out_ip'] = $request->ip();

				// calculating total work
				$total_work = $employee_last_clock_in->diff($current_time)->format('%H:%I');
				$data['total_work'] = $total_work;
				$data['clock_in_out'] = 0;


				//updating record
				$attendance = Attendance::findOrFail($employee_attendance_last->id);
				$attendance->update($data);
				$this->setSuccessMessage(__('Clocked Out Successfully'));

				return redirect()->back();
			}
			// if employee is both clocked in + out
			if ($employee_attendance_last->clock_in_out === 0)
			{
//				$timeDifference = $shift_in->diff($current_time)->format('%H:%I');
				// new clock in on that day
				$data['clock_in'] = $current_time->format('H:i');
				$data['clock_in_ip'] = $request->ip();
				$data['clock_in_out'] = 1;

				try
				{
					// last clock out (needed for calculation rest time)
					$employee_last_clock_out = new DateTime($employee_attendance_last->clock_out);
				} catch (Exception $e)
				{
					return $e;
				}
				// calculating total rest (last clock out ~ current clock in)
				$data['total_rest'] = $employee_last_clock_out->diff($current_time)->format('%H:%I');

				// creating new attendance
				Attendance::create($data);

				$this->setSuccessMessage(__('Clocked In Successfully'));

				return redirect()->back();
			}
		}

		return response()->json(trans('file.Success'));

	}


	public function dateWiseAttendance(Request $request)
	{

		$logged_user = auth()->user();

		if ($logged_user->can('view-attendance'))
		{
			$companies = Company::all('id', 'company_name');

			$start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
			$end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';


			if (request()->ajax())
			{
				if ($request->employee_id)
				{
					$employee = Employee::with(['officeShift', 'employeeAttendance' => function ($query) use ($start_date, $end_date)
					{
						$query->whereBetween('attendance_date', [$start_date, $end_date]);
					},
						'employeeLeave' => function ($query) use ($start_date, $end_date)
						{
							$query->where('start_date', '>=', $start_date)
								->where('end_date', '<=', $end_date);
						},
						'company:id,company_name',
						'company.companyHolidays' => function ($query) use ($start_date, $end_date)
						{
							$query->where('start_date', '>=', $start_date)
								->where('end_date', '<=', $end_date);
						}
					])
						->select('id', 'company_id', 'first_name', 'last_name', 'office_shift_id')->findOrFail($request->employee_id);


					$all_attendances_array = $employee->employeeAttendance->groupBy('attendance_date')->toArray();


					$leaves = $employee->employeeLeave;

					$shift = $employee->officeShift;

					$holidays = $employee->company->companyHolidays;


					$begin = new DateTime($start_date);
					$end = new DateTime($end_date);
					$end->modify('+1 day');

					$interval = DateInterval::createFromDateString('1 day');
					$period = new DatePeriod($begin, $interval, $end);

					$date_range = [];
					foreach ($period as $dt)
					{
						$date_range[] = $dt->format(env('Date_Format'));
					}
				} else
				{
					$date_range = [];
					$employee = null;
					$all_attendances_array = null;
					$leaves = null;
					$holidays = null;
					$shift = null;
				}




				return datatables()->of($date_range)
					->setRowId(function ($row) use ($employee)
					{
						return $employee->id;
					})
					->addColumn('employee_name', function ($row) use ($employee)
					{
						return $employee->full_name;
					})
					->addColumn('company', function ($row) use ($employee)
					{
						return $employee->company->company_name;
					})
					->addColumn('attendance_date', function ($row)
					{
						return Carbon::parse($row)->format(env('Date_Format'));
					})
					->addColumn('attendance_status', function ($row) use ($all_attendances_array, $leaves, $holidays, $shift)
					{
						$day = strtolower(Carbon::parse($row)->format('l')) . '_in';

						if (is_null($shift->$day))
						{
							return __('Off Day');
						}

						if (array_key_exists($row, $all_attendances_array))
						{
							return trans('file.present');
						} else
						{
							foreach ($leaves as $leave)
							{
								if ($leave->start_date <= $row && $leave->end_date >= $row)
								{
									return __('On Leave');
								}
							}
							foreach ($holidays as $holiday)
							{
								if ($holiday->start_date <= $row && $holiday->end_date >= $row)
								{
									return __('On Holiday');
								}
							}

							return trans('Absent');
						}
					})
					->addColumn('clock_in', function ($row) use ($all_attendances_array)
					{
						if (array_key_exists($row, $all_attendances_array))
						{

							$first = current($all_attendances_array[$row])['clock_in'];

							return $first;
						} else
						{
							return '---';
						}
					})
					->addColumn('clock_out', function ($row) use ($all_attendances_array)
					{
						if (array_key_exists($row, $all_attendances_array))
						{

							$last = end($all_attendances_array[$row])['clock_out'];

							return $last;
						} else
						{
							return '---';
						}
					})
					->addColumn('time_late', function ($row) use ($all_attendances_array)
					{
						if (array_key_exists($row, $all_attendances_array))
						{

							$first = current($all_attendances_array[$row])['time_late'];

							return $first;
						} else
						{
							return '---';
						}
					})
					->addColumn('early_leaving', function ($row) use ($all_attendances_array)
					{
						if (array_key_exists($row, $all_attendances_array))
						{

							$last = end($all_attendances_array[$row])['early_leaving'];

							return $last;
						} else
						{
							return '---';
						}
					})
					->addColumn('overtime', function ($row) use ($all_attendances_array)
					{
						if (array_key_exists($row, $all_attendances_array))
						{

							$total = 0;
							foreach ($all_attendances_array[$row] as $all_attendance_item)
							{
								sscanf($all_attendance_item['overtime'], '%d:%d', $hour, $min);
								$total += $hour * 60 + $min;
							}
							if ($h = floor($total / 60))
							{
								$total %= 60;
							}

							return sprintf('%02d:%02d', $h, $total);
						} else
						{
							return '---';
						}

					})
					->addColumn('total_work', function ($row) use ($all_attendances_array)
					{
						if (array_key_exists($row, $all_attendances_array))
						{

							$total = 0;
							foreach ($all_attendances_array[$row] as $all_attendance_item)
							{
								sscanf($all_attendance_item['total_work'], '%d:%d', $hour, $min);
								$total += $hour * 60 + $min;
							}
							if ($h = floor($total / 60))
							{
								$total %= 60;
							}

							$sum_total = 0 + $total;

							return sprintf('%02d:%02d', $h, $total);
						} else
						{
							return '---';
						}
					})
					->addColumn('total_rest', function ($row) use ($all_attendances_array)
					{
						if (array_key_exists($row, $all_attendances_array))
						{
							$total = 0;
							foreach ($all_attendances_array[$row] as $all_attendance_item)
							{
								//formatting in hour:min and separating them
								sscanf($all_attendance_item['total_rest'], '%d:%d', $hour, $min);
								//converting in minute
								$total += $hour * 60 + $min;
							}
							// if minute is greater than hour then $h= hour
							if ($h = floor($total / 60))
							{
								//$total = minute (after excluding hour)
								$total %= 60;
							}

							//returning back to hour:minute format
							return sprintf('%02d:%02d', $h, $total);
						} else
						{
							return '---';
						}
					})
					->rawColumns(['action'])
					->make(true);

			}

			return view('timesheet.dateWiseAttendance.index', compact('companies'));
		}

		return response()->json(['success' => __('You are not authorized')]);

	}


	public function monthlyAttendance(Request $request)
	{
		$logged_user = auth()->user();
		$companies = Company::all('id', 'company_name');


		$month_year = $request->filter_month_year;


		$first_date = date('Y-m-d', strtotime('first day of ' . $month_year));
		$last_date = date('Y-m-d', strtotime('last day of ' . $month_year));

		$begin = new DateTime($first_date);
		$end = new DateTime($last_date);

		$end->modify('+1 day');

		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);


		foreach ($period as $dt)
		{
			$this->date_range[] = $dt->format("d D");
			$this->date_attendance[] = $dt->format(env('Date_Format'));
		}


		if ($logged_user->can('view-attendance'))
		{
			if (request()->ajax())
			{

				if (!empty($request->filter_company && $request->filter_employee))
				{

					$employee = Employee::with(['officeShift', 'employeeAttendance' => function ($query) use ($first_date, $last_date)
					{
						$query->whereBetween('attendance_date', [$first_date, $last_date]);
					},
						'employeeLeave' => function ($query) use ($first_date, $last_date)
						{
							$query->where('start_date', '>=', $first_date)
								->where('end_date', '<=', $last_date);
						},
						'company:id,company_name',
						'company.companyHolidays' => function ($query) use ($first_date, $last_date)
						{
							$query->where('start_date', '>=', $first_date)
								->where('end_date', '<=', $last_date);
						},
					])
						->select('id', 'company_id', 'first_name', 'last_name', 'office_shift_id')
						->whereId($request->filter_employee)->get();

				} elseif (!empty($request->filter_company))
				{
					$employee = Employee::with(['officeShift', 'employeeAttendance' => function ($query) use ($first_date, $last_date)
					{
						$query->whereBetween('attendance_date', [$first_date, $last_date]);
					},
						'employeeLeave' => function ($query) use ($first_date, $last_date)
						{
							$query->where('start_date', '>=', $first_date)
								->where('end_date', '<=', $last_date);
						},
						'company:id,company_name',
						'company.companyHolidays' => function ($query) use ($first_date, $last_date)
						{
							$query->where('start_date', '>=', $first_date)
								->where('end_date', '<=', $last_date);
						},
					])
						->select('id', 'company_id', 'first_name', 'last_name', 'office_shift_id')
						->where('company_id', $request->filter_company)->get();
				} else
				{
					$employee = Employee::with(['officeShift', 'employeeAttendance' => function ($query) use ($first_date, $last_date)
					{
						$query->whereBetween('attendance_date', [$first_date, $last_date]);
					},
						'employeeLeave' => function ($query) use ($first_date, $last_date)
						{
							$query->where('start_date', '>=', $first_date)
								->where('end_date', '<=', $last_date);
						},
						'company:id,company_name',
						'company.companyHolidays' => function ($query) use ($first_date, $last_date)
						{
							$query->where('start_date', '>=', $first_date)
								->where('end_date', '<=', $last_date);
						},
					])
						->select('id', 'company_id', 'first_name', 'last_name', 'office_shift_id')->get();
				}


				return datatables()->of($employee)
					->setRowId(function ($row)
					{
						$this->work_days = 0;

						return $row->id;
					})
					->addColumn('employee_name', function ($row)
					{
						$name = $row->full_name;
						$company_name = $row->company->company_name;

						return $name . '(' . $company_name . ')';

					})
					->addColumn('day1', function ($row)
					{
						return $this->checkAttendanceStatus($row, 0);
					})
					->addColumn('day2', function ($row)
					{
						return $this->checkAttendanceStatus($row, 1);
					})
					->addColumn('day3', function ($row)
					{
						return $this->checkAttendanceStatus($row, 2);
					})
					->addColumn('day4', function ($row)
					{
						return $this->checkAttendanceStatus($row, 3);
					})
					->addColumn('day5', function ($row)
					{
						return $this->checkAttendanceStatus($row, 4);
					})
					->addColumn('day6', function ($row)
					{
						return $this->checkAttendanceStatus($row, 5);
					})
					->addColumn('day7', function ($row)
					{
						return $this->checkAttendanceStatus($row, 6);
					})
					->addColumn('day8', function ($row)
					{
						return $this->checkAttendanceStatus($row, 7);
					})
					->addColumn('day9', function ($row)
					{
						return $this->checkAttendanceStatus($row, 8);
					})
					->addColumn('day10', function ($row)
					{
						return $this->checkAttendanceStatus($row, 9);
					})
					->addColumn('day11', function ($row)
					{
						return $this->checkAttendanceStatus($row, 10);
					})
					->addColumn('day12', function ($row)
					{
						return $this->checkAttendanceStatus($row, 11);
					})
					->addColumn('day13', function ($row)
					{
						return $this->checkAttendanceStatus($row, 12);
					})
					->addColumn('day14', function ($row)
					{
						return $this->checkAttendanceStatus($row, 13);
					})
					->addColumn('day15', function ($row)
					{
						return $this->checkAttendanceStatus($row, 14);
					})
					->addColumn('day16', function ($row)
					{
						return $this->checkAttendanceStatus($row, 15);
					})
					->addColumn('day17', function ($row)
					{
						return $this->checkAttendanceStatus($row, 16);
					})
					->addColumn('day18', function ($row)
					{
						return $this->checkAttendanceStatus($row, 17);
					})
					->addColumn('day19', function ($row)
					{
						return $this->checkAttendanceStatus($row, 18);
					})
					->addColumn('day20', function ($row)
					{
						return $this->checkAttendanceStatus($row, 19);
					})
					->addColumn('day21', function ($row)
					{
						return $this->checkAttendanceStatus($row, 20);
					})
					->addColumn('day22', function ($row)
					{
						return $this->checkAttendanceStatus($row, 21);
					})
					->addColumn('day23', function ($row)
					{
						return $this->checkAttendanceStatus($row, 22);
					})
					->addColumn('day24', function ($row)
					{
						return $this->checkAttendanceStatus($row, 23);
					})
					->addColumn('day25', function ($row)
					{
						return $this->checkAttendanceStatus($row, 24);
					})
					->addColumn('day26', function ($row)
					{
						return $this->checkAttendanceStatus($row, 25);
					})
					->addColumn('day27', function ($row)
					{
						return $this->checkAttendanceStatus($row, 26);
					})
					->addColumn('day28', function ($row)
					{
						return $this->checkAttendanceStatus($row, 27);
					})
					->addColumn('day29', function ($row)
					{
						return $this->checkAttendanceStatus($row, 28);
					})
					->addColumn('day30', function ($row)
					{
						return $this->checkAttendanceStatus($row, 29);
					})
					->addColumn('day31', function ($row)
					{
						return $this->checkAttendanceStatus($row, 30);
					})
					->addColumn('worked_days', function ($row)
					{
						return $this->work_days;
					})
					->addColumn('total_worked_hours', function ($row)
					{
						return $this->totalWorkedHours($row);
					})
					->with([
						'date_range' => $this->date_range,
					])
					->make(true);
			}

			return view('timesheet.monthlyAttendance.index', compact('companies'));
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


	public function checkAttendanceStatus($emp, $index)
	{

		if (count($this->date_attendance) <= $index)
		{
			return '';
		} else
		{
			$present = $emp->employeeAttendance->where('attendance_date', $this->date_attendance[$index]);

			$leave = $emp->employeeLeave->where('start_date', '<=', $this->date_attendance[$index])
				->where('end_date', '>=', $this->date_attendance[$index]);

			$holiday = $emp->company->companyHolidays->where('start_date', '<=', $this->date_attendance[$index])
				->where('end_date', '>=', $this->date_attendance[$index]);

			$day = strtolower(Carbon::parse($this->date_attendance[$index])->format('l')) . '_in';

			if ($present->isNotEmpty())
			{
				$this->work_days++;

				return 'P';
			} elseif (is_null($emp->officeShift->$day ?? null))
			{
				return 'O';
			} elseif ($leave->isNotEmpty())
			{
				return 'L';
			} elseif ($holiday->isNotEmpty())
			{
				return 'H';
			} else
			{
				return 'A';
			}
		}
	}

	public function updateAttendance(Request $request)
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();
		if ($logged_user->can('edit-attendance'))
		{
			if (request()->ajax())
			{


				$employee_attendance = Attendance::where('employee_id', $request->employee_id)
					->where('attendance_date', Carbon::parse($request->attendance_date)->format('Y-m-d'))->get();


				return datatables()->of($employee_attendance)
					->setRowId(function ($row)
					{
						return $row->id;
					})
					->addColumn('clock_in', function ($row)
					{
						return $row->clock_in;
					})
					->addColumn('clock_out', function ($row)
					{
						return $row->clock_out;
					})
					->addColumn('total_work', function ($row)
					{
						return $row->total_work;
					})
					->addColumn('action', function ($row)
					{
						if (auth()->user()->can('user-edit'))
						{
							$button = '<button type="button" name="edit" id="' . $row->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '<br>&nbsp;&nbsp;';
							$button .= '<button type="button" name="delete" id="' . $row->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

							return $button;
						} else
						{
							return '';
						}
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('timesheet.updateAttendance.index', compact('companies'));
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	public function updateAttendanceGet($id)
	{

		$attendance = Attendance::select('id', 'clock_in', 'clock_out', 'attendance_date')
			->findOrFail($id);

		return response()->json(['data' => $attendance]);
	}

	public function updateAttendanceStore(Request $request)
	{

		$data = $this->attendanceHandler($request);

		Attendance::create($data);

		return response()->json(['success' => __('Data is successfully updated')]);
	}

	public function attendanceHandler($request)
	{
		$validator = Validator::make($request->only('attendance_date', 'clock_in', 'clock_out'),
			[
				'attendance_date' => 'required|date',
				'clock_in' => 'required',
				'clock_out' => 'required'
			]);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}

		$employee_id = $request->employee_id;
		$attendance_date = $request->attendance_date;
		$clock_in = $request->clock_in;
		$clock_out = $request->clock_out;


		try
		{
			$clock_in = new DateTime($clock_in);
			$clock_out = new DateTime($clock_out);
		} catch (Exception $e)
		{
			return $e;
		}

		$attendance_date_day = Carbon::parse($request->attendance_date)->format('l');


		$employee = Employee::with('officeShift')->findOrFail($employee_id);

		$current_day_in = strtolower($attendance_date_day) . '_in';
		$current_day_out = strtolower($attendance_date_day) . '_out';


		$shift_in = $employee->officeShift->$current_day_in;
		$shift_out = $employee->officeShift->$current_day_out;


		if ($shift_in === null)
		{

			$data['employee_id'] = $employee_id;
			$data['attendance_date'] = $attendance_date;
			$data['clock_in'] = $clock_in->format('H:i');
			$data['clock_out'] = $clock_out->format('H:i');
			$data['attendance_status'] = 'present';


			$total_work = $clock_in->diff($clock_out)->format('%H:%I');
			$data['total_work'] = $total_work;
			$data['early_leaving'] = '00:00';
			$data['time_late'] = '00:00';
			$data['overtime'] = '00:00';
			$data['clock_in_out'] = 0;

			return $data;
		}


		//shift in-shift out timing
		try
		{
			$shift_in = new DateTime($shift_in);
			$shift_out = new DateTime($shift_out);


		} catch (Exception $e)
		{
			return $e;
		}

		$data['employee_id'] = $employee_id;
		$data['attendance_date'] = $attendance_date;


		// if employee is late
		if ($clock_in > $shift_in)
		{
			$timeDifference = $shift_in->diff($clock_in)->format('%H:%I');
			$data['clock_in'] = $clock_in->format('H:i');
			$data['time_late'] = $timeDifference;
		} // if employee is early or on time
		else
		{
			$data['clock_in'] = $shift_in->format('H:i');
			$data['time_late'] = '00:00';
		}
		if ($clock_out < $shift_out)
		{

			$timeDifference = $shift_out->diff($clock_out)->format('%H:%I');
			$data['clock_out'] = $clock_out->format('H:i');
			$data['early_leaving'] = $timeDifference;
		} // if employee is doing overtime
		elseif
		($clock_out > $shift_out)
		{
			$timeDifference = $shift_out->diff($clock_out)->format('%H:%I');
			$data['clock_out'] = $clock_out->format('H:i');
			$data['overtime'] = $timeDifference;
			$data['early_leaving'] = '00:00';
		} //if clocked out in time
		else
		{
			$data['clock_out'] = $shift_out->format('H:i');
			$data['overtime'] = '00:00';
			$data['early_leaving'] = '00:00';
		}
		$data['attendance_status'] = 'present';


		$total_work = $clock_in->diff($clock_out)->format('%H:%I');
		$data['total_work'] = $total_work;
		$data['clock_in_out'] = 0;

		return $data;

	}

	public function updateAttendanceUpdate(Request $request)
	{

		$data = $this->attendanceHandler($request);

		$id = $request->hidden_id;
		//creating new attendance record
		Attendance::find($id)->update($data);

		return response()->json(['success' => __('Data is successfully updated')]);

	}

	public function updateAttendanceDelete($id)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('delete-attendance'))
		{
			Attendance::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['error' => __('You are not authorized')]);
	}


	public function import()
	{
		$logged_user = auth()->user();
		if ($logged_user->can('delete-attendance'))
		{
			return view('timesheet.attendance.import');
		}
		return abort(404,__('You are not authorized'));
	}


	public function importPost()
	{
		try
		{
			Excel::queueImport(new AttendancesImport(), request()->file('file'));
		} catch (ValidationException $e)
		{
			$failures = $e->failures();

			return view('timesheet.attendance.importError', compact('failures'));
		}
		$this->setSuccessMessage(__('Imported Successfully'));

		return back();
	}

}
