<?php

namespace YuriyMartini\Subscriptions\Enums;

use Konekt\Enum\Enum;

/**
 * @method static self ACTIVE()
 * @method static self CANCELLED()
 * @method static self EXPIRED()
 * @method static self UNPAID()
 */
class SubscriptionStatus extends Enum {
    const ACTIVE = 'active';
    const CANCELLED = 'cancelled';
    const EXPIRED = 'expired';
    const UNPAID = 'unpaid';

    const __DEFAULT = self::UNPAID;
}
