<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buses;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        return Buses::all();
    }

    public function store(Request $request)
{
    $request->validate([
        'busname' => 'required|string',
    ]);

    $bus = Buses::create([
        'busname' => $request->busname,
    ]);

    return response()->json($bus, 201);
}

    public function show($id)
    {
        return Buses::findOrFail($id);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'BusName' => 'sometimes|required|string|max:255',
        ]);

        $bus = Buses::findOrFail($id);
        $bus->update($request->all());
        return response()->json($bus);
    }

    public function destroy($id)
    {
        $bus = Buses::findOrFail($id);
        $bus->delete();
        return response()->json(null, 204);
    }
}