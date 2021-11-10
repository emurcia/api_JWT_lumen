<?php

namespace App\Http\Controllers;

// añadido para JWT
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

// validador
use Illuminate\Support\Facades\Validator;

// agregado para autenticarse JWT
use App\Models\User;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:5',
        ]);

        $user = new User;
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->password = app('hash')->make($request->input('password'));
        $user->save();

        return response()->json(['message' => 'created'], 201);
    }

    public function respondWithToken($token)
    {
        // Return a token response to the user
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        // Add the token to a blacklist here
        auth()->logout();
        return response()->json(['message' => 'Logout Successfully !!!!'], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }



    public function me()
    {
        return response()->json(auth()->user());
    }
}