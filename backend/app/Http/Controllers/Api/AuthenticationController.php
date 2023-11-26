<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Http\Requests\Auth\ApiLoginRequest;
use App\Http\Requests\Auth\ApiRegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


class AuthenticationController extends Controller
{
    public function register(ApiRegisterRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        try {
            $user = User::create($credentials);
            return response()->json([
                'id' => $user->id,
                'email' => $user->email,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'E-mail address already exists'
            ], Response::HTTP_CONFLICT);
        }
    }

    public function login(ApiLoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            $token = $user->createToken('access')->plainTextToken;

            $cookie = cookie('token', $token, 60 * 24);

            return response()->json($user, Response::HTTP_OK)->withCookie($cookie);
        } else {
            return response()->json([
                'message' => 'Invalid Credentials!!',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return back()->withErrors([
            'email' => 'Invalid Credentials!!',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        Cookie::forget('token');

        return response()->noContent();
    }
}
