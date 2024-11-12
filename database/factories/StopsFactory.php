<?php

namespace Database\Factories;

use App\Models\Stops;
use Illuminate\Database\Eloquent\Factories\Factory;

class StopsFactory extends Factory
{
    protected $model = Stops::class;

    public function definition()
    {
        return [
            'stopname' => $this->faker->word,
            'location' => $this->faker->address,
        ];
    }
}