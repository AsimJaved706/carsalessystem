<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('primaryImage')
            ->withCount('inquiries')
            ->latest()
            ->paginate(15);

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
            'vin' => 'nullable|string|max:17',
            'description' => 'nullable|string',
            'status' => 'required|in:available,sold',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $vehicle = Vehicle::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $uploadDir = public_path('images/vehicles');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            foreach ($request->file('images') as $index => $image) {
                $filename = 'vehicle_' . $vehicle->id . '_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->move($uploadDir, $filename);

                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'image_path' => 'images/vehicles/' . $filename,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Vehicle added successfully!');
    }

    public function edit(Vehicle $vehicle)
    {
        $vehicle->load('images');

        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
            'vin' => 'nullable|string|max:17',
            'description' => 'nullable|string',
            'status' => 'required|in:available,sold',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $vehicle->update($validated);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $uploadDir = public_path('images/vehicles');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            $hasPrimary = $vehicle->images()->where('is_primary', true)->exists();

            foreach ($request->file('images') as $index => $image) {
                $filename = 'vehicle_' . $vehicle->id . '_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->move($uploadDir, $filename);

                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'image_path' => 'images/vehicles/' . $filename,
                    'is_primary' => !$hasPrimary && $index === 0,
                ]);
            }
        }

        // Handle image deletions
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $img = VehicleImage::find($imageId);
                if ($img) {
                    $filePath = public_path($img->image_path);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                    $img->delete();
                }
            }
        }

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Vehicle updated successfully!');
    }

    public function destroy(Vehicle $vehicle)
    {
        // Delete associated images from disk
        foreach ($vehicle->images as $image) {
            $filePath = public_path($image->image_path);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $vehicle->delete();

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Vehicle deleted successfully!');
    }

    public function toggleStatus(Vehicle $vehicle)
    {
        $vehicle->status = $vehicle->status === 'available' ? 'sold' : 'available';
        $vehicle->save();

        $statusText = $vehicle->status === 'sold' ? 'marked as sold' : 'marked as available';

        return redirect()
            ->back()
            ->with('success', "Vehicle {$statusText} successfully!");
    }
}
