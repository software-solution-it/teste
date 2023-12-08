<?php namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Redis;
use Illuminate\Http\Request;
use RecursiveIteratorIterator;
use RecursiveArrayIterator;
use Illuminate\Support\Facades\Log;
use App\User;
use Ramsey\Uuid\Uuid;
use Auth;
class GameController extends Controller
{
    private $balance;
    private $token;
    private $userLogged;

    public function __construct()
    {
        parent::__construct();
        $this->redis = Redis::connection();
    }

    public function index()
    {

        $userLogged = $this->user->username;

        Log::info('User called', [
            'user' => $this->user->username,
        ]);

        return view('pages.superHotBingo', compact('userLogged'));
    }

    public function login(Request $r){
        $brand_id = $r->input('brand_id');
        $sign = $r->input('sign');
        $token = $r->input('token');
        $brand_uid = $r->input('brand_uid');
        $currency = $r->input('currency');
        $user = User::where('username', $brand_uid)->first();

        $originalString = $user->balance;
        $val = str_replace(",",".",$originalString);
        $val = preg_replace('/\.(?=.*\.)/', '', $originalString);

        $data = [
            'code' => 1000,
            'msg' => 'Success',
            'data' => [
                'brand_uid' => $brand_uid,
                'currency' => $currency,
                'balance' => floatval($val)
            ]
        ];

        return $data;
    }

    public function wager(Request $request){
        $brand_uid = $request->input('brand_uid');
        $currency = $request->input('currency');
        $amount = $request->input('amount');
        $user = User::where('username', $brand_uid)->first();
    
        if ($user && $user->balance >= $amount) {
            $user->update(['balance' => $user->balance - $amount]);
    
            $response = [
                'code' => 1000,
                'msg' => 'Success',
                'data' => [
                    'brand_uid' => $brand_uid,
                    'currency' => $currency,
                    'balance' => $user->balance
                ]
            ];
        } else {
            $response = [
                'code' => 5003,
                'msg' => 'Insufficient funds',
                'data' => null
            ];
        }
    
        return $response;
    }

    public function endWager(Request $request){

        $brand_id = $request->input('brand_id');
        $sign = $request->input('sign');
        $brand_uid = $request->input('brand_uid');
        $currency = $request->input('currency');
        $amount = $request->input('amount');
        $round_id = $request->input('round_id');
        $wager_id = $request->input('wager_id');
        $provider = $request->input('provider');
        $is_endround = $request->input('is_endround');
        $game_result = $request->input('game_result');
        $user = User::where('username', $brand_uid)->first();

        Log::info('Controller called', [
            'brand_id' => $brand_id,
            'sign' => $sign,
            'brand_uid' => $brand_uid,
            'currency' => $currency,
            'amount' => $amount,
            'round_id' => $round_id,
            'wager_id' => $wager_id,
            'provider' => $provider,
            'game_result' => $game_result,
        ]);

        $user->update(['balance' => $user->balance + $amount]);
        $user->update(['requery' => $user->requery + $amount]);
    
        $response = [
            'code' => 1000,
            'msg' => 'Success',
            'data' => [
                'brand_uid' => $brand_uid,
                'currency' => $currency,
                'balance' => $user->balance
            ]
        ];
    
        return $response;
    }

    public function appendWagger(Request $request){
        $brand_id = $request->input('brand_id');
        $sign = $request->input('sign');
        $brand_uid = $request->input('brand_uid');
        $currency = $request->input('currency');
        $amount = $request->input('amount');
        $game_id = $request->input('game_id');
        $game_name = $request->input('game_name');
        $round_id = $request->input('round_id');
        $wager_id = $request->input('wager_id');
        $provider = $request->input('provider');
        $description = $request->input('description');
        $is_endround = $request->input('is_endround');

        $user = User::where('username', $brand_uid)->first();

        if ($user && $user->balance >= $amount) {
            $user->update(['balance' => $user->balance - $amount]);
    
            $response = [
                'code' => 1000,
                'msg' => 'Success',
                'data' => [
                    'brand_uid' => $brand_uid,
                    'currency' => $currency,
                    'balance' => $user->balance
                ]
            ];
        } else {
            $response = [
                'code' => 5003,
                'msg' => 'Insufficient funds',
                'data' => null
            ];
        }
    
        return $response;
    }

    public function cancelWager(Request $request){
        $brand_id = $request->input('brand_id');
        $sign = $request->input('sign');
        $brand_uid = $request->input('brand_uid');
        $currency = $request->input('currency');
        $round_id = $request->input('round_id');
        $wager_id = $request->input('wager_id');
        $provider = $request->input('provider');
        $wager_type = $request->input('wager_type');
        $is_endround = $request->input('is_endround');

        $user = User::where('username', $brand_uid)->first();
    
    
        $response = [
            'code' => 1000,
            'msg' => 'Success',
            'data' => [
                'brand_uid' => $brand_uid,
                'currency' => $currency,
                'balance' => $user->balance
            ]
        ];
    
        return $response;
    }
    

