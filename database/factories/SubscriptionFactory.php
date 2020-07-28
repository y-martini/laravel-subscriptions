<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use YuriyMartini\Subscriptions\Contracts\HasSubscriptions;
use YuriyMartini\Subscriptions\Enums\SubscriptionStatus;
use YuriyMartini\Subscriptions\Models\Plan;
use YuriyMartini\Subscriptions\Models\Subscription;

/** @var HasSubscriptions $hasSubscriptions */
$hasSubscriptions = Container::getInstance()->make(HasSubscriptions::class);

$factory
    ->define(Subscription::class, function (Faker $faker) use ($hasSubscriptions, $factory) {
        $date = $faker->dateTimeThisMonth;
        return [
            $hasSubscriptions->getForeignKey() => get_class($hasSubscriptions),
            (new Plan())->getForeignKey() => $factory->of(Plan::class),
            'status' => Arr::random(SubscriptionStatus::values()),
            'start_date' => new Carbon($date),
            'end_date' => (new Carbon($date))->addMonth(),
        ];
    });
