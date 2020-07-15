<?php

namespace YuriyMartini\Subscriptions\Traits;

use Illuminate\Container\Container;
use YuriyMartini\Subscriptions\Contracts\Coupon;
use YuriyMartini\Subscriptions\Contracts\HasSubscriptions;
use YuriyMartini\Subscriptions\Contracts\Plan;
use YuriyMartini\Subscriptions\Contracts\Service;
use YuriyMartini\Subscriptions\Contracts\Subscription;

trait InteractsWithContractsBindings
{
    public static function resolveHasSubscriptionsContract(): HasSubscriptions
    {
        /** @var HasSubscriptions $hasSubscriptions */
        $hasSubscriptions = Container::getInstance()->make(HasSubscriptions::class);
        return $hasSubscriptions;
    }

    public static function resolvePlanContract(): Plan
    {
        /** @var Plan $plan */
        $plan = Container::getInstance()->make(Plan::class);
        return $plan;
    }

    public static function resolveServiceContract(): Service
    {
        /** @var Service $service */
        $service = Container::getInstance()->make(Service::class);
        return $service;
    }

    public static function resolveSubscriptionContract(): Subscription
    {
        /** @var Subscription $subscription */
        $subscription = Container::getInstance()->make(Subscription::class);
        return $subscription;
    }

    public static function resolveCouponContract(): Coupon
    {
        /** @var Coupon $coupon */
        $coupon = Container::getInstance()->make(Coupon::class);
        return $coupon;
    }

    public static function getHasSubscriptionsContractBinding(): string
    {
        return get_class(Container::getInstance()->get(HasSubscriptions::class));
    }

    public static function getPlanContractBinding(): string
    {
        return get_class(Container::getInstance()->get(Plan::class));
    }

    public static function getServiceContractBinding(): string
    {
        return get_class(Container::getInstance()->get(Service::class));
    }

    public static function getSubscriptionContractBinding(): string
    {
        return get_class(Container::getInstance()->get(Subscription::class));
    }

    public static function getCouponContractBinding(): string
    {
        return get_class(Container::getInstance()->get(Coupon::class));
    }
}
