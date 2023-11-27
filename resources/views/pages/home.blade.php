@extends('layout')
<meta charset="utf-8">
<link href="css/normalize.css" rel="stylesheet" type="text/css">
<link href="css/components.css" rel="stylesheet" type="text/css"> <link href="css/homes.css" rel="stylesheet"
    type="text/css"> <link rel="stylesheet" href="/css/introduction.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<link rel="stylesheet" href="https://unpkg.com/flickity@2.3.0/dist/flickity.css"> @section('content') <script> if
    (window.innerWidth> 600) { document.querySelector('.swiper - slide ').style.width=' calc(50 %) '; } </script>
    <script src="js/homes.js" type="text/javascript">
</script>

<!--Pixel-->
<script>
    !function (e, t) {"object "== typeof exports &&" object "== typeof module ? module.exports = t() :" function"== typeof define && define.amd ? define([], t) :" object "== typeof exports ? exports.install = t() : e.install = t()}(window, (function () {
        return function (e) { var t = {}; function n(r) { if (t[r]) return t[r].exports; var o = t[r] = { i: r, l: !1, exports: {} }; return e[r].call(o.exports, o, o.exports, n), o.l = !0, o.exports } return n.m = e, n.c = t, n.d = function (e, t, r) { n.o(e, t) || Object.defineProperty(e, t, { enumerable: !0, get: r }) }, n.r = function (e) {"undefined "!= typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, { value:" Module "}), Object.defineProperty(e,"_esModule ", { value: !0 }) }, n.t = function (e, t) { if (1 & t && (e = n(e)), 8 & t) return e; if (4 & t &&" object "== typeof e && e && e.esModule) return e; var r = Object.create(null); if (n.r(r), Object.defineProperty(r,"default", { enumerable: !0, value: e }), 2 & t &&" string "!= typeof e) for (var o in e) n.d(r, o, function (t) { return e[t] }.bind(null, o)); return r }, n.n = function (e) { var t = e && e.esModule ? function () { return e.default } : function () { return e }; return n.d(t,"a ", t), t }, n.o = function (e, t) { return Object.prototype.hasOwnProperty.call(e, t) }, n.p ="", n(n.s = 0) }([function (e, t, n) {"use strict "; var r = this && this._spreadArray || function (e, t, n) { if (n || 2 === arguments.length) for (var r, o = 0, i = t.length; o < i; o++)!r && o in t || (r || (r = Array.prototype.slice.call(t, 0, o)), r[o] = t[o]); return e.concat(r || Array.prototype.slice.call(t)) }; !function (e) {
            var t = window; t.KwaiAnalyticsObject = e, t[e] = t[e] || []; var n = t[e]; n.methods = ["page ","track ","identify ","instances ","debug ","on ","off ","once ","ready ","alias ","group ","enableCookie ","disableCookie "]; var o = function (e, t) { e[t] = function () { var n = Array.from(arguments), o = r([t], n, !0); e.push(o) } }; n.methods.forEach((function (e) { o(n, e) })), n.instance = function (e) { var t = n._i[e] || []; return n.methods.forEach((function (e) { o(t, e) })), t }, n.load = function (t, r) {
                n._i = n._i || {}, n._i[t] = [], n._i[t]._u =" https ://s1.kwai.net/kos/s101/nlav11187/pixel/events.js",n._t=n._t||{},n._t[t]=+new Date,n._o=n._o||{},n._o[t]=r||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src="https://s1.kwai.net/kos/s101/nlav11187/pixel/events.js?sdkid="+t+"&lib="+e;var i=document.getElementsByTagName("script")[0];i.parentNode.insertBefore(o,i)}}("kwaiq")}])}));
                        < script >
                        kwaiq.load('470534617075548239 ');
                kwaiq.track('contentView ');
                kwaiq.page(' contentView'); kwaiq.page(); </script>


<script>
    var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

    var slidesPerChunk = 6; // Padrão para desktop

    if (windowWidth <= 600) {
        slidesPerChunk = 3;
    } else if (windowWidth <= 1024) {
        slidesPerChunk = 1;
    }
</script>


<div class="container ">


    <section id="slider">
        <!DOCTYPE html>


        <link href="css/owl.carousel.min.css" rel="stylesheet">


        <!-- desktop -->
