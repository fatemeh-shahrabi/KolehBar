<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;

class DestinationFactory extends Factory
{
    protected $model = Destination::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),
            'image' => 'https://picsum.photos/seed/' . rand(1, 1000) . '/400/300',
            'summary' => $this->faker->sentence(),
            'region' => $this->faker->province(),
        ];
    }
}
