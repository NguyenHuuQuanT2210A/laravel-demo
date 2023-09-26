<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id"=> random_int(1,10),
            "grand_total" => 0,
            "status"=>random_int(0,3),
            "tel"=>$this->faker->phoneNumber,
            "full_name"=>$this->faker->name,
            "address"=>$this->faker->address,
            "shipping_method"=>"Express",
            "payment_method"=>"COD",
        ];
    }
}
