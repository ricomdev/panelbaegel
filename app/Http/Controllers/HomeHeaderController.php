<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HomeHeader;
use Illuminate\Http\Request;

class HomeHeaderController extends Controller
{

    public function update(Request $request)
    {
        $header = HomeHeader::firstOrFail();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $header->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Header actualizado correctamente'
        ]);
    }
}
