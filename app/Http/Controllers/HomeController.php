<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;

class HomeController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::available()
            ->with('primaryImage')
            ->latest()
            ->get();

        return view('home', compact('vehicles'));
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('images');

        return view('vehicles.show', compact('vehicle'));
    }
}
