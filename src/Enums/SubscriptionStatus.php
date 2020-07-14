<?php

namespace YuriyMartini\Subscriptions\Enums;

use Konekt\Enum\Enum;

class SubscriptionStatus extends Enum {
    const ACTIVE = 'active';
    const CANCELLED = 'cancelled';
    const UNPAID = 'unpaid';

    const __DEFAULT = self::UNPAID;
}
