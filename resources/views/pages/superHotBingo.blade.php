@extends('layout')

@section('content')
    <link rel="stylesheet" href="/css/mines.css">
    <link rel="stylesheet" href="/css/tower.css">

    <style>
        /* Adicionando estilos para ocupar uma grande parte da tela e manter aspecto quadrado */
        .tower_tower__1ms3K {
            position: relative;
            width: 60vw; /* Largura em relação à largura da tela - ajuste conforme necessário */
            height: 60vw; /* Altura em relação à largura da tela - ajuste conforme necessário */
            margin: 5vh auto; /* Margens superior e inferior de 5% da altura da tela, centralizado horizontalmente */
            overflow: hidden;
        }

        .tower_tower__1ms3K iframe {
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
