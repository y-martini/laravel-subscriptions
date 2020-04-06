<?php

use YuriyMartini\Subscriptions\Models\Plan;
use YuriyMartini\Subscriptions\Models\Service;
use YuriyMartini\Subscriptions\Models\Subscription;

return [
    'models' => [
        'plan' => Plan::class,
        'service' => Service::class,
        'subscription' => Subscription::class
    ],

    'tables' => [
        'plans' => 'subscriptions_plans',
        'services' => 'subscriptions_services',
        'subscriptions' => 'subscriptions_subscriptions',
    ],

    'users' => [
        'model' => '\App\User',
        'table' => 'users',
    ],
];
