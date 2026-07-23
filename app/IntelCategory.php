<?php

namespace App;

use App\Icons\Android;
use App\Icons\Ios;

/**
 * Intel report categories for the Driver-to-Driver demo. Each case carries
 * its full presentation contract — label, platform icons, and the
 * High-Vis Utility color treatment — so views never hardcode category logic.
 */
enum IntelCategory: string
{
    case BuildingAccess = 'access';
    case CleanBathroom = 'bathroom';
    case DogAlert = 'dog';
    case GasPrice = 'gas';
    case TrafficParking = 'traffic';

    /** Short label used on feed cards and map chips. */
    public function label(): string
    {
        return match ($this) {
            self::BuildingAccess => 'Access Point',
            self::CleanBathroom => 'Restroom',
            self::DogAlert => 'Dog Alert',
            self::GasPrice => 'Gas Price',
            self::TrafficParking => 'Traffic/Parking',
        };
    }

    /** Longer label used on the report screen's category grid. */
    public function reportLabel(): string
    {
        return match ($this) {
            self::BuildingAccess => 'Building Access',
            self::CleanBathroom => 'Clean Bathroom',
            self::DogAlert => 'Dog Alert',
            self::GasPrice => 'Gas Price',
            self::TrafficParking => 'Traffic/Parking',
        };
    }

    public function iosIcon(): Ios
    {
        return match ($this) {
            self::BuildingAccess => Ios::KeyFill,
            self::CleanBathroom => Ios::FigureDressLineVerticalFigure,
            self::DogAlert => Ios::PawprintFill,
            self::GasPrice => Ios::FuelpumpFill,
            self::TrafficParking => Ios::TruckBoxFill,
        };
    }

    public function androidIcon(): Android
    {
        return match ($this) {
            self::BuildingAccess => Android::Key,
            self::CleanBathroom => Android::Wc,
            self::DogAlert => Android::Pets,
            self::GasPrice => Android::LocalGasStation,
            self::TrafficParking => Android::LocalShipping,
        };
    }

    /** Left-hand status bar on feed cards (DESIGN.md: color before text). */
    public function barClass(): string
    {
        return match ($this) {
            self::BuildingAccess => 'bg-[#00E475]',
            self::CleanBathroom => 'bg-[#C5C7C9]',
            self::DogAlert => 'bg-[#FFB4AB]',
            self::GasPrice => 'bg-[#FFB693]',
            self::TrafficParking => 'bg-[#FF6B00]',
        };
    }

    /** Icon + category label tint on feed cards. */
    public function accentClass(): string
    {
        return match ($this) {
            self::BuildingAccess => 'text-[#00E475]',
            self::CleanBathroom => 'text-[#C5C7C9]',
            self::DogAlert => 'text-[#FFB4AB]',
            self::GasPrice => 'text-[#FFB693]',
            self::TrafficParking => 'text-[#FFB693]',
        };
    }

    /** Solid fill for map pins. */
    public function pinClass(): string
    {
        return match ($this) {
            self::BuildingAccess => 'bg-[#93000A]',
            self::CleanBathroom => 'bg-[#00B059]',
            self::DogAlert => 'bg-[#FF6B00]',
            self::GasPrice => 'bg-[#FF6B00]',
            self::TrafficParking => 'bg-[#FF6B00]',
        };
    }

    /** Icon color on top of the pin fill. */
    public function pinIconClass(): string
    {
        return match ($this) {
            self::BuildingAccess => 'text-[#FFDAD6]',
            default => 'text-[#0C0E0F]',
        };
    }
}
