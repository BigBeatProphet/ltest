<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buses;
use App\Models\Routes;
use App\Models\Stops;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FindController extends Controller{
    public function createRoute(Request $request){
        $request->validate([
            'routename' => 'required|string',
            'stops' => 'required|array',
            'stops.*' => 'exists:stops,id',
            'busid' => 'required|exists:buses,id',
        ]);

        $route = Routes::create([
            'routename' => $request->routename,
            'busid' => $request->busid,
            'stops' => json_encode($request->stops),
        ]);

        return response()->json(['message' => 'Route created successfully.']);
    }

    public function findBus(Request $request){
        $request->validate([
            'from' => 'required|exists:stops,id',
            'to' => 'required|exists:stops,id',
        ]);

        $fromStop = Stops::find($request->from);
        $toStop = Stops::find($request->to);

        $buses = Routes::where(function ($query) use ($fromStop, $toStop) {
            $query->whereJsonContains('stops', $fromStop->id)
                  ->orWhereJsonContains('stops', $toStop->id);
        })->with('bus')->get();

        $response = [
            'from' => $fromStop->stopname,
            'to' => $toStop->stopname,
            'buses' => [],
        ];

        foreach ($buses as $bus) {
            $nextArrivals = $this->getNextArrivals($bus->id);
            $response['buses'][] = [
                'route' => $bus->routename . ' в сторону ост. ' . $toStop->stopname,
                'next_arrivals' => $nextArrivals,
            ];
        }

        return response()->json($response);
    }

    private function getNextArrivals($routeId){
        $currentTime = Carbon::now();
        $nextArrivals = [];

        for ($i = 1; $i <= 3; $i++) {
            $nextArrivals[] = $currentTime->copy()->addMinutes(30 * $i)->format('H:i');
        }

        return $nextArrivals;
    }

    public function updateRoute(Request $request, $routeId){
        $request->validate([
            'stops' => 'required|array',
            'stops.*' => 'exists:stops,id',
            'busid' => 'required|exists:buses,id',
        ]);

        $route = Routes::findOrFail($routeId);
        $route->busid = $request->busid;
        $route->stops = json_encode($request->stops);
        $route->save();

        return response()->json(['message' => 'Route updated successfully.']);
    }
}