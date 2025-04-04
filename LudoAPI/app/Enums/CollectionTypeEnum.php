<?php

namespace App\Enums;

enum CollectionTypeEnum: string
{
    use HasCommonMethods;

    //["board","dice","emote","token"]
    case BOARD = 'board';
    case DICE = 'dice';
    case EMOTE = 'emote';
    case TOKEN = 'token';
    case COIN = 'coin';

    public function getLabel(): string
    {
        return match ($this) {
            self::BOARD => 'board',
            self::DICE => 'dice',
            self::EMOTE => 'emote',
            self::TOKEN => 'token',
            self::COIN => 'coin',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::BOARD => 'success',
            self::DICE => 'danger',
            self::EMOTE => 'info',
            self::TOKEN => 'info-b',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::BOARD => 'heroicon-m-check-badge',
            self::DICE => 'heroicon-m-x-circle',
            self::EMOTE => 'heroicon-m-x-circle',
            self::TOKEN => 'heroicon-m-x-circle',
        };
    }
}