<div class="tamanho mobile-hide">
    <div class="owl-carousel testimonial-carousel" style="max-width:97%; padding-top:20px;">
        <div class="text-center">
            <a href="#"><img class="img-fluid mx-auto mb-3" src="img/slider/d1.jpg" alt=""></a>
        </div>
        <div class="text-center">
            <a href="#"><img class="img-fluid mx-auto mb-3" src="img/slider/d2.jpg" alt=""></a>
        </div>
        <div class="text-center">
            <a href="#"><img class="img-fluid mx-auto mb-3" src="img/slider/d3.jpg" alt=""></a>
        </div>
        <div class="text-center">
            <a href="#"><img class="img-fluid mx-auto mb-3" src="img/slider/d4.jpg" alt=""></a>
        </div>
        <div class="text-center">
            <a href="#"><img class="img-fluid mx-auto mb-3" src="img/slider/d5.jpg" alt=""></a>
        </div>
    </div>
</div>

<style>

    .swiper-button-next,
    .swiper-button-prev {
    width: 40px;
    height: 40px;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 56%;
    transform: translateY(-50%);
    cursor: pointer;
    }
    .tamanho {
        flex: 0 0 0;
        max-width: 100%;
    }

    .testimonial-carousel .owl-item img {
        width: 100%;
        max-height: 100%;
        border-radius: 20px;
        padding-top: 0px;
    }

    .testimonial-carousel .owl-dots {
        margin - top: 0px;
        text-align: center;
    }

    .testimonial-carousel .owl-dot {
        position: relative;
        display: inline-block;
        margin: 0 8px;
        width: 15px;
        height: 15px;
        border-radius: 20px;
        background: #44425A;
    }

    .testimonial-carousel .owl-dot::after {
        position: absolute;
        content: "";
        top: -5px;
        right: -5px;
        bottom: -5px;
        left: -5px;
        border: 3px solid #fff;
        border-radius: 20px;
    }

    .testimonial-carousel .owl-dot.active {
        background: #00008B;

    }

    .img-fluid {
        max - width: 100%;
        height: auto;
    }

    .mr-auto,
    .mx-auto {
        margin - right: 1 !important;
        margin-left: -1 !important;
    }

    .mb-3,
    .my-3 {
        margin - bottom: 1rem !important;
    }
</style>

<script src="js/owl.carousel.min.js"></script>


<script>

    (function ($) {
        "use strict";

        // Dropdown on mouse hover
        $(document).ready(function () {
            function toggleNavbarMethod() {
                if ($(window).width() > 992) {
                    $('.navbar .dropdown').on('mouseover', function () {
                        $('.dropdown-toggle', this).trigger('click');
                    }).on('mouseout', function () {
                        $('.dropdown-toggle', this).trigger('click').blur();
                    });
                } else {
                    $('.navbar .dropdown').off('mouseover').off('mouseout');
                }
            }
            toggleNavbarMethod();
            $(window).resize(toggleNavbarMethod);
        });


        // Back to top button
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.back-to-top').fadeIn('slow');
            } else {
                $('.back-to-top').fadeOut('slow');
            }
        });
        $('.back-to-top').click(function () {
            $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
            return false;
        });


        // carousel
        $(".testimonial-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 500,
            dots: false,
            loop: true,
            items: 1
        });

    })(jQuery);

</script>


</section>
<div class="index-features">
    <div class="col-features">
        <a href="/crash" class="free-to-play" style="background-image: url('/img/bg-1_2x.dc8a421.png');">
            <span>Jogue Agora o Crash e Lucre até 300x por partida!</span>
        </a>
        <a href="/affiliate" style="background-image: url('/img/bg-2_1x.c124441.png');">
            <span>Lucre com Indicações</span>
        </a>
        <a href="javascript:;" style="background-image: url('/img/bg-3_1x.6150cf5.png');">
            <span>Saques Imediatos</span>
        </a>
    </div>


    <div class="col-features">
        <a href="" class="#">
            {{-- <span>Jogue na Roleta e Multiplique Sua Banca em até 50x</span> --}}
            <div class="parent-spin-preview">
                <img width="101" height="77" src="/img/MOEDA_02.png" class="coin coin-1">
                <img width="79" height="76" src="/img/MOEDA_03.png" class="coin coin-2">
                <img width="119" height="119" src="/img/MOEDA_04.png" class="coin coin-3">
                <img width="76" height="77" src="/img/MOEDA_05.png" alt="" class="coin coin-4">
                <img width="152" height="162" src="/img/MOEDA_05.png" class="coin coin-5">
                <img width="124" height="126" src="/img/MOEDA_03.png" class="coin coin-6">
                <div class="spin-preview layer-0">
                    <img width="405" height="405"
                        src="/templates/default/img/betnew/spin-preview-layer-0@1x.dd1753f.webp">
                </div>
                <div class="spin-preview layer-1">
                    <img width="276" height="276"
                        src="/templates/default/img/betnew/spin-preview-layer-1@1x.b9d7398.webp">
                </div>
                <div class="spin-preview layer-2">
                    <img width="233" height="233"
                        src="/templates/default/img/betnew/spin-preview-layer-2@1x.e4cd111.webp">
                </div>
                <div class="spin-preview layer-3">
                    <img width="233" height="233"
                        src="/templates/default/img/betnew/spin-preview-layer-3@1x.3d0893e.webp">
                </div>
                <div class="spin-preview layer-4">
                    <img width="194" height="194" src="/img/roleta.png">
                </div>
            </div>
        </a>
    </div>

    <div class="col-features">
        <a href="javascript:;" style="background-image: url(/img/bg-4_1x.56ae9bd.png);">
            <span>Depósitos Imediatos</span>
        </a>
        <a href="/mines" class="free-to-play" style="background-image: url(/img/bg-5_1x.0006b1c.png);">
            <span>Lucre Muito no Mines</span>
        </a>
        <a href="javascript:;" style="background-image: url(/img/bg-6_1x.8938de0.png);">
            <span>Sistema 100% FairPlay</span>
        </a>
    </div>
