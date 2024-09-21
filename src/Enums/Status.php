<?php

namespace Ninja\DeviceTracker\Enums;

enum Status: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Finished = 'finished';
    case Blocked = 'blocked';
    case Locked = 'locked';

    public static function values(): array
    {
        return [
            self::Active,
            self::Inactive,
            self::Finished,
            self::Blocked,
            self::Locked,
        ];
    }
}