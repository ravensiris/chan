<?php

namespace Database\Factories;

use App\Models\Board;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardFactory extends Factory
{
    protected $model = Board::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->name,
            'shorthand' => $this->faker->unique()->randomLetter()
        ];
    }
}
