<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'mime_type' => $this->faker->mimeType,
            'url' => $this->faker->imageUrl(),
            'type' => 'image',
            'name' => $this->faker->name,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
