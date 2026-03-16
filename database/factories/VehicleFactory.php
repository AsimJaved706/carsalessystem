<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        $cars = [
            ['make' => 'Toyota', 'model' => 'Corolla'],
            ['make' => 'Toyota', 'model' => 'Camry'],
            ['make' => 'Honda', 'model' => 'Civic'],
            ['make' => 'Honda', 'model' => 'Accord'],
            ['make' => 'Ford', 'model' => 'F-150'],
            ['make' => 'Ford', 'model' => 'Escape'],
            ['make' => 'Chevrolet', 'model' => 'Malibu'],
            ['make' => 'Chevrolet', 'model' => 'Equinox'],
            ['make' => 'Nissan', 'model' => 'Altima'],
            ['make' => 'Nissan', 'model' => 'Rogue'],
            ['make' => 'BMW', 'model' => '3 Series'],
            ['make' => 'Mercedes-Benz', 'model' => 'C-Class'],
            ['make' => 'Hyundai', 'model' => 'Elantra'],
            ['make' => 'Kia', 'model' => 'Optima'],
            ['make' => 'Subaru', 'model' => 'Outback'],
            ['make' => 'Volkswagen', 'model' => 'Jetta'],
        ];

        $car = $this->faker->randomElement($cars);

        return [
            'make' => $car['make'],
            'model' => $car['model'],
            'year' => $this->faker->numberBetween(2015, 2024),
            'price' => $this->faker->numberBetween(8000, 45000),
            'mileage' => $this->faker->numberBetween(10000, 120000),
            'vin' => strtoupper($this->faker->bothify('??#??##?#?#######')),
            'description' => $this->faker->randomElement([
                'Clean title vehicle in excellent condition. Well maintained with regular service records.',
                'One owner vehicle with low mileage. No accidents reported. Runs and drives great.',
                'Recently serviced with new tires and brakes. Interior in great shape. Ready to drive.',
                'Fuel efficient and reliable. Perfect daily driver. All maintenance up to date.',
                'Loaded with features. Leather seats, sunroof, backup camera. Must see in person.',
                'Certified pre-owned quality. Extended warranty available. Financing options available.',
            ]),
            'status' => 'available',
        ];
    }
}
