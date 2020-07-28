<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use YuriyMartini\Subscriptions\Enums\BillingInterval;
use YuriyMartini\Subscriptions\Models\Plan;
use YuriyMartini\Subscriptions\Models\Service;

$factory
    ->define(Plan::class, function (Faker $faker) use ($factory) {
        return [
            (new Service())->getForeignKey() => $factory->of(Service::class),
            'key' => $faker->slug(3),
            'name' => $faker->sentence(3),
            'price' => $faker->randomFloat(2, .01, 999999.99),
            'billing_interval_unit' => Arr::random(BillingInterval::values()),
            'billing_interval_value' => $faker->numberBetween(1, 65535),
        ];
    });
