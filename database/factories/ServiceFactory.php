<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use YuriyMartini\Subscriptions\Models\Service;

$factory
    ->define(Service::class, function (Faker $faker) {
        return [
            'key' => $faker->slug(3),
            'name' => $faker->sentence(3),
        ];
    });