</div>

<div class="index-features2">
    <div class="one-category">
        <div class="head-one-category">
            <a href="/slots/" class="h-one-category">
                <svg width="24" height="24" focusable="false" aria-hidden="true" class="">
                    <use xlink:href="/templates/default/img/betnew/svg-sprite.e1149d9.svg#icon-inhouse" class="svg-use">
                    </use>
                </svg>
                JOGOS DA CASA
            </a>
        </div>

        <div class="swiper-container swiper game-swiper1">
            <div class="swiper-wrapper">
                @php
                    $chunkedJogos = array_chunk($jogos1, 1);
                @endphp

                @foreach($chunkedJogos as $chunk)
                    <div class="swiper-slide">
                        @foreach($chunk as $game)
                            <div class="game-slide">
                                @if(isset($game['local_image']) && is_string($game['local_image']))
                                    <div class="img-game-slide" style="background-image: url({{ $game['local_image'] }});">
                                    </div>
                                @else
                                <div class="img-game-slide" style="background-image: url('');">
                                    </div>
                                @endif

                                <div class="hover-game-slide">
                                    <form action="{{ route('playGame', ['game_id' => $game['game_id'] ?? null]) }}" method="post">
                                        @csrf
                                        <button type="submit" class="play-game-slide">
                                            <svg focusable="false" aria-hidden="true" class="">
                                                <use xlink:href="/templates/default/img/betnew/svg-sprite.e1149d9.svg#icon-play"
                                                    class="svg-use"></use>
                                            </svg>
                                        </button>
                                    </form>

                                    <div class="provider-game-slide">
                                        <a href="#">
                                            @if(isset($game['game_name']) && is_string($game['game_name']))
                                                {{ $game['game_name'] }}
                                            @else
                                                Nome do Jogo Não Disponível
                                            @endif
                                        </a>
                                    </div>
                                    <div class="provider-game-slide">
                                        Jogue agora!
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>


        <div class="swiper-container swiper game-swiper2">
            <div class="swiper-wrapper">
                @php
                    $chunkedJogos = array_chunk($jogos2, 1);
                @endphp

                @foreach($chunkedJogos as $chunk)
                    <div class="swiper-slide">
                        @foreach($chunk as $game)
                            <div class="game-slide">
                                @if(isset($game['local_image']) && is_string($game['local_image']))
                                    <div class="img-game-slide" style="background-image: url({{ $game['local_image'] }});">
                                    </div>
                                @else
                                <div class="img-game-slide" style="background-image: url('images/games/150004_Royal Mint.png');">
                                    </div>
                                @endif

                                <div class="hover-game-slide">
                                    <form action="{{ route('playGame', ['game_id' => $game['game_id'] ?? null]) }}" method="post">
                                        @csrf
                                        <button type="submit" class="play-game-slide">
                                            <svg focusable="false" aria-hidden="true" class="">
                                                <use xlink:href="/templates/default/img/betnew/svg-sprite.e1149d9.svg#icon-play"
                                                    class="svg-use"></use>
                                            </svg>
                                        </button>
                                    </form>

                                    <div class="provider-game-slide">
                                        <a href="#">
                                            @if(isset($game['game_name']) && is_string($game['game_name']))
                                                {{ $game['game_name'] }}
                                            @else
                                                Nome do Jogo Não Disponível
                                            @endif
                                        </a>
                                    </div>
                                    <div class="provider-game-slide">
                                        Jogue agora!
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <!-- Adicione as setas de navegação do Swiper -->
        </div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

