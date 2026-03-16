<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    /**
     * Show SMTP settings form
     */
    public function smtp()
    {
        $settings = Setting::getMany([
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name',
            'notification_email',
        ]);

        return view('admin.settings.smtp', compact('settings'));
    }

    /**
     * Update SMTP settings
     */
    public function updateSmtp(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required|in:smtp,sendmail,mailgun,ses,postmark',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'required|in:tls,ssl,null',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
            'notification_email' => 'required|email|max:255',
        ]);

        Setting::setMany([
            'mail_mailer' => $request->mail_mailer,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username ?? '',
            'mail_password' => $request->mail_password ?? '',
            'mail_encryption' => $request->mail_encryption,
            'mail_from_address' => $request->mail_from_address,
            'mail_from_name' => $request->mail_from_name,
            'notification_email' => $request->notification_email,
        ]);

        return redirect()->route('admin.settings.smtp')
            ->with('success', 'SMTP settings updated successfully!');
    }

    /**
     * Test SMTP connection
     */
    public function testSmtp(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        try {
            // Configure mail settings dynamically
            $this->configureMailSettings();

            Mail::raw('This is a test email from Lake Auto Sales & Services admin panel.', function ($message) use ($request) {
                $message->to($request->test_email)
                    ->subject('SMTP Test - Lake Auto Sales & Services');
            });

            return redirect()->route('admin.settings.smtp')
                ->with('success', 'Test email sent successfully! Check your inbox.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.smtp')
                ->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }

    /**
     * Show contact information form
     */
    public function contact()
    {
        $settings = Setting::getMany([
            'contact_phone',
            'contact_email',
            'contact_address',
            'contact_hours',
            'social_facebook',
            'social_instagram',
            'site_logo',
            'header_logo_height',
            'banner_logo_width',
        ]);

        return view('admin.settings.contact', compact('settings'));
    }

    /**
     * Update contact information
     */
    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_phone' => 'required|string|max:50',
            'contact_email' => 'required|email|max:255',
            'contact_address' => 'required|string|max:500',
            'contact_hours' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'header_logo_height' => 'nullable|integer|min:30|max:140',
            'banner_logo_width' => 'nullable|integer|min:120|max:700',
        ]);

        $logoPath = Setting::get('site_logo', 'images/logo.png');

        if ($request->hasFile('site_logo')) {
            $uploadDir = public_path('images/settings');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            $file = $request->file('site_logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $logoPath = 'images/settings/' . $filename;
        }

        Setting::setMany([
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'contact_address' => $request->contact_address,
            'contact_hours' => $request->contact_hours ?? '',
            'social_facebook' => $request->social_facebook ?? '',
            'social_instagram' => $request->social_instagram ?? '',
            'site_logo' => $logoPath,
            'header_logo_height' => (string) ($request->header_logo_height ?? 55),
            'banner_logo_width' => (string) ($request->banner_logo_width ?? 380),
        ]);

        return redirect()->route('admin.settings.contact')
            ->with('success', 'Contact information updated successfully!');
    }

    /**
     * Configure mail settings from database
     */
    private function configureMailSettings(): void
    {
        Config::set('mail.default', Setting::get('mail_mailer', 'smtp'));
        Config::set('mail.mailers.smtp.host', Setting::get('mail_host', 'smtp.gmail.com'));
        Config::set('mail.mailers.smtp.port', (int) Setting::get('mail_port', 587));
        Config::set('mail.mailers.smtp.username', Setting::get('mail_username'));
        Config::set('mail.mailers.smtp.password', Setting::get('mail_password'));
        Config::set('mail.mailers.smtp.encryption', Setting::get('mail_encryption', 'tls'));
        Config::set('mail.from.address', Setting::get('mail_from_address'));
        Config::set('mail.from.name', Setting::get('mail_from_name', 'Lake Auto Sales & Services'));
    }
}
