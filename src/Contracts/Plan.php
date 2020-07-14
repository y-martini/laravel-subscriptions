<?php

namespace YuriyMartini\Subscriptions\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface Plan extends Model
{
    public function getService(): Service;

    public function getSubscriptions(): Collection;
}
