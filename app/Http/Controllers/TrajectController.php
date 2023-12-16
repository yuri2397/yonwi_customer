<?php

namespace App\Http\Controllers;

use App\Models\Traject;
use Illuminate\Http\Request;

class TrajectController extends Controller
{
    // index of all trajects 
    public function index(Request $request)
    {
        $trajects = Traject::with($request->with ?? [])->get($request->columns ?? ['*']);
        return response()->json($trajects, 200);
    }

    // show traject by id
    public function show(Request $request, $id)
    {
        $traject = Traject::with($request->with ?? [])->find($id);
        if (!$traject) {
            return response()->json([
                "message" => "Traject not found"
            ], 404);
        }
        return response()->json($traject, 200);
    }

    // create traject
    public function create(Request $request)
    {
        $request->validate([
            "line" => "required|string",
            "from" => "required|string",
            "to" => "required|string",
            "distance" => "numeric"
        ]);

        $traject = Traject::create($request->only(["line", "from", "to", "distance"]));

        return response()->json([
            "message" => "Traject created",
            "traject" => $traject
        ], 201);
    }

    // config traject by id ,by adding points 
    public function configPoints(Request $request, $id)
    {
        $request->validate([
            "points" => "required|array",
            "points.*.latitude" => "required|numeric",
            "points.*.longitude" => "required|numeric"
        ]);

        $traject = Traject::find($id);
        if (!$traject) {
            return response()->json([
                "message" => "Traject not found"
            ], 404);
        }

        $traject->points()->delete();
        foreach ($request->points as $point) {
            $traject->points()->create($point);
        }

        return response()->json([
            "message" => "Traject configured",
            "traject" => $traject
        ], 200);
    }

    // config stops
    public function configStops(Request $request, $id)
    {
        $request->validate([
            "stops" => "required|array",
            "stops.*.latitude" => "required|numeric",
            "stops.*.longitude" => "required|numeric"
        ]);

        $traject = Traject::find($id);
        if (!$traject) {
            return response()->json([
                "message" => "Traject not found"
            ], 404);
        }

        $traject->stops()->delete();
        foreach ($request->stops as $stop) {
            $traject->stops()->create($stop);
        }

        return response()->json([
            "message" => "Traject configured",
            "traject" => $traject
        ], 200);
    }

    public function trajectByLine(Request $request, $line)
    {
        $traject = Traject::whereLine($line)->with($request->with ?? ['points', 'stops'])->first();
        if (!$traject) {
            return response()->json([
                "message" => "Traject not found"
            ], 404);
        }
        return response()->json($traject, 200);
    }
}
