<?php

namespace App\Imports;

use App\Employee;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel,WithHeadingRow, ShouldQueue,WithChunkReading,WithBatchInserts, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

	use Importable;

    public function model(array $row)
	{
		$joining_date = date('Y-m-d',strtotime($row['date_of_joining']));
		$date_of_birth = date('Y-m-d',strtotime($row['date_of_birth']));


		$user = User::create([
			//
			'username' => $row['username'],
			'email' => $row['email'],
			'password' => Hash::make($row['password']),
			'contact_no' => $row['contact_no'],
			'role_users_id' => 2
		]);

		return new Employee([
			//
			'id' => $user->id,
			'first_name' => $row['first_name'],
			'last_name' => $row['last_name'],
			'email' => $row['email'],
			'contact_no' => $row['contact_no'],
			'joining_date' => $joining_date,
			'date_of_birth' => $date_of_birth,
			'gender' => $row['gender'],
			'address' => $row['address'],
			'city' => $row['city'],
			'country' => $row['country'],
			'zip_code' => $row['zip'],
			'role_users_id' => 2
		]);
	}

	public function rules(): array
	{
		return [
			'first_name' => 'required',
			'last_name' => 'required',
			'contact_no' => 'required',
			'password' => 'required',
			'email' => 'required|unique:users,email',
			'username' => 'required|unique:users,username'
		];
	}

//	public function customValidationAttributes()
//	{
//		return [
//			'email.required' => 'email',
//		];
//	}

	public function chunkSize(): int
	{
		return 500;
	}

	public function batchSize(): int
	{
		return 1000;
	}
}
