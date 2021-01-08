<?php

namespace App\Http\Controllers;

use App\company;
use App\department;
use App\designation;
use App\DocumentType;
use App\Employee;
use App\Imports\UsersImport;
use App\office_shift;
use App\PaidSalary;
use App\QualificationEducationLevel;
use App\QualificationLanguage;
use App\QualificationSkill;
use App\salary;
use App\status;
use App\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Spatie\Permission\Models\Role;
use Throwable;


class EmployeeController extends Controller {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{


		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();

		if (request()->ajax())
		{
			return datatables()->of(Employee::with('department', 'designation')->orderBy('company_id'))
				->setRowId(function ($employee)
				{
					return $employee->id;
				})
				->addColumn('name', function ($row)
				{
					return $row->full_name;
				})
				->addColumn('company', function ($row)
				{
					return $row->company->company_name ?? '';
				})
				->addColumn('department', function ($row)
				{
					return $row->department->department_name ?? '';
				})
				->addColumn('designation', function ($row)
				{
					return $row->designation->designation_name ?? '';
				})
				->addColumn('action', function ($data)
				{
					$button = '';
					if (auth()->user()->can('edit-employee'))
					{
						$button .= '<a href="employees/' . $data->id . '"  class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View Details"><i class="dripicons-preview"></i></button></a>';
						$button .= '&nbsp;&nbsp;&nbsp;';
					}
					if (auth()->user()->can('delete-employee'))
					{
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete"><i class="dripicons-trash"></i></button>';
					}

					return $button;
				})
				->rawColumns(['action'])
				->make(true);
		}

