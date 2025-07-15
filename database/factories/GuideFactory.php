<?php

namespace Database\Factories;

use App\Models\Guide;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuideFactory extends Factory
{
    protected $model = Guide::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'photo' => 'https://i.pravatar.cc/150?img=' . rand(1,70),
            'bio' => $this->faker->paragraph(),
            'language' => $this->faker->randomElement(['فارسی', 'انگلیسی', 'ترکی']),
            'location' => $this->faker->city(),
        ];
    }
}
