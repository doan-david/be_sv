<?php

namespace Database\Factories;

use App\Models\ClassName;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassName>
 */
class ClassNameFactory extends Factory
{
    protected $model = ClassName::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->randomNumber(3),
            'name' => $this->faker->name(10),
            'description' => $this->faker->text(30),
            'mentor' => $this->faker->name(10),
        ];
    }
}

