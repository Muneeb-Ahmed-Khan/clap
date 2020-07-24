@extends('layouts.claplayout')

@section('landingpagecontent')
<div class="header-bottom">
    <div class="home-animation-wrap pull-right">
        <div class="home-animation">
            <div class="ha-img ha-01"></div>
            <div class="ha-img ha-dot"></div>
            <div class="ha-img ha-02"></div>
            <div class="ha-img ha-dot"></div>
            <div class="ha-img ha-03"></div>
            <div class="ha-img ha-dot"></div>
            <div class="ha-img ha-04"></div>
            <div class="ha-img ha-dot"></div>
            <div class="ha-img ha-05"></div>
            <div class="ha-img ha-dot"></div>
            <div class="ha-img ha-06"></div>
            <div class="ha-img ha-dot"></div>
        </div>
    </div>
    <div id="welcome" class="pull-left">
        <h1>Cross Linguistic Awareness Programm</h1>
        <div class="wel-desc">
            <p>Grammaticaonderwijs dat het grammaticasysteem transparant maakt, grammaticaal redeneren stimuleert en de balans doet verschuiven van feitenkennis naar inzicht, begrip en toepassing. Belangrijker dan het vinden van het ‘goede antwoord’ is de redenering die tot dat ‘goede' antwoord leidt. 

Vergroot je taalbewustzijn met behulp van het Nederlands, het Engels en het Duits. Let's CLAP!</p>
        </div>
        <!--
        <div class="wel-btn">
            <a href="/register" class="btn btn-lg btn-trans" title="">
                <i class="icon-user mr10"></i> Sign up now <span>FREE</span>
            </a>
        </div>
        -->
    </div>
    <div class="clearfix"></div>
</div>
@endsection


@section('content')
<section class="home-feature">
    <div class="container">
        <div class="hf-block-wrap">
            <div class="hf-block hf-block1">
                <div class="hfb-icon"><img src="{{asset('images/icon-01.png')}}" title="" alt=""></div>
                <h2>Animatievideo’s </h2>
                <p>Heldere theorie-uitleg van alle onderwerpen met voorbeelden in het Nederlands, Engels en Duits.</p>
            </div>
            <div class="hf-block hf-block2">
                <div class="hfb-icon"><img src="images/icon-02.png" title="" alt=""></div>
                <h2>Digitaal lesmateriaal</h2>
                <p>Een lessenserie waarvoor je enkel een laptop/ telefoon en een internetverbinding nodig hebt.</p>
            </div>
            <div class="hf-block hf-block3">
                <div class="hfb-icon"><img src="images/icon-03.png" title="" alt=""></div>
                <h2>Chatfunctie</h2>
                <p>Overleggen met behulp van een chatfunctie om samen tot een antwoord te kunnen komen.</p>
            </div>
            <div class="hf-block hf-block1">
                <div class="hfb-icon"><img src="images/icon-04.png" title="" alt=""></div>
                <h2>Voortgangsoverzicht</h2>
                <p>Inzicht in de voortgang binnen het lesmateriaal, zowel voor jou als docent als voor je leerlingen. Lekker overzichtelijk!</p>
            </div>
            <div class="hf-block hf-block2">
                <div class="hfb-icon"><img src="images/icon-05.png" title="" alt=""></div>
                <h2>Rolwisselend leren</h2>
                <p>Leerlingen werken in kleine groepen, waarin steeds een ander verantwoordelijk is voor het beantwoorden van een vraag.</p>
            </div>
            <div class="hf-block hf-block3">
                <div class="hfb-icon"><img src="images/icon-06.png" title="" alt=""></div>
                <h2>Flexibele module</h2>
                <p>Pas de lessenserie aan of upload uw eigen materiaal om de website af te stemmen op uw eigen leerlingen.</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
<section class="home-start">
    <div class="container">
        <div class="home-start-border">
            <div class="hs-logo"><img src="images/logo-bw.png" title="" alt=""></div>
            <div class="hs-block hs-left">
                <h3>CLAP - Cross Linguistic Awareness Programm</h3>
                <p></p>
            </div>
            <div class="hs-right">
                <a href="/register" class="btn btn-lg btn-default"><i class="icon-user mr20"></i>Sign
                            up for free</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
@endsection


@section('landingpagecontent_rotateJQurey')
<script type="text/javascript" src="{{asset('js/jquery.ha.min.js')}}"></script>
    <script>
        $(window).load(function () {
            $('.home-animation').vortex({
                speed: 300,
                deepFactor: 0.2,
            });
        });
    </script>
@endsection
