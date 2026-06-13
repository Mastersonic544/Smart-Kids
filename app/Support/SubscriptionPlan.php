<?php

namespace App\Support;

/**
 * The single hypothetical SaaS plan.
 *
 * No payment gateway is wired — checkout just records a SaaS payment row and
 * advances the admin's `subscription_due_at`. Prices stored in millimes-precision
 * TND (3 decimals) to align with the rest of the app's money handling.
 */
final class SubscriptionPlan
{
    /** Plan label shown on the subscription card. */
    public const NAME = 'SmartKids Pro';

    /** Monthly price in TND. */
    public const MONTHLY_PRICE_TND = 199.0;

    /** Fraction off when paying annually (40% per spec). */
    public const ANNUAL_DISCOUNT_RATIO = 0.40;

    public static function annualPrice(): float
    {
        // Full year price after the discount, rounded to millimes.
        return round(self::MONTHLY_PRICE_TND * 12 * (1 - self::ANNUAL_DISCOUNT_RATIO), 3);
    }

    public static function priceFor(string $period): float
    {
        return match ($period) {
            'monthly' => self::MONTHLY_PRICE_TND,
            'annual' => self::annualPrice(),
            default => throw new \InvalidArgumentException("Unknown billing period: {$period}"),
        };
    }

    /**
     * Pretty TND formatter (3 decimals, French separators).
     */
    public static function formatTnd(float $amount): string
    {
        return number_format($amount, 3, ',', ' ').' TND';
    }
}
