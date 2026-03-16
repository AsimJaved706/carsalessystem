<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class VehicleOption extends Model
{
    protected $fillable = [
        'type',
        'key',
        'label',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Option types
    public const TYPES = [
        'body_type' => 'Body Type',
        'transmission' => 'Transmission',
        'fuel_type' => 'Fuel Type',
        'drivetrain' => 'Drivetrain',
        'feature' => 'Feature',
    ];

    /**
     * Get options by type
     */
    public static function getByType(string $type, bool $activeOnly = true): array
    {
        $cacheKey = "vehicle_options_{$type}" . ($activeOnly ? '_active' : '_all');
        
        return Cache::remember($cacheKey, 3600, function () use ($type, $activeOnly) {
            $query = self::where('type', $type)->orderBy('sort_order')->orderBy('label');
            
            if ($activeOnly) {
                $query->where('is_active', true);
            }
            
            return $query->pluck('label', 'key')->toArray();
        });
    }

    /**
     * Get all options grouped by type
     */
    public static function getAllGrouped(bool $activeOnly = true): array
    {
        $result = [];
        foreach (array_keys(self::TYPES) as $type) {
            $result[$type] = self::getByType($type, $activeOnly);
        }
        return $result;
    }

    /**
     * Clear the cache for a specific type or all types
     */
    public static function clearCache(?string $type = null): void
    {
        if ($type) {
            Cache::forget("vehicle_options_{$type}_active");
            Cache::forget("vehicle_options_{$type}_all");
        } else {
            foreach (array_keys(self::TYPES) as $t) {
                Cache::forget("vehicle_options_{$t}_active");
                Cache::forget("vehicle_options_{$t}_all");
            }
        }
    }

    /**
     * Seed default options
     */
    public static function seedDefaults(): void
    {
        $defaults = [
            'body_type' => [
                'sedan' => 'Sedan',
                'suv' => 'SUV',
                'truck' => 'Truck',
                'van' => 'Van',
                'hatchback' => 'Hatchback',
                'coupe' => 'Coupe',
                'wagon' => 'Wagon',
                'convertible' => 'Convertible',
            ],
            'transmission' => [
                'automatic' => 'Automatic',
                'manual' => 'Manual',
                'cvt' => 'CVT',
            ],
            'fuel_type' => [
                'gasoline' => 'Gasoline',
                'diesel' => 'Diesel',
                'hybrid' => 'Hybrid',
                'electric' => 'Electric',
                'plugin_hybrid' => 'Plug-in Hybrid',
            ],
            'drivetrain' => [
                'fwd' => 'Front-Wheel Drive',
                'rwd' => 'Rear-Wheel Drive',
                'awd' => 'All-Wheel Drive',
                '4wd' => '4-Wheel Drive',
            ],
            'feature' => [
                'bluetooth' => 'Bluetooth',
                'backup_camera' => 'Backup Camera',
                'navigation' => 'Navigation System',
                'leather_seats' => 'Leather Seats',
                'sunroof' => 'Sunroof/Moonroof',
                'heated_seats' => 'Heated Seats',
                'apple_carplay' => 'Apple CarPlay',
                'android_auto' => 'Android Auto',
                'keyless_entry' => 'Keyless Entry',
                'remote_start' => 'Remote Start',
                'cruise_control' => 'Cruise Control',
                'blind_spot' => 'Blind Spot Monitor',
                'lane_assist' => 'Lane Departure Warning',
                'parking_sensors' => 'Parking Sensors',
                'third_row' => 'Third Row Seating',
            ],
        ];

        $sortOrder = 0;
        foreach ($defaults as $type => $options) {
            $sortOrder = 0;
            foreach ($options as $key => $label) {
                self::updateOrCreate(
                    ['type' => $type, 'key' => $key],
                    ['label' => $label, 'sort_order' => $sortOrder++, 'is_active' => true]
                );
            }
        }

        self::clearCache();
    }
}
