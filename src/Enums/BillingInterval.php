<?php

namespace YuriyMartini\Subscriptions\Enums;

use Konekt\Enum\Enum;

class BillingInterval extends Enum {
    const DAYS = 'days';
    const WEEKS = 'weeks';
    const MONTHS = 'months';
    const YEARS = 'years';

    public const __DEFAULT = self::MONTHS;
}
