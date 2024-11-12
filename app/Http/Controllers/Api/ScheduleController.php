<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedules;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return Schedules::with(['bus', 'stop'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'busid' => 'required|exists:buses,id',
            'stopid' => 'required|exists:stops,id',
            'arrivaltime' => 'required|date_format:H:i',
        ]);

        $schedule = Schedules::create($request->all());
        return response()->json($schedule, 201);
    }

    public function show($id)
    {
        return Schedules::with(['bus', 'stop'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'busid' => 'sometimes|required|exists:buses,id',
            'stopid' => 'sometimes|required|exists:stops,id',
            'arrivaltime' => 'sometimes|required|date_format:H:i',
        ]);

        $schedule = Schedules::findOrFail($id);
        $schedule->update($request->all());
        return response()->json($schedule);
    }

    public function destroy($id)
    {
        $schedule = Schedules::findOrFail($id);
        $schedule->delete();
        return response()->json(null, 204);
    }
}