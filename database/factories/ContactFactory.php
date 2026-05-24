<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'gender' => fake()->randomElement([1, 2, 3]),
            'email' => fake()->safeEmail(),
            'tel' => fake()->numerify(fake()->randomElement(['0#########', '0##########'])),
            'address' => fake()->address(),
            'building' => fake()->secondaryAddress(),
            'category_id' => Category::factory(),
            'detail' => fake()->text(120),
        ];
    }
}