    public function webhook(Request $request)
    {
        $xmlstring = $request->getContent();

        $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        $method = $array['Method']['@attributes']['Name'];
        $params = $array['Method']['Params'];

        $this->token = $params['Token']['@attributes']['Value'];
        $this->userLogged = trim($this->token);
        $data = json_decode(base64_decode($this->token), true);

        Log::info('Webhook called', [
            'data' => $data,
            'token' => $this->token,
            'method' => $method,
            'user' => $this->userLogged,
        ]);

        switch ($method):

            case 'GetAccountDetails':
                return $this->GetAccountDetails($params);
                break;

            case 'GetBalance':
                return $this->GetBalance($params);
                break;

            case 'PlaceBet':
                return $this->PlaceBet($params);
                break;

            case 'AwardWinnings':
                return $this->AwardWinnings($params);
                break;

            case 'RefundBet':
                return $this->RefundBet($params);
                break;

            case 'ChangeGameToken':
                return $this->ChangeGameToken($params);
                break;
            default:
                return 'nada encontrado.';

        endswitch;
    }

    public function compareHash($params, $token) {
        $key = "Gustavo2 ";        
        Log::info('compareHash called', [
            '$params' => $params,
        ]);
        $flattenedParams = $this->flattenArray($params);
        Log::info('compareHash called', [
            '$params222222' => $flattenedParams,
        ]);

        $computedHash = hash('sha256', $flattenedParams . $key);
    
        return  true;
    }

