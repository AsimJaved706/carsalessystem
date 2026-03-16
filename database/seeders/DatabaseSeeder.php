<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@lakeautos.com',
            'password' => Hash::make('XoUm!**X2c'),
        ]);

        // Create 12 vehicles
        $vehicles = Vehicle::factory(12)->create();

        // Create a placeholder images directory
        $placeholderDir = public_path('images/placeholders');
        if (!File::isDirectory($placeholderDir)) {
            File::makeDirectory($placeholderDir, 0755, true);
        }

        // Create placeholder car images for each vehicle
        $colors = ['#2c3e50', '#34495e', '#1a252f', '#2d3436', '#0c2461', '#6a1b4d'];

        foreach ($vehicles as $index => $vehicle) {
            // Create 3 images per vehicle
            for ($i = 0; $i < 3; $i++) {
                $filename = "car_{$vehicle->id}_{$i}.svg";
                $color = $colors[$index % count($colors)];
                $svg = $this->generateCarSvg($vehicle, $color, $i);
                File::put($placeholderDir . '/' . $filename, $svg);

                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'image_path' => 'images/placeholders/' . $filename,
                    'is_primary' => $i === 0,
                ]);
            }
        }
    }

    private function generateCarSvg(Vehicle $vehicle, string $color, int $variant): string
    {
        $bgColors = ['#1a1a2e', '#16213e', '#0f3460', '#1b1b2f', '#162447', '#1f4068'];
        $bg = $bgColors[$variant % count($bgColors)];
        $text = "{$vehicle->year} {$vehicle->make} {$vehicle->model}";
        $labels = ['Front View', 'Side View', 'Interior'];
        $label = $labels[$variant] ?? 'Photo ' . ($variant + 1);

        return <<<SVG
<svg width="800" height="500" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="bg{$variant}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:{$bg}"/>
      <stop offset="100%" style="stop-color:{$color}"/>
    </linearGradient>
  </defs>
  <rect width="800" height="500" fill="url(#bg{$variant})"/>
  <rect x="150" y="180" width="500" height="180" rx="30" fill="{$color}" opacity="0.6"/>
  <rect x="170" y="320" width="80" height="40" rx="20" fill="#555"/>
  <rect x="550" y="320" width="80" height="40" rx="20" fill="#555"/>
  <circle cx="210" cy="340" r="25" fill="#333" stroke="#666" stroke-width="3"/>
  <circle cx="590" cy="340" r="25" fill="#333" stroke="#666" stroke-width="3"/>
  <rect x="250" y="200" width="120" height="80" rx="5" fill="rgba(135,206,250,0.3)"/>
  <rect x="430" y="200" width="120" height="80" rx="5" fill="rgba(135,206,250,0.3)"/>
  <text x="400" y="120" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="28" font-weight="bold">{$text}</text>
  <text x="400" y="440" text-anchor="middle" fill="rgba(255,255,255,0.5)" font-family="Arial, sans-serif" font-size="18">{$label}</text>
</svg>
SVG;
    }
}
