<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        $defaultSettings = [
            // SMTP Settings
            ['key' => 'mail_mailer', 'value' => 'smtp'],
            ['key' => 'mail_host', 'value' => 'smtp.gmail.com'],
            ['key' => 'mail_port', 'value' => '587'],
            ['key' => 'mail_username', 'value' => ''],
            ['key' => 'mail_password', 'value' => ''],
            ['key' => 'mail_encryption', 'value' => 'tls'],
            ['key' => 'mail_from_address', 'value' => ''],
            ['key' => 'mail_from_name', 'value' => 'Lake Auto Sales & Services'],
            ['key' => 'notification_email', 'value' => ''],
            
            // Contact Information
            ['key' => 'contact_phone', 'value' => '219-252-9183'],
            ['key' => 'contact_email', 'value' => ''],
            ['key' => 'contact_address', 'value' => '2746 Dekalb St, Lake Station IN 46505'],
            ['key' => 'contact_hours', 'value' => 'Mon-Sat: 9AM-6PM, Sun: Closed'],
            
            // Social Media
            ['key' => 'social_facebook', 'value' => ''],
            ['key' => 'social_instagram', 'value' => ''],
        ];

        foreach ($defaultSettings as $setting) {
            DB::table('settings')->insert([
                'key' => $setting['key'],
                'value' => $setting['value'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
