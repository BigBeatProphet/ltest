<?php

namespace Database\Factories;

use App\Models\Routes;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoutesFactory extends Factory
{
    protected $model = Routes::class;

    public function definition()
    {
        return [
            'routename' => $this->faker->word,
            'busid' => \App\Models\Buses::factory(),
            'stops' => json_encode([$this->faker->numberBetween(1, 10), $this->faker->numberBetween(1, 10)]),
        ];
    }
}