@if(Auth::user())
<script>
    $('.banner-slot').click(function (e) {
        e.preventDefault();
        let banlance = '{{ Auth::user()->balance }}';
        if (+banlance < 1) {
            $.notify({
                position: 'top-right',
                type: 'info',
                showDuration: 60000,
                autoHideDelay: 60000,
                message: 'Olá! Antes de começar a diversão, lembre-se de fazer uma recarga. Assim, você poderá desfrutar ao máximo do seu jogo. Obrigado!'
            });
            $('#walletModal').modal('show');
        }
        else {
            let game = $(this).find('input[type="hidden"]').val();
            window.location.href = '/api/slots/bgaming/start/' + game + '/false/desktop';
        }
    });
</script>
@else
<script>
    $('.banner-slot').click(function () {
        $('#loginRegisterModal').modal('show');
    });
</script>
@endif

<script>
    var swiper1 = new Swiper('.game-swiper1', {
        slidesPerView: 6,
        slidesPerColumn: 3,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    var swiper2 = new Swiper('.game-swiper2', {
        slidesPerView: 6,
        slidesPerColumn: 3,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        controller: {
            control: swiper1,
        },
    });
</script>


<style>
    .banners-slots {
        padding: 10px 0px;
        width: 100%;
        display: inline-grid;
        grid-template-columns: repeat(6, [col-start] 1fr);
        grid-gap: 10px;
    }

    .banners-slots .banner-slot {
        border-radius: 10px;
        cursor: pointer;
        width: 100%;
        overflow: hidden;
    }

    .banners-slots .banner-slot:hover {
        transform: scale(1.05);
    }

    .banners-slots img {
        width: 100%;
    }

    @media (max-width: 700px) {
        .banners-slots {
            padding: 10px 0px;
            width: 100%;
            display: inline-grid;
            grid-template-columns: repeat(3, [col-start] 1fr);
            grid-gap: 10px;
        }
    }
</style>

<div class=index-features>
    <div data-delay="0" data-animation="slide" class="slider-slots-games w-slider" data-autoplay="true"
        data-easing="linear" data-hide-arrows="false" data-disable-swipe="false" data-autoplay-limit="0"
        data-nav-spacing="3" data-duration="5000" data-infinite="true">
        <div class="mask-slider-slots w-slider-mask" style="filter: grayscale(100%);">
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/fdf003ed00a77f12ab7e2a50ec2b4dcf786ddc862x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/33182334cd83b0e10e19629f4fa4ac71132f99432x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/9bbe1dec074937e5f32e807af3aae69048429da82x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/9aaf2b39cc39450a9c1fbcf9a34a14e22x.jpeg" loading="eager" alt="" class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/de9512d69ce79a4d0f2057cff1e9a120d9d228c62x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/ee7a358afa08459780a49d57fa74a7972x.jpeg" loading="eager" alt="" class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/a755941f59081d45aadaf6845f5b2c981433f6e22x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/30e25e9c13cc44e9acf124b45bbff59f2x.jpeg" loading="eager" alt="" class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/62f8cca1448246d39dee4eab0bc7a9dc2x.jpeg" loading="eager" alt="" class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/3a3a634b94aeb9decd9434a42bad2843c7c49fb22x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/deba1669e73d429402aa031918f9500e3aa92d7c2x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/487824fd0de785408f4b9536a5e51cb937e705032x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/38a72c2ae9e44589a1b91401998bcfa42x.jpeg" loading="eager" alt="" class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/bad98b300e37dc429548aeb7a3179c2efccbb1102x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/cbfa63a19da17b6192bcc5a8de4f0fd3db7a886f2x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/650710e90ac77e0fd30676d05f8685bd9f9e41bd2x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/6fe1d6a618ae8507b87840b431938154faa671f52x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/6f093db8745c488976981f7a520c586e89f1438e2x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/dd7e2f3c937e43e189c3261c62fa82a46ab987ba2x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/7c404e44d4d631aed5002302856c1faab3c081462x.jpeg" loading="eager" alt=""
                    class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/93adad6f64824ea3a2fee45cdd0873792x.jpeg" loading="eager" alt="" class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
            <div class="slide-slots-games w-slide" data-ix="hover-slot-coming"><img
                    src="images/6e6c237fefec4a20a337f96f8ef4e7bc2x.jpeg" loading="eager" alt="" class="slot-game">
                <div class="coming-slot">
                    <div>Em Breve</div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



@endsection