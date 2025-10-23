<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'first_name'     => $this->faker->firstName,
            'last_name'      => $this->faker->lastName,
            'username'       => $this->faker->unique()->userName,
            'email'          => $this->faker->unique()->safeEmail,
            'password'       => bcrypt('admin'), // You can also use Hash::make('admin')
            'role_users_id'  => 2,
            'is_active'      => $this->faker->boolean(90),
            'contact_no'     => $this->faker->unique()->numerify('01#########'),
        ];
    }
}
