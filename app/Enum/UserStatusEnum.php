<?php

namespace App\Enum;

enum UserStatusEnum: int
{
    case ACTIVE = 1;
    case SUSPENDED = 0;

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE    => 'Active',
            self::SUSPENDED => 'Suspended',
        };
    }

    // Get all as array with labels
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [
            $case->value => $case->label(),
        ])->toArray();
    }
}
