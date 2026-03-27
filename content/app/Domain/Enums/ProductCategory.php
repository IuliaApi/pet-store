<?php

declare(strict_types=1);

namespace App\Domain\Enums;

enum ProductCategory: string
{
    case TOYS = 'toys';
    case APPLIANCES = 'appliances';
    case FOOD = 'food';
    case TOOLS = 'tools';
    case HEALTH_PRODUCTS = 'health products';

    /**
     * Return all category values as a simple string array.
     */
    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}
