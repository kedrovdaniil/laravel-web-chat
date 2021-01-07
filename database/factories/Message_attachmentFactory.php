<?php

namespace Database\Factories;

use App\Models\Message_attachment;
use Illuminate\Database\Eloquent\Factories\Factory;

class Message_attachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message_attachment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'message_id' => $this->faker->numberBetween(1, 50),
            'file_id' => $this->faker->numberBetween(1, 20),
            'created_at' => now()
        ];
    }
}
