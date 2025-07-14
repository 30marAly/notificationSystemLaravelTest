<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notification;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Notification::class;


     
    public function definition(): array
    {
        return [
            //
            "title"=> $this->faker->sentence,
            "description"=> $this->faker->paragraph,
            'isRead' => $this->faker->boolean(),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
