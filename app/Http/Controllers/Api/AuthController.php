<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
        $request->validate([
            'national_id' => ['required'],
            'password' => ['required']
        ]);

        $credentials = $request->only('national_id', 'password');

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->responseWithToken($token);
    }

    public function logout(){
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(){
        return $this->responseWithToken(auth()->refresh());
    }

    public function me(){
        return response()->json(JWTAuth::user());
    }

    protected function responseWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

    public function register(Request $request){
        $validated = $request->validate([
            'national_id' => 'required|unique:users',
            'password' => 'required|min:6',
            'name' => 'required',
            'surname' => 'required',
            'phone_number' => 'required',
            'image_path' => 'required',
        ]);
        if (User::where('national_id', $validated['national_id'])->exists()) {
            return response()->json([
                'message' => 'national_id already exists',
            ], 400);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->move(public_path('images/user'), $request->image_path);
        }

        $user = User::create($validated);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $user,
            'access_token' => $token,
        ]);
    }
}
