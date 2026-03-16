<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only([
            'make', 'model', 'body_type', 'condition', 'transmission',
            'fuel_type', 'drivetrain', 'exterior_color', 'interior_color',
            'min_price', 'max_price', 'min_year', 'max_year',
            'min_mileage', 'max_mileage', 'seating_capacity'
        ]);

        $vehicles = Vehicle::available()
            ->with(['primaryImage', 'images'])
            ->filter($filters)
            ->latest()
            ->get();

        // Get filter options
        $makes = Vehicle::getDistinctMakes();
        $bodyTypes = Vehicle::BODY_TYPES;
        $priceRange = Vehicle::getPriceRange();
        $yearRange = Vehicle::getYearRange();
        $transmissions = Vehicle::TRANSMISSIONS;
        $fuelTypes = Vehicle::FUEL_TYPES;
        $drivetrains = Vehicle::DRIVETRAINS;
        $conditions = Vehicle::CONDITIONS;

        // Count vehicles by body type
        $bodyTypeCounts = Vehicle::available()
            ->whereNotNull('body_type')
            ->selectRaw('body_type, COUNT(*) as count')
            ->groupBy('body_type')
            ->pluck('count', 'body_type')
            ->toArray();

        // Count vehicles by make
        $makeCounts = Vehicle::available()
            ->selectRaw('make, COUNT(*) as count')
            ->groupBy('make')
            ->orderBy('make')
            ->pluck('count', 'make')
            ->toArray();

        return view('home', compact(
            'vehicles', 'makes', 'bodyTypes', 'priceRange', 'yearRange',
            'transmissions', 'fuelTypes', 'drivetrains', 'conditions',
            'bodyTypeCounts', 'makeCounts', 'filters'
        ));
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('images');

        return view('vehicles.show', compact('vehicle'));
    }
}
