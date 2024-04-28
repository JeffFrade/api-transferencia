<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Repositories\Models\Account>
 */
class AccountFactory extends Factory
{
    public $model = \App\Repositories\Models\Account::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_user' => rand(1, 50),
            'balance' => rand(0, 10000)
        ];
    }
}
