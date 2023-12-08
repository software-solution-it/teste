@extends('layout')

@section('content')
<link rel="stylesheet" href="/css/mines.css">
<link rel="stylesheet" href="/css/tower.css">

<div class="section game-section">
    <div class="container">
        <div class="game">
            <div class="game-component">

                <div class="tower_tower__1ms3K">
                    <iframe
                        src="https://api-test.salsagator.com/game?token={{ $userLogged }} &pn=playbet-staging&lang=pt&game=superHotBingo"
                        frameborder="0" style="width:100%; height:100%;"></iframe>
                </div>
                <div class="hits_Hits__1OApa">
                    <div style="position: relative; height: 60px;" class="">
                        <div class="xs hits_HitRow__2xXX"
                            style="overflow-y: hidden; overflow-x: auto; position: absolute;">
                        </div>
                    </div>
                </div>


                @guest
                <div class="game-sign">
                    <div class="game-sign-wrap">
                        <div class="game-sign-block auth-buttons">
                            Você precisa estar logado para jogar
                            <button type="button" class="btn" id="loginRegister">Entrar ou Cadastrar</button>
                            </a>
                        </div>
                    </div>
                </div>
                @endguest
            </div>

        </div>
    </div>
</div>
@endsection