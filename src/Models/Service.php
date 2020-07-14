<?php

namespace YuriyMartini\Subscriptions\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use YuriyMartini\Subscriptions\Contracts\Service as ServiceContract;
use YuriyMartini\Subscriptions\Traits\HasContractsBindings;

/**
 * @property string name
 * @property Collection plans
 */
class Service extends Model implements ServiceContract
{
    use HasContractsBindings;

    public function getPlans(): Collection
    {
        return $this->plans;
    }

    /**
     * @return HasMany
     */
    public function plans()
    {
        return $this->hasMany(static::getPlanContractBinding());
    }
}
