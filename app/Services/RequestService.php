<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RequestService 
{

    public static function getHeadersApiFactus()
    {

        return [
            'Authorization' => 'Bearer ' . self::getAccesToken(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public static function getAccesToken(): String
    {
        //Verificar si el access_token esta en cache
        if(Cache::has('access_token')){
            return Cache::get('access_token');
        }
        
        $response = Http::withHeaders([
                'Accept'        => 'application/json',
            ])->asForm()->post(env('FACTUS_BASE_URL') . '/oauth/token', [
                'grant_type'    => 'password',
                'client_id'     => env('FACTUS_CLIENT_ID'),
                'client_secret' => env('FACTUS_CLIENT_SECRET'),
                'username'      => env('FACTUS_USERNAME'),
                'password'      => env('FACTUS_PASSWORD'),
            ]);
        
        if($response->successful()){
            //Guardar en cache el access_token con su respectivo refresh_token con su tiempo de expiracion.
            $data = $response->json();
            Cache::put('access_token', $data['access_token'], $data['expires_in']);

            Cache::put('refresh_token', $data['refresh_token'], $data['expires_in']);

            return  $data['access_token'];

        }else{
            abort(500, 'Error al obtener el access_token');
        }

    }
}