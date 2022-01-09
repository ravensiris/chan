<?php

namespace Database\Factories;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    protected $model = Thread::class;

    public function definition(): array
    {
        $dt = $this->faker->dateTime;
        return [
            'id' => $this->faker->uuid,
            'created_at' => $dt,
            'updated_at' => $dt
        ];
    }
}
