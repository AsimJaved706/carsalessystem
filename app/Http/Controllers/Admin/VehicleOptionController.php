<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleOption;
use Illuminate\Http\Request;

class VehicleOptionController extends Controller
{
    /**
     * Display a listing of the options.
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'body_type');
        
        $options = VehicleOption::where('type', $type)
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get();

        return view('admin.vehicle-options.index', [
            'options' => $options,
            'currentType' => $type,
            'types' => VehicleOption::TYPES,
        ]);
    }

    /**
     * Show the form for creating a new option.
     */
    public function create(Request $request)
    {
        $type = $request->get('type', 'body_type');
        
        return view('admin.vehicle-options.create', [
            'currentType' => $type,
            'types' => VehicleOption::TYPES,
        ]);
    }

    /**
     * Store a newly created option.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:' . implode(',', array_keys(VehicleOption::TYPES)),
            'key' => 'required|string|max:50|unique:vehicle_options,key,NULL,id,type,' . $request->type,
            'label' => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['key'] = strtolower(str_replace(' ', '_', $validated['key']));
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        VehicleOption::create($validated);
        VehicleOption::clearCache($validated['type']);

        return redirect()
            ->route('admin.vehicle-options.index', ['type' => $validated['type']])
            ->with('success', 'Option created successfully.');
    }

    /**
     * Show the form for editing the specified option.
     */
    public function edit(VehicleOption $vehicleOption)
    {
        return view('admin.vehicle-options.edit', [
            'option' => $vehicleOption,
            'types' => VehicleOption::TYPES,
        ]);
    }

    /**
     * Update the specified option.
     */
    public function update(Request $request, VehicleOption $vehicleOption)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:' . implode(',', array_keys(VehicleOption::TYPES)),
            'key' => 'required|string|max:50|unique:vehicle_options,key,' . $vehicleOption->id . ',id,type,' . $request->type,
            'label' => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $oldType = $vehicleOption->type;
        $validated['key'] = strtolower(str_replace(' ', '_', $validated['key']));
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $vehicleOption->update($validated);
        
        // Clear cache for both old and new type if changed
        VehicleOption::clearCache($oldType);
        if ($oldType !== $validated['type']) {
            VehicleOption::clearCache($validated['type']);
        }

        return redirect()
            ->route('admin.vehicle-options.index', ['type' => $validated['type']])
            ->with('success', 'Option updated successfully.');
    }

    /**
     * Remove the specified option.
     */
    public function destroy(VehicleOption $vehicleOption)
    {
        $type = $vehicleOption->type;
        $vehicleOption->delete();
        VehicleOption::clearCache($type);

        return redirect()
            ->route('admin.vehicle-options.index', ['type' => $type])
            ->with('success', 'Option deleted successfully.');
    }

    /**
     * Seed default options.
     */
    public function seedDefaults()
    {
        VehicleOption::seedDefaults();

        return redirect()
            ->route('admin.vehicle-options.index')
            ->with('success', 'Default options seeded successfully.');
    }
}
