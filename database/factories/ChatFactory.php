<?php

namespace Database\Factories;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $managedByUser = $this->faker->numberBetween(1, 5);

        return [
            'name' => $this->faker->colorName,
            'avatar_url' => $this->faker->imageUrl(),
            'created_by_user_id' => $managedByUser,
            'managed_by_user_id' => $managedByUser,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null
        ];
    }
}
