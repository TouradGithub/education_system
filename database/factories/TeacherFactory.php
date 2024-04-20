<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{

    protected $model = Teacher::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // You may want to use Hash::make() instead
            'current_address' => $this->faker->address,
            'permanent_address' => $this->faker->address,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'mobile' => $this->faker->phoneNumber,
            'image' => null, // You may customize this based on your needs
            'dob' => $this->faker->date,
            'qualification' => $this->faker->sentence,
            'school_id' => $this->faker->numberBetween(1, 2), // Replace with your logic
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
