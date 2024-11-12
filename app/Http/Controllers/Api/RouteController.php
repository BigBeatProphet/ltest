<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Routes;
use Illuminate\Http\Request;

class RouteController extends Controller{
    public function index(){
        return Routes::all();
    }

    public function store(Request $request){
        $request->validate([
            'busid' => 'required|exists:buses,id',
            'routename' => 'required|string|max:255',
            'stops' => 'required|array',
            'stops.*' => 'exists:stops,id',
        ]);
    
        $route = Routes::create([
            'busid' => $request->busid,
            'routename' => $request->routename,
            'stops' => json_encode($request->stops),
        ]);
    
        return response()->json($route, 201);
    }

    public function show($id){
        return Routes::findOrFail($id);
    }

    public function update(Request $request, $id){
        $request->validate([
            'routename' => 'required|string|max:255',
            'busid' => 'required|exists:buses,id',
            'stops' => 'required|array',
            'stops.*' => 'exists:stops,id',
        ]);
    
        $route = Routes::findOrFail($id);
        $route->routename = $request->routename;
        $route->busid = $request->busid;
        $route->stops = json_encode($request->stops);
        $route->save();
    
        return response()->json($route, 200);
    }
    

    public function destroy($id){
        $route = Routes::findOrFail($id);
        $route->delete();
        return response()->json(null, 204);
    }

    public function routeExists($busid, $routename, $stops)
    {
        return Routes::where('busid', $busid)
                     ->where('routename', $routename)
                     ->where('stops', '[]'::json) 
                     ->exists();
    }
}