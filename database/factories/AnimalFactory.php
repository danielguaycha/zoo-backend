<?php

namespace Database\Factories;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimalFactory extends Factory
{

    protected $model = Animal::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'science_name' => $this->faker->name,
            'description' => $this->faker->sentence(10),
            'img' => 'animals/animal.jpg'
        ];
    }
}
