<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        //
		\App\Models\User::insert([[
			'username'=>'ash',
			'email'=>'ash@test.com',
			'password'=> bcrypt('admin'),
			'role_users_id'=>1,
			'contact_no'=> 1234
		],
			[
				'username'=>'rony',
				'email'=>'rony@gmail.com',
				'password'=> bcrypt('admin'),
				'role_users_id'=>2,
				'contact_no'=> 1235
			],
			[
			'username' =>'adnan',
			'email'=>'adnan@gmail.com',
			'password'=> bcrypt('admin'),
			'role_users_id'=>2,
			'contact_no'=> 1236
		]]
		);
    }
}
