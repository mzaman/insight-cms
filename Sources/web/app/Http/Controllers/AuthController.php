<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\UserRepositoryInterface;

class AuthController extends Controller
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        if(Auth::check()) Auth::logout();

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        return $this->responseWith(user: Auth::user(), token: $token);

    }

    public function register(Request $request){
        if(Auth::check()) Auth::logout();

        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role_id' => 'numeric',
            'password' => 'required|string|min:6',
        ]);

        $user = $this->userRepository->create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'role_id' => $fields['role_id'],
            'password' => Hash::make($fields['password']),
        ]);

        $token = Auth::login($user);
        return $this->responseWith(user: $user, token: $token);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return $this->responseWith(user: Auth::user(), token: Auth::refresh());
    }

    protected function responseWith(...$params){
        $responseArr = [
            'status' => 'success',
            'user' => $params['user'],
            'authorisation' => [
                'token' => $params['token'],
                'type' => 'bearer',
            ]
        ];
        return response()->json($responseArr);
    }
}
