<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class NetworkServiceController extends Controller
{
    /**
     * Retrieves a list of network services
     *
     * @return array An array of network service objects
     */
    public function fetchNetworkServices()
    {
        $apiUrl = env('INFINITY_API_URL');
        $accessToken = Session::get('access_token');

        if (!is_null($accessToken)) {
            $response = Http::withHeaders([
                'Accept' => 'application/vnd.cloudlx.v1+json'
            ])->withToken($accessToken)
            ->get("{$apiUrl}/api/services");
    
            if (
                !$response->successful()
                && 401 === $response['status_code']
            ) {
                $this->refreshAccessToken();

                $response = Http::withHeaders([
                    'Accept' => 'application/vnd.cloudlx.v1+json'
                ])->withToken($accessToken)
                ->get("{$apiUrl}/api/services");
            }
            return $response->json();
        }
    }

    /**
     * Get a specific network service
     *
     * @param int $service_id The ID of the service to retrieve
     * @return array The service information
     */
    public function getNetworkService($service_id)
    {
        $apiUrl = env('INFINITY_API_URL');
        $accessToken = Session::get('access_token');

        if (!is_null($accessToken)) {
            $response = Http::withHeaders([
                'Accept' => 'application/vnd.cloudlx.v1+json'
            ])->withToken($accessToken)
            ->get("{$apiUrl}/api/services/{$service_id}/service");

            return $response->json();
        }
    }

    /**
     * Refreshes the access token using the refresh token.
     *
     * @return string|false The access token or false on failure.
     */
    protected function refreshAccessToken()
    {
        $apiUrl = env('INFINITY_API_URL');
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.cloudlx.v1+json'
        ])->post("{$apiUrl}/api/oauth2/refresh-token", [
            'grant_type' => 'client_credentials',
            'client_id' => env('INFINY_CLIENT_ID'),
            'client_secret' => env('INFINY_CLIENT_SECRET'),
            'refresh_token' => Session::get('refresh_token'),
        ]);

        if ($response->successful()) {
            $accessToken = $response->json()['access_token'];
            $refreshToken = $response->json()['refresh_token'];
            
            Session::put('access_token', $accessToken);
            Session::put('refresh_token', $refreshToken);
            
            return $accessToken;
        } else {
            return response()->json(
                ['error' => 'Refresh token failed'], 
                $response->status(),
            );
        }
    }
}
