<?php namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Redis;
use Request;

class GameController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->redis = Redis::connection();
    }

    public function login(Request $r){

        $api_url = 'https://gaming.stagedc.net';
        $chave_api = 'C93929113F374C90AB66CD206C901785';
        $id_marca = 'S119001';
        $brand_uid = 'UserTest1';
        
        $data = [
            'brand_id' => $id_marca,
            'sign' => md5($id_marca . $brand_uid . $chave_api),
            'token' => $chave_api,
            'brand_uid' => $brand_uid,
            'currency' => 'BRL'
        ];
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($api_url . '/login', $data);
        
        $responseBody = $response->json();
        
        return response()->json(['message' => $responseBody['message']], $responseBody['code']);
    }


    
    public function play(Request $r){

        $game_id = $r->input('game_id');
        $api_url = 'https://gaming.stagedc.net';
        $chave_api = 'C93929113F374C90AB66CD206C901785';
        $id_marca = 'S119001';
        $brand_uid = 'UserTest1';

        $data = [
            'brand_id' => $id_marca,
            'sign' => md5($id_marca . $brand_uid . $chave_api),
            'brand_uid' => $brand_uid,
            'token' => $chave_api,
            'game_id' => $game_id,
            'currency' => 'BRL',
            'language' => 'pt-BR',
            'channel' => 'pc',
            'country_code' => 'BR'
        ];

        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        $response = $client->request('POST', $api_url . '/dcs/loginGame', [
            'json' => $data
        ]);

        $responseBody = json_decode($response->getBody(), true);

        if (isset($responseBody['game_url'])) {
            $gameUrl = $responseBody['game_url'];
            return response()->json(['game_url' => $gameUrl]);
        } else {
            return response()->json(['message' => $responseBody['msg']], $responseBody['code']);
        }
    }


    public function gameList(){

        $api_url = 'https://gaming.stagedc.net';
        $chave_api = 'C93929113F374C90AB66CD206C901785';
        $id_marca = 'S119001';
        
        $data = [
            'brand_id' => $id_marca,
            'sign' => md5($id_marca . $chave_api),
        ];
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($api_url . '/dcs/getGameList', $data);
        
        $responseBody = $response->json();
        
        return response()->json($responseBody);
    }



}