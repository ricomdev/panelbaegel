<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        // Trae todo sin paginar
        $districts = \App\Models\District::with('province')
            ->orderBy('name')
            ->get();

        return view('district.index', compact('districts'));
    }

    /**
     * Actualizar un distrito existente.
     */
    public function update(Request $request, $id)
    {
        // Validación de datos
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'province_id' => 'required|exists:provinces,id',
            'price'       => 'nullable|numeric|min:0',
            'delivery'    => 'required|in:0,1'
        ]);

        // Buscar el distrito
        $district = District::findOrFail($id);

        // Actualizar campos
        $district->name        = $validated['name'];
        $district->province_id = $validated['province_id'];
        $district->price       = $validated['price'];
        $district->delivery    = $validated['delivery'];
        $district->save();

        // Respuesta JSON
        return response()->json([
            'success' => true,
            'message' => 'Distrito actualizado correctamente.',
            'district' => $district
        ]);
    }

    public function destroy($id)
    {
        $district = District::findOrFail($id);
        $district->delete();

        return response()->json(['success' => true]);
    }

    public function create()
    {
        $provinces = \App\Models\Province::orderBy('name')->get();
        return view('district.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'province_id' => 'required|exists:provinces,id',
            'price'       => 'nullable|numeric|min:0',
            'delivery'    => 'required|in:0,1',
        ]);

        $district = \App\Models\District::create($validated);

        return redirect()
            ->route('districts.index')
            ->with('success', 'Distrito creado correctamente.');
    }

    public function show(\App\Models\District $district)
    {
        $provinces = \App\Models\Province::orderBy('name')->get();
        return view('district.show', compact('district', 'provinces'));
    }


}
