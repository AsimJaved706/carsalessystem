<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class ContactController extends Controller
{
    public function index()
    {
        $contact = [
            'phone' => Setting::get('contact_phone', '219-252-9183'),
            'email' => Setting::get('contact_email', 'info@lakeautosales.com'),
            'address' => Setting::get('contact_address', '2746 Dekalb St, Lake Station IN 46505'),
            'hours' => Setting::get('contact_hours', ''),
            'facebook' => Setting::get('social_facebook', ''),
            'instagram' => Setting::get('social_instagram', ''),
        ];

        return view('contact', compact('contact'));
    }
}
