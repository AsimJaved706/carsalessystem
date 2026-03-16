<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_options', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // body_type, transmission, fuel_type, drivetrain, feature
            $table->string('key'); // The value stored in database (e.g., 'sedan', 'automatic')
            $table->string('label'); // Display label (e.g., 'Sedan', 'Automatic')
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['type', 'key']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_options');
    }
};
