<?php namespace App\Http\Controllers;

use App\User;
use App\Rooms;
use App\Profit;
use App\Jackpot;
use App\JackpotBets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class JackpotController extends Controller {

    public function __construct(Request $r) {
		parent::__construct();
		$rooms = Rooms::where('status', 0)->orderBy('id', 'desc')->get();
		foreach($rooms as $s) {
			$room = Rooms::where('name', $r->get('room'))->first();
			if(!$room) $this->room = $s->name;
			else $this->room = $room->name;
		}
		view()->share('rooms', $rooms);
		view()->share('room', $this->room);
		DB::connection()->getPdo()->exec('SET TRANSACTION ISOLATION LEVEL READ COMMITTED');
    }

	public function getRooms() {
		$room = Rooms::where('status', 0)->get();

		return $room;
	}

	public function index() {
		return view('pages.jackpot');
	}

	public function newGame(Request $r) {
	}

	public function parseJackpotGame($id) {
	}

	public function initRoom(Request $r) {
	}

	public function newBet(Request $r) {
	}

	public function adminBet(Request $r) {
	}

	public function addBetFake() {
		/*$room = Rooms::where('status', 0)->inRandomOrder()->first();
		$user = $this->getUser();

		$game = Jackpot::where('room', $room->name)->orderBy('id', 'desc')->first();

		if(is_null($room)) return [
			'success' => false,
            'fake' => $this->settings->fakebets,
			'msg' => '[ROOM #'.$room->name.'] - Não foi possível encontrar a sala em que você quer apostar!'
		];
		if(is_null($user)) return [
			'success' => false,
            'fake' => $this->settings->fakebets,
			'msg' => '[ROOM #'.$room->name.'] - Falha ao encontrar o usuário!'
		];
		if(is_null($game)) return [
			'success' => false,
            'fake' => $this->settings->fakebets,
			'msg' => '[ROOM #'.$room->name.'] - Não foi possível encontrar o jogo!'
		];

		if($game->status > 1) return [
			'success' => false,
            'fake' => $this->settings->fakebets,
			'msg' => '[ROOM #'.$room->name.'] - As apostas neste jogo estão encerradas!'
		];

		$sum = $room->min+mt_rand($this->settings->fake_min_bet * 2, $this->settings->fake_max_bet * 2) / 2;

		DB::beginTransaction();

		try {
			$userbets = JackpotBets::where('game_id', $game->id)->where('user_id', $user->id)->get();

			if($userbets->count() >= $room->bets) {
				DB::rollback();
				return [
					'success' => false,
            		'fake' => $this->settings->fakebets,
					'msg' => '[ROOM #'.$room->name.'] Você não pode fazer mais de '.$room->bets.' apostas neste jogo!'
				];
			}

			if(floatval($sum) < $room->min) {
				DB::rollback();
				return [
					'success' => false,
            		'fake' => $this->settings->fakebets,
					'msg' => '[ROOM #'.$room->name.'] Quantidade mínima de aposta R$ '.$room->min.'!'
				];
			}

			if(floatval($sum) > ($room->max - $userbets->sum('sum'))) {
				DB::rollback();
				return [
					'success' => false,
            		'fake' => $this->settings->fakebets,
					'msg' => '[ROOM #'.$room->name.'] Você não pode apostar mais do que R$ '.$room->max.' para este jogo!'
				];
			}

			if(is_null($user)) {
				DB::rollback();
				return [
					'success' => false,
            		'fake' => $this->settings->fakebets,
					'msg' => '[ROOM #'.$room->name.'] Erro desconhecido!'
				];
			}

			$bl = ['balance', 'balance'];
			$bl_true = $bl[array_rand($bl)];

			$balance = ($bl_true == 'balance') ? 'balance' : 'balance';
			$betType = JackpotBets::where('game_id', $game->id)->where('user_id', $user->id)->where('balance', '!=', $balance)->count();

			if($betType > 0) {
				DB::rollback();
				return [
					'success' => false,
            		'fake' => $this->settings->fakebets,
					'msg' => '[ROOM #'.$room->name.'] Você já fez uma aposta com saldo '. (($balance == 'balance') ? 'bônus' : 'real') .' счета!'
				];
			}
			if($balance != 'balance' && $balance != 'bonus') {
				DB::rollback();
				return [
					'success' => false,
            		'fake' => $this->settings->fakebets,
					'msg' => '[ROOM #'.$room->name.'] Falha ao determinar o tipo do seu saldo!'
				];
			}

			$bet = JackpotBets::where('game_id', $game->id)->where('user_id', $user->id)->first();
			DB::table('jackpot_bets')->insert([
				'room' => $room->name,
				'game_id' => $game->id,
				'user_id' => $user->id,
				'sum' => floatval($sum),
				'color' => ($bet) ? $bet->color : $this->getRandomColor(),
				'balance' => $balance,
				'fake' => 1
			]);

			DB::commit();
		} catch(Exception $e) {
			DB::rollback();
			return [
				'success' => false,
				'fake' => $this->settings->fakebets,
				'msg' => '[ROOM #'.$room->name.'] Erro desconhecido!'
			];
		}

		$data = $this->parseJackpotGame($game->id);
		if($data['success'] && count($data['data']['chances']) >= 2 && $game->status < 1) {
			Jackpot::where('id', $game->id)->update([
				'status' => 1
			]);
			$this->redis->publish('jackpot.timer', json_encode([
				'room' => $room->name,
				'time' => $room->time,
				'game' => $game->id
			]));
		}

		$this->redis->publish('jackpot', json_encode([
			'type' => 'update',
			'room' => $room->name,
			'data' => $data
		]));

		return [
			'success' => true,
			'fake' => $this->settings->fakebets,
			'msg' => '[ROOM #'.$room->name.'] Você apostou o valor com sucesso!'
		];*/

        return [
            'success' => true,
            'fake' => 1,
            'msg' => 'Você apostou o valor com sucesso!'
        ];
	}

	public function getSlider(Request $r) {
		$room = Rooms::where('name', $r->get('room'))->first();
		if(!$room) return [
			'success' => false,
			'msg' => 'Não foi possível encontrar uma sala '.$r->get('room')
		];

		$game = Jackpot::where('room', $room->name)->orderBy('id', 'desc')->first();
		if(!$game) return [
			'success' => false,
			'msg' => 'Não foi possível encontrar o jogo na sala '.$room->name
		];

		if($game->id != $r->get('game')) return [
			'success' => false,
			'msg' => 'Jogo encontrado #'.$game->id.'. não é #'.$r->get('game')
		];

		$data = $this->parseJackpotGame($game->id);
		if(!$data['success']) return [
			'success' => false,
			'msg' => 'Erro desconhecido! Tentando novamente...',
			'retry' => true
		];

		$data = $data['data'];

		$winnerBet = null;
		if(!$game->winner_id) {
			$winnerTicket = ($game->winner_ticket > 0) ? $game->winner_ticket : mt_rand(0, $data['bets'][0]['bet']['to']);
		} else {
			$winner2 = [];
			foreach($data['bets'] as $key => $d) {
				if($game->winner_id == $data['bets'][$key]['user']['user_id']) $winner2[] = $d['bet'];
			}
			$winner2 = $winner2[array_rand($winner2)];
			$winnerTicket = mt_rand($winner2['from'], $winner2['to']);
		}
		foreach($data['bets'] as $bet) if($bet['bet']['from'] <= $winnerTicket && $bet['bet']['to'] >= $winnerTicket) $winnerBet = $bet;
		if(is_null($winnerBet)) return [
			'success' => false,
			'msg' => 'Não foi possível encontrar um vencedor para esta aposta! Tentando novamente...',
			'retry' => true
		];

		DB::beginTransaction();
		try {
			DB::table('jackpot')->where('id', $game->id)->update([
				'winner_id' => $winnerBet['user']['user_id'],
				'winner_ticket' => $winnerTicket,
				'status' => 2
			]);

			$winner_money = $this->sendMoney($winnerBet['user']['user_id'], $game->id);

			DB::commit();
		} catch(Exception $e) {
			DB::rollback();
			return [
				'success' => false,
				'msg' => 'Erro desconhecido! Tentando novamente...',
				'retry' => true
			];
		}

		$rotate = [];
		foreach($data['chances'] as $key => $d) {
			if($winnerBet['user']['user_id'] == $data['chances'][$key]['user']['id']) $rotate = $d['circle'];
		}
		$cords = null;
		$center = $rotate['end']-$rotate['start'];
		if(floor($center) > 1) $cords = mt_rand(floor($rotate['start']), floor($rotate['end']));
		if(floor($center) < 1) $cords = $rotate['start'] + ($center/2);

		$this->redis->publish('jackpot', json_encode([
			'type' => 'slider',
			'room' => $room->name,
			'data' => [
				'cords' => 1440+$cords,
				'winner_id' => $winnerBet['user']['id'],
				'winner_name' => $winnerBet['user']['username'],
				'winner_avatar' => $winnerBet['user']['avatar'],
				'winner_balance' => $winner_money[0],
				'winner_bonus' => $winner_money[1],
				'ticket' => $winnerTicket
			]
		]));

		return [
			'success' => true
		];
	}

	private function sendMoney($user_id, $game_id) {
		$game = Jackpot::where('id', $game_id)->first();
		$bet = JackpotBets::where('game_id', $game->id)->where('user_id', $user_id)->first();

		$money_bets = JackpotBets::where('game_id', $game->id)->where('balance', 'balance')->sum('sum');
		$bonus_bets = JackpotBets::where('game_id', $game->id)->where('balance', 'bonus')->sum('sum');

		$w_bet_money = JackpotBets::where('game_id', $game->id)->where('user_id', $game->winner_id)->where('balance', 'balance')->sum('sum');
		$w_bet_bonus = JackpotBets::where('game_id', $game->id)->where('user_id', $game->winner_id)->where('balance', 'bonus')->sum('sum');

        $sum_money = round($w_bet_money + (($money_bets - $w_bet_money) - ($money_bets - $w_bet_money)/100*$this->settings->jackpot_commission), 2);
        $sum_bonus = round($w_bet_bonus + (($bonus_bets - $w_bet_bonus) - ($bonus_bets - $w_bet_bonus)/100*$this->settings->jackpot_commission), 2);

		$comission = round(($money_bets - $w_bet_money)/100*$this->settings->jackpot_commission, 2);

		$sum = [$sum_money, $sum_bonus];
		$user = User::where(['id' => $user_id, 'fake' => 0])->first();

		if(!is_null($user)) {
			if($bet->balance == 'balance') {
				$user->balance += $sum_money;
				$user->bonus += $sum_bonus;
				$user->requery += round((($money_bets - $w_bet_money) - ($money_bets - $w_bet_money)/100*$this->settings->jackpot_commission)/100*$this->settings->requery_perc, 3);
				$user->save();

				if($user->ref_id) {
					$ref = User::where('unique_id', $user->ref_id)->first();
					if($ref) {
						$ref_sum = round((($money_bets - $w_bet_money) - ($money_bets - $w_bet_money)/100*$this->settings->jackpot_commission)/100*$this->settings->ref_perc, 2);
						if($ref_sum > 0) {
							$ref->ref_money += $ref_sum;
							$ref->ref_money_all += $ref_sum;
							$ref->save();

							Profit::create([
								'game' => 'ref',
								'sum' => -$ref_sum
							]);
						}
					}
				}

				if($comission > 0) Profit::create([
					'game' => 'jackpot',
					'sum' => $comission
				]);

				$this->redis->publish('updateBalanceAfter', json_encode([
					'unique_id'	=> $user->unique_id,
					'balance'	=> round($user->balance, 2),
					'timer'		=> 8
				]));

				$this->redis->publish('updateBonusAfter', json_encode([
					'unique_id'	=> $user->unique_id,
					'bonus' 	=> round($user->bonus, 2),
					'timer'		=> 8
				]));
			}

			if($bet->balance == 'bonus') {
				$user->bonus += $sum_money+$sum_bonus;
				$user->save();

				$this->redis->publish('updateBonusAfter', json_encode([
					'unique_id'	=> $user->unique_id,
					'bonus'		=> round($user->bonus, 2),
					'timer'		=> 8
				]));
			}
		} else {
			$sum = [$sum_money, $sum_bonus];
			if($money_bets > 0) Profit::create([
				'game' => 'jackpot',
				'sum' => $money_bets
			]);
		}

		JackpotBets::where(['game_id' => $game->id, 'user_id' => $bet->user_id])->update([
			'win' => 1
		]);

        $game->winner_balance = $sum_money;
        $game->winner_bonus = $sum_bonus;
        $game->status = 3;
		$game->save();

		return $sum;
	}

	private function getRandomColor() {
        $color = str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
		return $color;
	}

	public function getGame(Request $r) {
		$room = $r->get('room');
		$option = Rooms::where('name', $room)->first();
		$game = Jackpot::where('room', $room)->orderBy('id', 'desc')->first();

        return response()->json([
            'room'      => $room,
            'game'      => $game->id,
            'time'      => $option->time,
            'status'    => $game->status
        ]);
    }

	public function history() {
		return view('pages.jackpotHistory');
    }

	public function initHistory(Request $r) {
		$room = Rooms::where('name', $r->get('room'))->first();
		if(is_null($room)) return [
			'success' => false
		];

        $games = Jackpot::where('room', $room->name)->where('status', 3)->where('updated_at', '>=', Carbon::today())->orderBy('game_id', 'desc')->limit(30)->get();

		$history = [];
        foreach($games as $game) {
            $winner = User::where('id', $game->winner_id)->first();
			$price = JackpotBets::where('game_id', $game->id)->sum('sum');
			$bet = JackpotBets::where('game_id', $game->id)->where('user_id', $winner->id)->sum('sum');
			$chance = round($bet/$price*100, 2);
			if(isset($winner)) {
				$history[] = [
					'game_id' => $game->game_id,
					'winner_id' => $winner->unique_id,
					'winner_name' => $winner->username,
					'winner_avatar' => $winner->avatar,
					'winner_chance' => $chance,
					'winner_balance' => $game->winner_balance,
					'winner_bonus' => $game->winner_bonus,
					'winner_ticket' => $game->winner_ticket,
					'hash' => $game->hash
				];
			}
        }

		return ['success' => true, 'history' => $history];
    }

	public function gotThis(Request $r) {
		$game_id = $r->get('game_id');
		$game = Jackpot::where('id', $game_id)->first();
		$userid = $r->get('user_id');
		$user = User::where('id', $userid)->first();
		$bets = JackpotBets::where(['game_id' => $game_id, 'user_id' => $user->id])->first();

		if(!$game->id) return [
			'msg'       => 'Falha ao obter o resultado do jogo!',
			'type'      => 'error'
		];

		if($game->status == 3) return [
			'msg'       => 'O jogo já começou!',
			'type'      => 'error'
		];

		if(!$userid) return [
			'msg'       => 'Falha ao obter ID do Jogador!',
			'type'      => 'error'
		];

		if(is_null($bets)) return [
			'msg'       => 'Este Jogador não fez uma aposta!',
			'type'      => 'error'
		];

		Jackpot::where('id', $game_id)->update([
			'winner_id' => $user->id
		]);

		return [
			'msg'       => 'Você modificou o jogador '.$user->username.' no modo Jackpot!',
			'type'      => 'success'
		];
	}

	private function getUser() {
        $user = User::where('fake', 1)->inRandomOrder()->first();
		if($user->time != 0) {
			$now = Carbon::now()->format('H');
			if($now < 06) $time = 4;
			if($now >= 06 && $now < 12) $time = 1;
			if($now >= 12 && $now < 18) $time = 2;
			if($now >= 18) $time = 3;
        	$user = User::where(['fake' => 1, 'time' => $time])->inRandomOrder()->first();
		}
        return $user;
    }
}
