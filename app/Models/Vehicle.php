<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'make',
        'model',
        'body_type',
        'condition',
        'year',
        'price',
        'mileage',
        'transmission',
        'fuel_type',
        'drivetrain',
        'exterior_color',
        'interior_color',
        'seating_capacity',
        'engine',
        'features',
        'vin',
        'description',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'year' => 'integer',
        'mileage' => 'integer',
        'seating_capacity' => 'integer',
        'features' => 'array',
    ];

    // Body type constants
    public const BODY_TYPES = [
        'sedan' => 'Sedan',
        'suv' => 'SUV',
        'truck' => 'Truck',
        'van' => 'Van',
        'hatchback' => 'Hatchback',
        'coupe' => 'Coupe',
        'wagon' => 'Wagon',
        'convertible' => 'Convertible',
    ];

    public const CONDITIONS = [
        'new' => 'New',
        'used' => 'Used',
        'certified' => 'Certified Pre-Owned',
    ];

    public const TRANSMISSIONS = [
        'automatic' => 'Automatic',
        'manual' => 'Manual',
        'cvt' => 'CVT',
    ];

    public const FUEL_TYPES = [
        'gasoline' => 'Gasoline',
        'diesel' => 'Diesel',
        'hybrid' => 'Hybrid',
        'electric' => 'Electric',
        'plugin_hybrid' => 'Plug-in Hybrid',
    ];

    public const DRIVETRAINS = [
        'fwd' => 'Front-Wheel Drive',
        'rwd' => 'Rear-Wheel Drive',
        'awd' => 'All-Wheel Drive',
        '4wd' => '4-Wheel Drive',
    ];

    public const COMMON_FEATURES = [
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
    ];

    public function images(): HasMany
    {
        return $this->hasMany(VehicleImage::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(VehicleImage::class)->where('is_primary', true);
    }

    // Status Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }

    // Filter Scopes
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['make'] ?? null, fn($q, $make) => $q->where('make', $make))
            ->when($filters['model'] ?? null, fn($q, $model) => $q->where('model', $model))
            ->when($filters['body_type'] ?? null, fn($q, $type) => $q->where('body_type', $type))
            ->when($filters['condition'] ?? null, fn($q, $cond) => $q->where('condition', $cond))
            ->when($filters['transmission'] ?? null, fn($q, $trans) => $q->where('transmission', $trans))
            ->when($filters['fuel_type'] ?? null, fn($q, $fuel) => $q->where('fuel_type', $fuel))
            ->when($filters['drivetrain'] ?? null, fn($q, $drive) => $q->where('drivetrain', $drive))
            ->when($filters['exterior_color'] ?? null, fn($q, $color) => $q->where('exterior_color', $color))
            ->when($filters['interior_color'] ?? null, fn($q, $color) => $q->where('interior_color', $color))
            ->when($filters['min_price'] ?? null, fn($q, $price) => $q->where('price', '>=', $price))
            ->when($filters['max_price'] ?? null, fn($q, $price) => $q->where('price', '<=', $price))
            ->when($filters['min_year'] ?? null, fn($q, $year) => $q->where('year', '>=', $year))
            ->when($filters['max_year'] ?? null, fn($q, $year) => $q->where('year', '<=', $year))
            ->when($filters['min_mileage'] ?? null, fn($q, $miles) => $q->where('mileage', '>=', $miles))
            ->when($filters['max_mileage'] ?? null, fn($q, $miles) => $q->where('mileage', '<=', $miles))
            ->when($filters['seating_capacity'] ?? null, fn($q, $seats) => $q->where('seating_capacity', $seats));
    }

    // Get distinct makes from database
    public static function getDistinctMakes(): array
    {
        return static::available()
            ->distinct()
            ->orderBy('make')
            ->pluck('make')
            ->toArray();
    }

    // Get distinct body types from database
    public static function getDistinctBodyTypes(): array
    {
        return static::available()
            ->whereNotNull('body_type')
            ->distinct()
            ->orderBy('body_type')
            ->pluck('body_type')
            ->toArray();
    }

    // Get price range
    public static function getPriceRange(): array
    {
        $result = static::available()->selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();
        return [
            'min' => (int) ($result->min_price ?? 0),
            'max' => (int) ($result->max_price ?? 100000),
        ];
    }

    // Get year range
    public static function getYearRange(): array
    {
        $result = static::available()->selectRaw('MIN(year) as min_year, MAX(year) as max_year')->first();
        return [
            'min' => (int) ($result->min_year ?? 2000),
            'max' => (int) ($result->max_year ?? date('Y')),
        ];
    }

    public function getFullTitleAttribute(): string
    {
        return "{$this->year} {$this->make} {$this->model}";
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 0);
    }

    public function getFormattedMileageAttribute(): string
    {
        return number_format($this->mileage) . ' miles';
    }

    public function getBodyTypeLabelAttribute(): string
    {
        return self::BODY_TYPES[$this->body_type] ?? ucfirst($this->body_type ?? '');
    }

    public function getTransmissionLabelAttribute(): string
    {
        return self::TRANSMISSIONS[$this->transmission] ?? ucfirst($this->transmission ?? '');
    }

    public function getFuelTypeLabelAttribute(): string
    {
        return self::FUEL_TYPES[$this->fuel_type] ?? ucfirst($this->fuel_type ?? '');
    }

    public function getDrivetrainLabelAttribute(): string
    {
        return self::DRIVETRAINS[$this->drivetrain] ?? strtoupper($this->drivetrain ?? '');
    }
}
