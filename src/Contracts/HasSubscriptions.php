<?php

namespace YuriyMartini\Subscriptions\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface HasSubscriptions extends Model
{
    public function getSubscriptions(): Collection;
}