		return view('employee.index', compact('companies'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('store-employee'))
		{
			if (request()->ajax())
			{
				$validator = Validator::make($request->only('first_name', 'last_name', 'email', 'contact_no', 'date_of_birth', 'gender',
					'username', 'role_users_id', 'password', 'password_confirmation', 'company_id', 'department_id', 'designation_id', 'office_shift_id'),
					[
						'first_name' => 'required',
						'last_name' => 'required',
						'email' => 'required|email|unique:users,email',
						'contact_no' => 'required|numeric|unique:users,contact_no',
						'date_of_birth' => 'required',
						'username' => 'required|unique:users,username',
						'role_users_id' => 'required',
						'password' => 'required|min:4|confirmed',
					]
				);


				if ($validator->fails())
				{
					return response()->json(['errors' => $validator->errors()->all()]);
				}

				$data = [];
				$data['first_name'] = $request->first_name;
				$data['last_name'] = $request->last_name;
				$data['date_of_birth'] = $request->date_of_birth;
				$data['gender'] = $request->gender;
				$data['department_id'] = $request->department_id;
				$data['company_id'] = $request->company_id;
				$data ['designation_id'] = $request->designation_id;
				$data ['office_shift_id'] = $request->office_shift_id;

				$data['email'] = strtolower(trim($request->email));
				$data ['role_users_id'] = $request->role_users_id;
				$data['contact_no'] = $request->contact_no;
				$data['is_active'] = 1;


				$user = [];
				$user['username'] = strtolower(trim($request->username));
				$user['email'] = strtolower(trim($request->email));
				$user['password'] = bcrypt($request->password);
				$user ['role_users_id'] = $request->role_users_id;
				$user['contact_no'] = $request->contact_no;
				$user['is_active'] = 1;

				DB::beginTransaction();
				try
				{
					$created_user = User::create($user);

					$data['id'] = $created_user->id;

					employee::create($data);

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
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param Employee $employee
	 * @return Response
	 */
	public
	function show(Employee $employee)
	{
		if (auth()->user()->can('view-details-employee'))
		{
			$companies = Company::select('id', 'company_name')->get();
			$departments = department::select('id', 'department_name')
				->where('company_id', $employee->company_id)
				->get();

			$designations = designation::select('id', 'designation_name')
				->where('department_id', $employee->department_id)
				->get();

			$office_shifts = office_shift::select('id', 'shift_name')
				->where('company_id', $employee->company_id)
				->get();

			$statuses = status::select('id', 'status_title')->get();
			$roles = Role::select('id', 'name')->get();
			$countries = DB::table('countries')->select('id', 'name')->get();
			$document_types = DocumentType::select('id', 'document_type')->get();

			$education_levels = QualificationEducationLevel::select('id', 'name')->get();
			$language_skills = QualificationLanguage::select('id', 'name')->get();
			$general_skills = QualificationSkill::select('id', 'name')->get();

			return view('employee.dashboard', compact('employee', 'countries', 'companies',
				'departments', 'designations', 'statuses', 'office_shifts', 'document_types', 'education_levels', 'language_skills', 'general_skills'));
		} else
		{
			return response()->json(['success' => __('You are not authorized')]);
		}
	}


	public
	function destroy($id)
	{
		if (!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-employee'))
		{
			DB::beginTransaction();
			try
			{
				Employee::whereId($id)->delete();
				$this->unlink($id);
				User::whereId($id)->delete();

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

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public
	function unlink($employee)
	{

		$user = User::findOrFail($employee);
		$file_path = $user->profile_photo;

		if ($file_path)
		{
			$file_path = public_path('uploads/profile_photos/' . $file_path);
			if (file_exists($file_path))
			{
				unlink($file_path);
			}
		}
	}

	public
	function delete_by_selection(Request $request)
	{
		if (!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-employee'))
		{

			$employee_id = $request['employeeIdArray'];
			$employees = Employee::whereIn('id', $employee_id);

			foreach ($employees as $employee)
			{
				$this->unlink($employee);
				User::whereId($employee)->delete();
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public
	function infoUpdate(Request $request, $employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('modify-details-employee'))
		{
			if (request()->ajax())
			{
				$validator = Validator::make($request->only('first_name', 'last_name', 'email', 'contact_no', 'date_of_birth', 'gender',
					'username', 'role_users_id', 'company_id', 'department_id', 'designation_id', 'office_shift_id', 'location_id', 'status_id',
					'marital_status', 'joining_date', 'exit_date', 'permission_role_id', 'address', 'city', 'state', 'country', 'zip_code'
				),
					[
						'first_name' => 'required',
						'last_name' => 'required',
						'email' => 'required|email|unique:users,email,' . $employee,
						'contact_no' => 'required|numeric|unique:users,contact_no,' . $employee,
						'date_of_birth' => 'required',
						'username' => 'required|unique:users,username,' . $employee,
						'role_users_id' => 'required',
						'status_id' => 'required',
					]
				);


				if ($validator->fails())
				{
					return response()->json(['errors' => $validator->errors()->all()]);
				}

				$data = [];
				$data['first_name'] = $request->first_name;
				$data['last_name'] = $request->last_name;
				$data['date_of_birth'] = $request->date_of_birth;
				$data['gender'] = $request->gender;
				$data['department_id'] = $request->department_id;
				$data['company_id'] = $request->company_id;
				$data ['designation_id'] = $request->designation_id;
				$data ['office_shift_id'] = $request->office_shift_id;
				$data['status_id'] = $request->status_id;
				$data ['marital_status'] = $request->marital_status;
				if ($request->joining_date)
				{
					$data ['joining_date'] = $request->joining_date;
				}
				if ($request->exit_date)
				{
					$data['exit_date'] = $request->exit_date;
				}
				$data ['address'] = $request->address;
				$data ['city'] = $request->city;
				$data['state'] = $request->state;
				$data ['country'] = $request->country;
				$data ['zip_code'] = $request->zip_code;


				$data['email'] = strtolower(trim($request->email));
				$data ['role_users_id'] = $request->role_users_id;
				$data['contact_no'] = $request->contact_no;
				$data['is_active'] = 1;


				$user = [];
				$user['username'] = strtolower(trim($request->username));
				$user['email'] = strtolower(trim($request->email));
				$user['password'] = bcrypt($request->password);
				$user ['role_users_id'] = $request->role_users_id;
				$user['contact_no'] = $request->contact_no;
				$user['is_active'] = 1;

				DB::beginTransaction();
				try
				{

					User::whereId($employee)->update($user);

					employee::find($employee)->update($data);

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
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public
	function socialProfileShow(Employee $employee)
	{
		return view('employee.social_profile.index', compact('employee'));
	}

	public
	function storeSocialInfo(Request $request, $employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('modify-details-employee') || $logged_user->id == $employee)
		{
			$data = [];
			$data['fb_id'] = $request->fb_id;
			$data['twitter_id'] = $request->twitter_id;
			$data['linkedIn_id'] = $request->linkedIn_id;
			$data['blogger_id'] = $request->blogger_id;
			$data ['skype_id'] = $request->skype_id;

			Employee::whereId($employee)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);

		}

		return response()->json(['success' => __('You are not authorized')]);

	}

	public
	function indexProfilePicture(Employee $employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('modify-details-employee'))
		{
			return view('employee.profile_picture.index', compact('employee'));
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public
	function storeProfilePicture(Request $request, $employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('modify-details-employee') || $logged_user->id == $employee)
		{

			$data = [];
			$photo = $request->profile_photo;
			$file_name = null;

			if (isset($photo))
			{
				$new_user = $request->employee_username;
				if ($photo->isValid())
				{
					$file_name = preg_replace('/\s+/', '', $new_user) . '_' . time() . '.' . $photo->getClientOriginalExtension();
					$photo->storeAs('profile_photos', $file_name);
					$data['profile_photo'] = $file_name;
				}
			}

			$this->unlink($employee);

			User::whereId($employee)->update($data);

			return response()->json(['success' => 'Data is successfully updated', 'profile_picture' => $file_name]);

		}

		return response()->json(['success' => __('You are not authorized')]);

	}

	public
	function setSalary(Employee $employee)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('modify-details-employee'))
		{
			return view('employee.salary.index', compact('employee'));
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public
	function storeSalary(Request $request, $employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('modify-details-employee'))
		{

			$validator = Validator::make($request->only('payslip_type', 'basic_salary'
			),
				[
					'basic_salary' => 'required|numeric',
					'payslip_type' => 'required',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			DB::beginTransaction();
			try
			{
				Employee::updateOrCreate(['id' => $employee], [
					'payslip_type' => $request->payslip_type,
					'basic_salary' => $request->basic_salary]);
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

		return response()->json(['error' => __('You are not authorized')]);
	}

	public
	function import()
	{
		if (auth()->user()->can('import-employee'))
		{
			return view('employee.import');
		}

		return abort(404, __('You are not authorized'));
	}

	public
	function importPost()
	{
		if (!env('USER_VERIFIED'))
		{
			$this->setSuccessMessage(__('This feature is disabled for demo!'));
		}
		try
		{
			Excel::queueImport(new UsersImport(), request()->file('file'));
		} catch (ValidationException $e)
		{
			$failures = $e->failures();

			return view('employee.importError', compact('failures'));
		}

		$this->setSuccessMessage(__('Imported Successfully'));

		return back();

	}

	// public function test()
	// {
	// 	return "OK";
	// }


}
