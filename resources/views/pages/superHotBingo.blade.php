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
                            src="https://api-test.salsagator.com/game?token=teste2&pn=playbet-staging&lang=en&game=superHotBingo" style="width:100%; height:100%;"></iframe>
                    </div>

                    @guest
                    <div class="game-sign">
                        <div class="game-sign-wrap">
                            <div class="game-sign-block auth-buttons">
                                Você precisa estar logado para jogar
                                <button type="button" class="btn" id="loginRegister">Entrar ou Cadastrar</button>
                            </div>
                        </div>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
@endsection
