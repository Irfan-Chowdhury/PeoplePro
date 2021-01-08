<?php

namespace App\Http\Controllers;

use App\Employee;
use App\SalaryCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaryCommissionController extends Controller
{

	public function show(Employee $employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee'))
		{
			if (request()->ajax())
			{
				return datatables()->of(SalaryCommission::where('employee_id', $employee->id)->get())
					->setRowId(function ($commission)
					{
						return $commission->id;
					})
					->addColumn('action', function ($data)
					{
						if (auth()->user()->can('modify-details-employee'))
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="commission_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="commission_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

							return $button;
						} else
						{
							return '';
						}
					})
					->rawColumns(['action'])
					->make(true);
			}
			return view('employee.salary.commission.index',compact('employee'));
		}
		return response()->json(['success' => __('You are not authorized')]);

	}

	public function store(Request $request,Employee $employee)
	{
		if (auth()->user()->can('store-details-employee'))
		{
			$validator = Validator::make($request->only( 'commission_title','commission_amount'
				),
				[
					'commission_title' => 'required',
					'commission_amount' => 'required',
				]
			);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['commission_title'] =  $request->commission_title;
			$data['employee_id'] = $employee->id;
			$data['commission_amount'] = $request->commission_amount;

			SalaryCommission::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function edit($id)
	{
		if(request()->ajax())
		{
			$data = SalaryCommission::findOrFail($id);
			return response()->json(['data' => $data]);
		}
	}

	public function update(Request $request)
	{


		if (auth()->user()->can('modify-details-employee'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only( 'commission_title','commission_amount'),
				[
					'commission_title' => 'required',
					'commission_amount' => 'required',
				]
			);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['commission_title'] =  $request->commission_title;
			$data['commission_amount'] = $request->commission_amount;

			SalaryCommission::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if (auth()->user()->can('modify-details-employee'))
		{

			SalaryCommission::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
