<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('body_type')->nullable()->after('model'); // SUV, Sedan, Truck, Van, Hatchback, Coupe, Wagon, Convertible
            $table->string('condition')->default('used')->after('body_type'); // new, used, certified
            $table->string('transmission')->nullable()->after('mileage'); // automatic, manual, cvt
            $table->string('fuel_type')->nullable()->after('transmission'); // gasoline, diesel, hybrid, electric, plug-in hybrid
            $table->string('drivetrain')->nullable()->after('fuel_type'); // fwd, rwd, awd, 4wd
            $table->string('exterior_color')->nullable()->after('drivetrain');
            $table->string('interior_color')->nullable()->after('exterior_color');
            $table->unsignedTinyInteger('seating_capacity')->nullable()->after('interior_color');
            $table->string('engine')->nullable()->after('seating_capacity'); // e.g., "2.5L 4-Cylinder"
            $table->json('features')->nullable()->after('engine'); // Array of features like "Bluetooth", "Backup Camera", etc.
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'body_type',
                'condition',
                'transmission',
                'fuel_type',
                'drivetrain',
                'exterior_color',
                'interior_color',
                'seating_capacity',
                'engine',
                'features',
            ]);
        });
    }
};
