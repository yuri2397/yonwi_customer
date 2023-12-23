<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    // user connect to car from car reference. set car user_id
    public function connect(Request $request, $reference)
    {

        $car = Car::where("reference", $reference)->first();
        if (!$car) {
            return response()->json([
                "message" => "Car not found"
            ], 404);
        }

        $car->user_id = $request->user()->id;
        $car->save();

        return response()->json([
            "message" => "Car connected"
        ], 200);
    }

    // disconnected
    public function disconnect(Request $request, $reference)
    {
        $car = Car::where("reference", $reference)->whereUserId($request->user()->id)->first();
        if (!$car) {
            return response()->json([
                "message" => "Your are not connected to this car."
            ], 404);
        }

        $car->user_id = null;
        $car->save();

        return response()->json([
            "message" => "Car disconnected"
        ], 200);
    }

    // car car distance from (centerLat, centerLng) in request params
    public function distance(Request $request)
    {
        $request->validate([
            "reference" => "required|string",
            "centerLat" => "required|numeric",
            "centerLng" => "required|numeric"
        ]);

        $car = \App\Models\Car::where("reference", $request->reference)->first();
        if (!$car) {
            return response()->json([
                "message" => "Car not found"
            ], 404);
        }

        // calculate distance with haversine formula
        $distance = (
            6371 * acos(
                cos(deg2rad($request->centerLat)) * cos(deg2rad($car->latitude)) * cos(deg2rad($car->longitude) - deg2rad($request->centerLng)) + sin(deg2rad($request->centerLat)) * sin(deg2rad($car->latitude))
            )
        );

        // add km ou m to distance
        if ($distance < 1) {
            $distance = round($distance * 1000) . " m";
        } else {
            $distance = round($distance, 2) . " km";
        }

        return response()->json([
            "distance" => $distance
        ], 200);
    }

    // car list by number 
    public function index(Request $request)
    {
        $request->validate([
            "line" => "exists:trajects,line",
            "centerLat" => "required|numeric",
            "centerLng" => "required|numeric",
            "radius" => "required|numeric"
        ]);
        $cars = Car::query();

        // with
        $cars->with($request->with ?? []);

        if ($request->line ) {
            $cars->whereHas("traject", function ($query) use ($request) {
                $query->where("line", $request->line);
            });
        }

        if ($request->centerLat && $request->centerLng && $request->radius) {
            $cars->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) as distance", [$request->centerLat, $request->centerLng, $request->centerLat]);
            $cars->havingRaw("distance < ?", [$request->radius]);
            $cars->orderBy("distance", "asc");
        }

        // add km or m to distance and calculate duration from speed
        $cars = $cars->get()->map(function ($car) {
            $car->duration = round($car->distance / ($car->speed ?? 18), 2);
            // add m ou h to duration
            if ($car->duration < 1) {
                $car->duration = round($car->duration * 60) . " m";
            } else {
                $car->duration = round($car->duration, 2) . " h";
            }

            if ($car->distance < 1) {
                $car->distance = round($car->distance * 1000) . " m";
            } else {
                $car->distance = round($car->distance, 2) . " km";
            }
            return $car;
        });

        return response()->json($cars, 200);
    }

    // show car
    public function show(Request $request, Car $car)
    {

    }
}
