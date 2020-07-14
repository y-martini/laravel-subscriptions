<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use YuriyMartini\Subscriptions\Enums\SubscriptionStatus;
use YuriyMartini\Subscriptions\Models\Plan;
use YuriyMartini\Subscriptions\Models\Subscription;

$factory
    ->define(Subscription::class, function (Faker $faker) {
        $date = $faker->dateTimeThisMonth;
        return [
            'status' => Arr::random(SubscriptionStatus::values()),
            'start_date' => new Carbon($date),
            'end_date' => (new Carbon($date))->addMonth(),
        ];
    })
    ->state(Subscription::class, 'plan', function () use ($factory) {
        return [
            (new Plan)->getForeignKey() => $factory->of(Plan::class),
        ];
    });
