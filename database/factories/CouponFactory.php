<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use YuriyMartini\Subscriptions\Enums\DiscountType;
use YuriyMartini\Subscriptions\Models\Coupon;

$factory
    ->define(Coupon::class, function (Faker $faker) {
        return [
            'name' => $faker->words(3, true),
            'type' => Arr::random(DiscountType::values()),
            'value' => $faker->randomFloat(2, .01, 100.00),
            'is_recurrent' => $faker->boolean,
        ];
    });
