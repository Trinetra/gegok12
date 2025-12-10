<?php
/**
 * SPDX-License-Identifier: MIT
 * (c) 2025 GegoSoft Technologies and GegoK12 Contributors
 */

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $first = $this->faker->firstName;
        $last  = $this->faker->lastName;
        $uniqueId = $this->faker->unique()->numberBetween(1000, 9999);

        return [
            'name' => $first . ' ' . $last . $uniqueId,
            'email' => strtolower($first . $last . $uniqueId) . '@mailinator.com',
            'mobile_no' => $this->faker->unique()->randomNumber($nbDigits = 9, $strict = false),
            'password' => bcrypt('password'),
            'email_verification_code' => str_random(40),
            'registration_number' => $this->faker->unique()->randomNumber($nbDigits = 6, $strict = false),
            'remember_token' => str_random(10),
            'status' => 'active',
            'email_verified' => true,
            'email_verified_at' => Carbon::now(),
        ];
    }

    /**
     * State: School Admin
     */
    public function schoolAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'usergroup_id' => User::SCHOOLADMIN_USERGROUP_ID,
            ];
        });
    }

    /**
     * State: Librarian
     */
    public function librarian()
    {
        return $this->state(function (array $attributes) {
            return [
                'usergroup_id' => User::LIBRARIAN_USERGROUP_ID,
            ];
        });
    }

    /**
     * State: Student
     */
    public function student()
    {
        return $this->state(function (array $attributes) {
            return [
                'usergroup_id' => User::STUDENT_USERGROUP_ID,
            ];
        });
    }

    /**
     * State: Teacher
     */
    public function teacher()
    {
        return $this->state(function (array $attributes) {
            return [
                'usergroup_id' => User::TEACHER_USERGROUP_ID,
            ];
        });
    }

    /**
     * State: Accountant
     */
    public function accountant()
    {
        return $this->state(function (array $attributes) {
            return [
                'usergroup_id' => User::ACCOUNTANT_USERGROUP_ID,
            ];
        });
    }

    /**
     * State: Parent
     */
    public function parent()
    {
        return $this->state(function (array $attributes) {
            return [
                'usergroup_id' => User::PARENT_USERGROUP_ID,
            ];
        });
    }

    /**
     * State: Receptionist
     */
    public function receptionist()
    {
        return $this->state(function (array $attributes) {
            return [
                'usergroup_id' => User::RECEPTIONIST_USERGROUP_ID,
            ];
        });
    }

    /**
     * State: Stock Keeper
     */
    public function stockKeeper()
    {
        return $this->state(function (array $attributes) {
            return [
                'usergroup_id' => User::STOCK_KEEPER_USERGROUP_ID,
            ];
        });
    }
}
