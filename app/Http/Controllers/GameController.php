<?php namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Redis;
use Illuminate\Http\Request;

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

        #'language' => 'pt-BR',
        #'channel' => 'pc',
        #'country_code' => 'BR'

        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        $response = $client->request('POST', $api_url . '/login', [
            'json' => $data
        ]);

        $responseBody = json_decode($response->getBody(), true);

        return response()->json(['message' => $responseBody['message']], $responseBody['code']);
    }
    
    public function playGame($game_id){
        $api_url = 'https://gaming.stagedc.net';
        $chave_api = 'C93929113F374C90AB66CD206C901785';
        $id_marca = 'S119001';
        $brand_uid = 'UserTest1';
        $token = strtoupper(str_random(32));

        $data = [
            'brand_id' => $id_marca,
            'sign' => strtoupper(md5($id_marca . $brand_uid . $chave_api)),
            'brand_uid' => $brand_uid,
            'token' => $token,
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

        $gameUrl = $responseBody['data']['game_url'];
        return redirect($gameUrl);
    }

    public function gameList(){
        $chave_api = 'C93929113F374C90AB66CD206C901785';
        $id_marca = 'S119001';
        $api_url = 'https://gaming.stagedc.net';
        
        $data = [
            'brand_id' => $id_marca,
            'sign' => strtoupper(md5($id_marca . $chave_api)),
        ];
        
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
        
        $response = $client->request('POST', $api_url . '/dcs/getGameList', [
            'json' => $data
        ]);
        
        $responseBody = json_decode($response->getBody(), true);
        
        // Adiciona a informação das imagens locais
        $jogos = $responseBody['data'];
        foreach ($jogos as $index => $game) {
            $idJogo = $game['game_id'];
            $caminhoPasta = public_path("images/games");
            $nomeImagem = $this->encontrarNomeImagem($caminhoPasta, $idJogo);
        
            if ($nomeImagem) {
                $jogos[$index]['local_image'] = $nomeImagem;
            } else {
                $jogos[$index]['local_image'] = null;
            }
        }

        $responseBody['data'] = $jogos;
        return response()->json($responseBody);
    }
    
    private function encontrarNomeImagem($caminho, $idJogo) {
        $arquivos = scandir($caminho);
        
        foreach ($arquivos as $arquivo) {
            if (strpos($arquivo, strval($idJogo)) !== false) {
                return "images/games/" . $arquivo;
            }
        }
    
        return "";
    }



}