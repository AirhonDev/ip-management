<?php

namespace Database\Factories;

use App\Models\IpAddress;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IpAddressFactory extends Factory
{
    protected $model = IpAddress::class;

    public function definition()
    {
        return [
            'ip_address' => $this->faker->ipv4,
        ];
    }
}
