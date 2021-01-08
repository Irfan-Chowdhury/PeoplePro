<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AssignRoleController extends Controller {

	public function update(Request $request, User $user)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('assign-role'))
		{
			$role_id = $request->only('roleId');
			if (!$role_id)
			{
				return response()->json(['success' => trans('Please assign a role')]);
			}
			$user->syncRoles($role_id);

			return response()->json(['success' => trans('Role assigned  successfully')]);
		}

		return response()->json(['error' => trans('Error')]);
	}


	public function mass_update(Request $request)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('assign-role'))
		{
			$user_id = $request['userIdArray'];
			$role = $request['mass_role'];

			if ($role)
			{
				$users = User::whereIn('id', $user_id)->get();

				foreach ($users as $user)
				{
					$user->syncRoles($role);
				}

				return response()->json(['success' => trans('Role assigned  successfully')]);

			} else
			{
				return response()->json(['error' => trans('Error')]);
			}
		} else
		{
			return response()->json(['error' => trans('Error')]);
		}
	}
}
