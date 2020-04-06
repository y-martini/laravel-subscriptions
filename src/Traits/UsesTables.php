<?php


namespace YuriyMartini\Subscriptions\Traits;


use Illuminate\Support\Facades\Config;

trait UsesTables
{
    protected static function getConfigTable(string $name)
    {
        return Config::get('subscriptions.tables.' . $name);
    }

    protected static function getPlansTable()
    {
        return static::getConfigTable('plans');
    }

    protected static function getServicesTable()
    {
        return static::getConfigTable('services');
    }

    protected static function getSubscriptionsTable()
    {
        return static::getConfigTable('subscriptions');
    }

    protected static function getUsersTable()
    {
        return Config::get('subscriptions.users.table');
    }
}
