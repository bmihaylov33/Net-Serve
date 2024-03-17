<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Retrieves an OAuth access token for the Infiny API
     *
     * @return string The access token
     */
    protected function getAccessToken()
    {
        $apiUrl = env('INFINITY_API_URL');
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.cloudlx.v1+json'
        ])->post("{$apiUrl}/api/oauth2/access-token", [
            'grant_type' => 'client_credentials',
            'client_id' => env('INFINY_CLIENT_ID'),
            'client_secret' => env('INFINY_CLIENT_SECRET'),
        ]);

        if ($response->successful()) {
            $accessToken = $response->json()['access_token'];
            $refreshToken = $response->json()['refresh_token'];
            
            Session::put('access_token', $accessToken);
            Session::put('refresh_token', $refreshToken);
            
            return $accessToken;
        } else {
            return response()->json(
                ['error' => 'Login failed'], 
                $response->status(),
            );
        }
    }

    /**
     * Authenticates a user using the Infiny API
     *
     * @param Request $request The request object
     * @return string The access token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return $this->getAccessToken();
        }

        return response()->json(['error' => 'Wrong credentials!'], 401);
    }

    /**
     * Registers a new user with the Infiny API
     *
     * @param Request $request The request object
     * @return string The access token
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return $this->getAccessToken();
        } else {
            return response()->json(['error' => 'Registration failed'], 402);
        }

    }
}
