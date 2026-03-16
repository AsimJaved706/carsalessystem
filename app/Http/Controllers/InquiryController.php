<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Vehicle;
use App\Models\Setting;
use App\Mail\InquiryReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
        ]);

        $inquiry = Inquiry::create($validated);
        $inquiry->load('vehicle');

        // Send email notification to notification email from settings
        try {
            $notificationEmail = Setting::get('notification_email');
            if ($notificationEmail) {
                Mail::to($notificationEmail)->send(new InquiryReceived($inquiry));
            }
        } catch (\Exception $e) {
            // Log but don't fail
            \Log::warning('Failed to send inquiry email: ' . $e->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', 'Your inquiry has been sent successfully! We will get back to you soon.');
    }
}
