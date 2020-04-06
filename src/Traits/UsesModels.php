<?php


namespace YuriyMartini\Subscriptions\Traits;


use Illuminate\Support\Facades\Config;

trait UsesModels
{
    protected static function getConfigModel(string $name)
    {
        return Config::get('subscriptions.models.' . $name);
    }

    protected static function getPlanModel()
    {
        return static::getConfigModel('plan');
    }

    protected static function getServiceModel()
    {
        return static::getConfigModel('service');
    }

    protected static function getSubscriptionModel()
    {
        return static::getConfigModel('subscription');
    }
}
