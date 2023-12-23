<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // login
    public function login(Request $request)
    {
        $request->validate([
            "phone" => "required|string",
            "password" => "required"
        ]);
        
        $user = User::where("phone", $request->phone)->first();
        if (!auth()->attempt($request->only("phone", "password"))) {
            return response()->json([
                "message" => "Invalid login details"
            ], 401);
        }

        return response()->json([
            "user" =>  $user,
            "token" =>  $user->createToken("token")->plainTextToken
        ], 200);
    }

    // register
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "phone" => "required|string|unique:users",
            "password" => "required|confirmed"
        ]);

        $user = User::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "password" => bcrypt($request->password)
        ]);

        return response()->json([
            "user" =>  $user,
            "token" =>  $user->createToken("token")->plainTextToken
        ], 201);
    }

    // profile
    public function profile(Request $request)
    {
        return response()->json([
            "user" =>  $request->user()
        ], 200);
    }

    // connected car
    public function connectedCar() {
        return User::with('car')->find(auth()->id());
    }

    // logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            "message" => "Logged out"
        ], 200);
    }
}
