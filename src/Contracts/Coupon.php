<?php

namespace YuriyMartini\Subscriptions\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface Coupon extends Model
{
    public function getSubscriptions(): Collection;
}
