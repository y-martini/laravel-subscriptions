<?php

namespace YuriyMartini\Subscriptions\Contracts;

interface Subscription extends Model
{
    public function getPlan(): Plan;

    public function getCustomer(): HasSubscriptions;
}
