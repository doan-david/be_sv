<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->randomNumber(6),
            'name' => $this->faker->name(10),
            'username' => $this->faker->unique()->userName(10),
            'password' => $this->faker->password(),
            'email' => $this->faker->unique()->safeEmail(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'birthday' => $this->faker->date(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'hobby' => $this->faker->text(10),
            'image' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'description' => $this->faker->text(50),
            'class_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
        ];
    }
}
