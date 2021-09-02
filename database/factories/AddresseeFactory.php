<?php

namespace Database\Factories;

use App\Models\Addressee;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class AddresseeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Addressee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
