<?php

namespace App\Enums;

use App\Enums\Interfaces\HasUtility;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ActionStatusEnum: string implements HasColor, HasIcon, HasLabel, HasUtility
{
    use HasCommonMethods;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => 'active',
            self::INACTIVE => 'inactive',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::INACTIVE => 'danger'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ACTIVE => 'heroicon-m-check-badge',
            self::INACTIVE => 'heroicon-m-x-circle'
        };
    }
}
