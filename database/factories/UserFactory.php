<?php
namespace Database\Factories;

//use Faker\Generator as Faker;
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
        'name' => $first . ' ' . $last .$uniqueId,
        // $this->faker->unique()->userName,
        'email' => strtolower($first . $last .$uniqueId) . '@mailinator.com',
        // $this->faker->unique()->safeEmail,
        'mobile_no' => $this->faker->unique()->randomNumber($nbDigits = 9, $strict = false),
        'password' => bcrypt('password'),
        'email_verification_code' =>str_random(40),
        //'email_verified' => 1,
        //'email_verified_at' => Carbon::now(),
        'registration_number'   =>  $this->faker->unique()->randomNumber($nbDigits = 6, $strict = false),
        'remember_token' => str_random(10),
    ];


}

}