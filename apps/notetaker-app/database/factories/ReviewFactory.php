<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence(),
            'link_id' => Link::factory(),
        ];
    }
}
