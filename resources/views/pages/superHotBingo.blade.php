@extends('layout')

@section('content')
    <link rel="stylesheet" href="/css/mines.css">
    <link rel="stylesheet" href="/css/tower.css">

    <style>
        /* Adicionando estilos para ocupar toda a tela e manter aspecto quadrado */
        .tower_tower__1ms3K {
            position: relative;
            width: 100%;
            padding-bottom: 100%; /* Isso cria um contêiner quadrado */
            overflow: hidden;
        }

        .tower_tower__1ms3K iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0; /* Remova a borda se desejar */
        }
    </style>

    <div class="section game-section">
        <div class="container">
            <div class="game">
                <div class="game-component">
                    <div class="tower_tower__1ms3K">
                        <iframe
                            src="https://api-test.salsagator.com/game?token=teste2&pn=playbet-staging&lang=en&game=superHotBingo"></iframe>
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
