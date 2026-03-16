<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureMailFromDatabase();
    }

    /**
     * Configure mail settings from database
     */
    private function configureMailFromDatabase(): void
    {
        // Only configure if the settings table exists (after migration)
        try {
            if (Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::all()->pluck('value', 'key');
                
                if ($settings->has('mail_host') && $settings->get('mail_host')) {
                    Config::set('mail.default', $settings->get('mail_mailer', 'smtp'));
                    Config::set('mail.mailers.smtp.host', $settings->get('mail_host'));
                    Config::set('mail.mailers.smtp.port', (int) $settings->get('mail_port', 587));
                    Config::set('mail.mailers.smtp.username', $settings->get('mail_username'));
                    Config::set('mail.mailers.smtp.password', $settings->get('mail_password'));
                    Config::set('mail.mailers.smtp.encryption', $settings->get('mail_encryption', 'tls'));
                    
                    if ($settings->get('mail_from_address')) {
                        Config::set('mail.from.address', $settings->get('mail_from_address'));
                    }
                    if ($settings->get('mail_from_name')) {
                        Config::set('mail.from.name', $settings->get('mail_from_name'));
                    }
                }
            }
        } catch (\Exception $e) {
            // Silently fail if database is not available yet
        }
    }
}
