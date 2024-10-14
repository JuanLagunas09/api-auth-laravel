<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email|string|max:100',
            'password' => 'required|string|min:8'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('API_TOKEN')->plainTextToken
        ], 201);
    }

    public function Login(Request $request)
    {
        $rules = [
            'email' => 'required|email|string|max:100',
            'password' => 'required|string|min:8'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (!Auth::attempt($request->all())) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('API_TOKEN')->plainTextToken
        ], 200);
    }

    public function Logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
