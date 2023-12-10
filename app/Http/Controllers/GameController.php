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
use App\Salsa;
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
        $user = User::where('salsa_token', $this->token)->first();
        $user->balance = $user->balance * 100;
        $this->userLogged = trim($this->token);

        Log::info('webhook called', [
            '$method' => $method,
            '$user' => $user,

        ]);

        switch ($method):

            case 'GetAccountDetails':
                return $this->GetAccountDetails($params, $user);
                break;

            case 'GetBalance':
                return $this->GetBalance($params, $user);
                break;

            case 'PlaceBet':
                return $this->PlaceBet($params, $user);
                break;

            case 'AwardWinnings':
                return $this->AwardWinnings($params, $user);
                break;

            case 'RefundBet':
                return $this->RefundBet($params, $user);
                break;

            case 'ChangeGameToken':
                return $this->ChangeGameToken($params, $user);
                break;
            default:
                return 'nada encontrado.';

        endswitch;
    }

    public function compareHash($params, $token) {      
        $flattenedParams = $this->flattenArray($params);

        $computedHash = hash('sha256', $flattenedParams . $token);

        Log::info('compareHash called', [
            '$computedHash' => $computedHash,
        ]);
    
        return  $computedHash;
    }

    protected function flattenArray($array) {
        $result = [];
    
        foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($array)) as $value) {
            $result[] = $value;
        }
    
        return implode('', $result);
    }
    
    public function getAccountDetails($params, $user) {
    
        if ($this->token) {
            
            if ($this->compareHash($params, $user->salsa_token)) {
                $response = "<PKT>
                    <Result Name='GetAccountDetails' Success='1'>
                        <Returnset>
                            <Token Type='string' Value='$user->salsa_token' />
                            <LoginName Type='string' Value='$user->username' />
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

        Log::info('Response GetAccountDetails', [
            'GetAccountDetails' => $response,
        ]);
    
        return response($response)
        ->header('Content-Type', 'text/xml; charset=UTF-8');
    }
    

    public function GetBalance($params, $user){
    
        if ($this->token) {
            if ($this->compareHash($params, $this->token)) {
                $response = "<PKT>
                    <Result Name='GetBalance' Success='1'>
                        <Returnset>
                            <Token Type='string' Value='$user->salsa_token' />
                            <Balance Type='int' Value='$user->balance' />
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

        Log::info('Response GetAccountDetails1', [
            'GetAccountDetails1' => $response,
        ]);
    
        return response($response)
        ->header('Content-Type', 'text/xml; charset=UTF-8');
    }

    public function PlaceBet($params, $user){
        $user->update(['balance' => ($user->balance / 100) - (intval($params['BetAmount']['@attributes']['Value']) / 100)]);
        if ($this->token) {
            if ($this->compareHash($params, $this->token)) {
                $response = "<PKT>
                    <Result Name='PlaceBet' Success='1'>
                        <Returnset>
                            <Token Type='string' Value='$user->salsa_token' />
                            <Balance Type='int' Value='$user->balance' />
                            <Currency Type='string' Value='BRL' />
                            <ExtTransactionID Type='long' Value='{$params['TransactionID']['@attributes']['Value']}' />
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

        Log::info('Response GetAccountDetails2', [
            'GetAccountDetails2' => $response,
        ]);
    
        return response($response)
        ->header('Content-Type', 'text/xml; charset=UTF-8');
    }

    public function AwardWinnings($params, $user){
        $user->update(['balance' => ($user->balance / 100) + ($params['WinAmount']['@attributes']['Value'] / 100)]);
        if ($this->token) {
            if ($this->compareHash($params, $this->token)) {
                $response = "<PKT>
                    <Result Name='AwardWinnings' Success='1'>
                        <Returnset>
                            <Token Type='string' Value='$user->salsa_token' />
                            <Balance Type='int' Value='$user->balance' />
                            <Currency Type='string' Value='BRL' />
                            <ExtTransactionID Type='long' Value='{$params['TransactionID']['@attributes']['Value']}' />
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

        Log::info('Response GetAccountDetails3', [
            'GetAccountDetails3' => $response,
        ]);
    
        return response($response)
        ->header('Content-Type', 'text/xml; charset=UTF-8');
    }

    public function RefundBet($params, $user){
        $user->update(['balance' => ($user->balance / 100) + ($params['RefundAmount']['@attributes']['Value'] / 100)]);
        if ($this->token) {
            if ($this->compareHash($params, $this->token)) {
                $response = "<PKT>
                    <Result Name='RefundBet' Success='1'>
                        <Returnset>
                            <Token Type='string' Value='$user->salsa_token' />
                            <Balance Type='int' Value='$user->balance' />
                            <Currency Type='string' Value='BRL' />
                            <ExtTransactionID Type='long' Value='{$params['TransactionID']['@attributes']['Value']}' />
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

        Log::info('Response GetAccountDetails4', [
            'GetAccountDetails4' => $response,
        ]);
    
        return response($response)
        ->header('Content-Type', 'text/xml; charset=UTF-8');
    }

    public function ChangeGameToken($params, $user){
    
        if ($this->token) {
            if ($this->compareHash($params, $this->token)) {
                $response = "<PKT>
                    <Result Name='ChangeGameToken' Success='1'>
                        <Returnset>
                            <NewToken Type='string' Value='{$params['NewGameReference']['@attributes']['Value']}' />
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
    
        return response($response)
        ->header('Content-Type', 'text/xml; charset=UTF-8');
    }

    
    

public function playGame($game_id)
{
    $namespace = Uuid::NAMESPACE_DNS;

    $userLogged = $this->user->username;

    $game = Salsa::where('id', $game_id)->first();

    if (!$game) {
        return response()->json(['error' => 'Jogo não encontrado'], 404);
    }

    $token = Uuid::uuid5($namespace, $userLogged)->toString();

    $url = "https://api-test.salsagator.com/game?token=$token&pn={$game->pn}&lang={$game->lang}&game={$game->game}";

    User::where('username', $userLogged)->update(['salsa_token' => $token]);

    Log::info('Response playGame', [
        'playGame' => $url,
    ]);

    return view('pages.superHotBingo', compact('url'));
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