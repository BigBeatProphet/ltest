<?php

namespace Database\Factories;

use App\Models\Buses;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusesFactory extends Factory
{
    protected $model = Buses::class;

    public function definition()
    {
        return [
            'busname' => $this->faker->word,
        ];
    }
}