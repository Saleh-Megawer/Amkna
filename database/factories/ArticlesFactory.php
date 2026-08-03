<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticlesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title"     => $this->faker->name(),
            "slug"      => slug($this->faker->name()),
            "desc"      => $this->faker->name(),
            "content"   => $this->faker->paragraph(),
            "image"     => $this->faker->image(public_path('assets/'), 640, 480, null, false)
        ];
    }
}
