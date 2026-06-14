<?php

namespace App\Support;

use App\Models\User;

/**
 * Generates 6-digit memorable passcodes for parent accounts.
 *
 * "Memorable" = digits follow at least one easy pattern (ABBA mirror, ABCABC repeat,
 * AABBCC pairs, or simple ascending/descending). Rejects passcodes that collide with
 * existing parent users so admins can hand them out as login credentials.
 */
class PasscodeGenerator
{
    public static function generate(): string
    {
        // Try up to 100 patterned passcodes before falling back to random 6 digits.
        for ($i = 0; $i < 100; $i++) {
            $candidate = self::candidate();
            if (! User::where('passcode', $candidate)->exists()) {
                return $candidate;
            }
        }

        // Fallback: random 6 digits with leading zeros allowed
        do {
            $candidate = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (User::where('passcode', $candidate)->exists());

        return $candidate;
    }

    private static function candidate(): string
    {
        $pattern = random_int(1, 4);
        $a = random_int(0, 9);
        $b = random_int(0, 9);
        $c = random_int(0, 9);

        return match ($pattern) {
            // ABBA mirror, e.g. 152251
            1 => "{$a}{$b}{$c}{$c}{$b}{$a}",
            // AABBCC pairs, e.g. 113377
            2 => "{$a}{$a}{$b}{$b}{$c}{$c}",
            // ABCABC repeat, e.g. 248248
            3 => "{$a}{$b}{$c}{$a}{$b}{$c}",
            // ABCDEF ascending from A
            default => self::ascending($a),
        };
    }

    private static function ascending(int $start): string
    {
        $digits = '';
        for ($i = 0; $i < 6; $i++) {
            $digits .= (($start + $i) % 10);
        }

        return $digits;
    }
}