    protected function flattenArray($array) {
        $result = [];
    
        foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($array)) as $value) {
            $result[] = $value;
        }
    
        return implode('', $result);
    }
    
    public function getAccountDetails($params) {
        $user = User::where('username', $this->userLogged)->first();
    
        if ($this->token) {
            Log::info('compareHash called', [
                '$this->compareHash($params, $this->token)' => $this->compareHash($params, $this->token),
            ]);
            
            if ($this->compareHash($params, $this->token)) {
                $response = "<PKT>
                    <Result Name='GetAccountDetails' Success='1'>
                        <Returnset>
                            <Token Type='string' Value='{$this->token}' />
                            <LoginName Type='string' Value='{$user->username}' />
                            <Currency Type='string' Value='BRL' />
                            <Country Type='string' Value='BR' />
                            <Birthdate Type='date' Value='1988-08-02' />
                            <Registration Type='date' Value='2010-05-05' />
                            <Gender Type='string' Value='m' />
                        </Returnset>
                    </Result>
                </PKT>";
            } else {
                $response = "<PKT>
                    <Result Name='GetAccountDetails' Success='0'>
                        <Returnset>
                            <Error Value='Invalid Hash.' />
                            <ErrorCode Value='7000' />
                        </Returnset>
                    </Result>
                </PKT>";
            }
        } else {
            $response = "<PKT>
                <Result Name='GetAccountDetails' Success='0'>
                    <Returnset>
                        <Error Value='Error retrieving Token.' />
                        <ErrorCode Value='1' />
                    </Returnset>
                </Result>
            </PKT>";
        }
    
        return $response;
    }
    

    public function GetBalance($params){
        $user = User::where('username', $this->userLogged)->first();
    
        if ($this->token) {
            if ($this->compareHash($params, $this->token)) {
                $response = "<PKT>
                    <Result Name='GetBalance' Success='1'>
                        <Returnset>
                            <Token Type='string' Value='{$this->token}' />
                            <Balance Type='string' Value='{$user->balance}' />
                            <Currency Type='string' Value='BRL' />
                        </Returnset>
                    </Result>
                </PKT>";
            } else {
                $response = "<PKT>
                    <Result Name='GetBalance' Success='0'>
                        <Returnset>
                            <Error Value='Invalid Hash.' />
                            <ErrorCode Value='7000' />
                        </Returnset>
                    </Result>
                </PKT>";
            }
        } else {
            $response = "<PKT>
                <Result Name='GetBalance' Success='0'>
                    <Returnset>
                        <Error Value='Insufficient funds.' />
                        <ErrorCode Value='6' />
                    </Returnset>
                </Result>
            </PKT>";
        }
    
        return $response;
    }

    public function PlaceBet($params){
        $user = User::where('username', $this->userLogged)->first();
    
        if ($this->token) {
            if ($this->compareHash($params, $this->token)) {
                $response = "<PKT>
                    <Result Name='PlaceBet' Success='1'>
                        <Returnset>
                            <Token Type='string' Value='{$this->token}' />
                            <Balance Type='int' Value='{$user->balance}' />
                            <Currency Type='string' Value='BRL' />
                            <ExtTransactionID Type='long' Value='$params->TransactionID' />
                            <AlreadyProcessed Type='bool' Value='true' />
                        </Returnset>
                    </Result>
                </PKT>";
            } else {
                $response = "<PKT>
                    <Result Name='PlaceBet' Success='0'>
                        <Returnset>
                            <Error Value='Invalid Hash.' />
                            <ErrorCode Value='7000' />
                        </Returnset>
                    </Result>
                </PKT>";
            }
        } else {
            $response = "<PKT>
                <Result Name='PlaceBet' Success='0'>
                    <Returnset>
                        <Error Value='Transaction not found.' />
                        <ErrorCode Value='7' />
                    </Returnset>
                </Result>
            </PKT>";
        }
    
        return $response;
    }

    public function AwardWinnings($params){
        $user = User::where('username', $this->userLogged)->first();
    
        if ($this->token) {
            if ($this->compareHash($params, $this->token)) {
                $response = "<PKT>
                    <Result Name='AwardWinnings' Success='1'>
                        <Returnset>
                            <Token Type='string' Value='{$this->token}' />
                            <Balance Type='int' Value='{$user->balance}' />
                            <Currency Type='string' Value='BRL' />
                            <ExtTransactionID Type='long' Value='$params->TransactionID' />
                            <AlreadyProcessed Type='bool' Value='true' />
                        </Returnset>
                    </Result>
                </PKT>";
            } else {
                $response = "<PKT>
                    <Result Name='AwardWinnings' Success='0'>
                        <Returnset>
                            <Error Value='Invalid Hash.' />
                            <ErrorCode Value='7000' />
                        </Returnset>
                    </Result>
                </PKT>";
            }
        } else {
            $response = "<PKT>
                <Result Name='AwardWinnings' Success='0'>
                    <Returnset>
                        <Error Value='Transaction not found.' />
                        <ErrorCode Value='7' />
                    </Returnset>
                </Result>
            </PKT>";
        }
    
        return $response;
    }

    public function RefundBet($params){
        $user = User::where('username', $this->userLogged)->first();
    
        if ($this->token) {
            if ($this->compareHash($params, $this->token)) {
                $response = "<PKT>
                    <Result Name='RefundBet' Success='1'>
                        <Returnset>
                            <Token Type='string' Value='{$this->token}' />
                            <Balance Type='int' Value='{$user->balance}' />
                            <Currency Type='string' Value='BRL' />
                            <ExtTransactionID Type='long' Value='{$params['TransactionID']}' />
                            <AlreadyProcessed Type='bool' Value='true' />
                        </Returnset>
                    </Result>
                </PKT>";
            } else {
                $response = "<PKT>
                    <Result Name='RefundBet' Success='0'>
                        <Returnset>
                            <Error Value='Invalid Hash.' />
                            <ErrorCode Value='7000' />
                        </Returnset>
                    </Result>
                </PKT>";
            }
        } else {
            $response = "<PKT>
                <Result Name='RefundBet' Success='0'>
                    <Returnset>
                        <Error Value='Transaction not found.' />
                        <ErrorCode Value='7' />
                        <Balance Type='int' Value='10000' />
                        <Currency Type='string' Value='BRL' />
                    </Returnset>
                </Result>
            </PKT>";
        }
    
        return $response;
    }

    public function ChangeGameToken($params){
        $user = User::where('username', $this->userLogged)->first();
    
        if ($this->token) {
            if ($this->compareHash($params, $this->token)) {
                $response = "<PKT>
                    <Result Name='ChangeGameToken' Success='1'>
                        <Returnset>
                            <NewToken Type='string' Value='{$params['NewGameReference']}' />
                        </Returnset>
                    </Result>
                </PKT>";
            } else {
                $response = "<PKT>
                    <Result Name='ChangeGameToken' Success='0'>
                        <Returnset>
                            <Error Value='Invalid Hash.' />
                            <ErrorCode Value='7000' />
                        </Returnset>
                    </Result>
                </PKT>";
            }
        } else {
            $response = "<PKT>
                <Result Name='ChangeGameToken' Success='0'>
                    <Returnset>
                        <Error Value='Transaction not found.' />
                        <ErrorCode Value='7' />
                    </Returnset>
                </Result>
            </PKT>";
        }
    
        return $response;
    }

    
    
    public function playGame($game_id){
        $api_url = 'https://gaming.stagedc.net';
        $chave_api = 'C93929113F374C90AB66CD206C901785';
        $id_marca = 'S119001';
        if ($this->user != null) {
        $brand_uid = $this->user->username;
        }else{
        $brand_uid = 'demo';
        }
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
                $jogos[$index]['local_image'] = str_replace(["'", ' ', " ", "(NFD)"], '', $nomeImagem);
            } else {
                $jogos[$index]['local_image'] = null;
            }
        }
        $jogos = array_filter($jogos, function ($game) {
            return $game['local_image'] !== null;
        });
    
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