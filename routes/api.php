<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrajectController;


// usercontroller, prefix users, group, middleware auth:api
Route::prefix('users')->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', [UserController::class, 'logout']);
        Route::get('profile', [UserController::class, 'profile']);
    });
});

// car controller, prefix cars, group, middleware auth:sanctum
Route::prefix('cars')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [CarController::class, 'index'])->withoutMiddleware('auth:sanctum');
    Route::get('/{id}', [CarController::class, 'show'])->withoutMiddleware('auth:sanctum');
    Route::get('connect', [CarController::class, 'connect']);
    Route::get('disconnect', [CarController::class, 'disconnect']);
    Route::get('distance', [CarController::class, 'distance'])->withoutMiddleware('auth:sanctum');
});

Route::prefix('trajects')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TrajectController::class, 'index'])->withoutMiddleware('auth:sanctum');
    Route::get('/{line}', [TrajectController::class, 'trajectByLine'])->withoutMiddleware('auth:sanctum');
});

Route::get("/test", function(){
 $points = [
    [14.66364390357428, -17.437627637686088],
    [14.669016410623355, -17.439652615706105],
    [14.669196003114925, -17.437957070368352],
    [14.669842534864417, -17.43735063444463],
    [14.678960094761115, -17.437585289620603],
    [14.680092508888887, -17.43777615242703],
    [14.680190979400852, -17.438068808724065],
    [14.684252849485325, -17.440906302451566],
    [14.690183899643698, -17.442472953102342],
    [14.693398896524899, -17.44252183056069],
    [14.696755681126136, -17.442342613176038],
    [14.723767310596912, -17.440632461362522],
    [14.737347913895904, -17.43937909866167],
    [14.737930762409206, -17.43915562930278],
    [14.739282859034954, -17.438453235116988],
    [14.740647885869414, -17.437249130798484],
    [14.74169591019106, -17.435991510696848],
    [14.742866844943672, -17.432399266123785],
    [14.743326160193021, -17.430325530842406],
    [14.745754432295422, -17.41768915559413],
    [14.745685566197432, -17.417953655276122],
    [14.745774108360129, -17.416020772170548],
    [14.745705242236706, -17.414077715995994],
    [14.74583313644858, -17.41095458382014]
 ];
    $points = array_map(function($point){
        return [
            "latitude" => $point[0],
            "longitude" => $point[1]
        ];
    }, $points);

    $traject = \App\Models\Traject::first();

    $traject->points()->createMany($points);
    return $traject->points;
});
