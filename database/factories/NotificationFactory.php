<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['email', 'sms', 'push', 'webhook']),
            'channel' => $this->faker->randomElement(['app', 'email', 'sms', 'push']),
            'recipient' => $this->faker->email(),
            'subject' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'status' => 'pending',
            'priority' => 'normal',
            'service_name' => 'TestService',
        ];
    }
}
