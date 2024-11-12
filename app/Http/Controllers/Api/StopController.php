<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stops;
use Illuminate\Http\Request;

class StopController extends Controller
{
    public function index(){
        return Stops::all();
    }

    public function store(Request $request){
        $request->validate([
            'stopname' => 'required|string|max:255',
        ]);

        $stop = Stops::create($request->all());
        return response()->json($stop, 201);
    }

    public function show($id){
        return Stops::findOrFail($id);
    }

    public function update(Request $request, $id){
        $request->validate([
            'stopname' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|max:255'
        ]);

        $stop = Stops::findOrFail($id);
        $stop->update($request->all());
        return response()->json($stop);
    }

    public function destroy($id){    
        $stop = Stops::findOrFail($id);
        $stop->delete();
        return response()->json(null, 204);
    }
}