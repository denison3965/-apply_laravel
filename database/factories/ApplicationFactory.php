<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'adress' => $this->faker->address,
            'curriculum_path' => '/tmp/curriculum/cv.doc',
            'ip' => '152.211.255.045'
        ];
    }
}
