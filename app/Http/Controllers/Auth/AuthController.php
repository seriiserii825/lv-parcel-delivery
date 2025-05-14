<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $service;
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function register(RegisterRequest $request)
    {
        $fields = $request->validated();
        $service_respone = $this->service->register($fields);


        return response()->json($service_respone, 201);
    }
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where(['email' => $fields['email']])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'errors' => [
                    'email' => ['The provided credentials are incorrect.']
                ]
            ], 401);
        }

        $token = $user->createToken($request->email)->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ], 200);
    }


    public function loginAdmin(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'errors' => [
                    'email' => ['The provided credentials are incorrect.']
                ]
            ], 401);
        }

        $token = $user->createToken($request->email)->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
