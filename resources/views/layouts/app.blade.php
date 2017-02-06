<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
	
	<!-- Favicon -->
	<link rel="icon" href="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/favicon.ico" />
	
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
	<link href="{{asset('css/style.css')}}" rel="stylesheet">

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-90706665-1', 'auto');
    ga('send', 'pageview');

    </script>

    <script type="text/javascript" src="../public/tarteaucitron/tarteaucitron.js"></script>

    <script type="text/javascript">
        tarteaucitron.init({
            "hashtag": "#tarteaucitron", /* Ouverture automatique du panel avec le hashtag */
            "highPrivacy": false, /* désactiver le consentement implicite (en naviguant) ? */
            "orientation": "bottom", /* le bandeau doit être en haut (top) ou en bas (bottom) ? */
            "adblocker": false, /* Afficher un message si un adblocker est détecté */
            "showAlertSmall": true, /* afficher le petit bandeau en bas à droite ? */
            "cookieslist": true, /* Afficher la liste des cookies installés ? */
            "removeCredit": false /* supprimer le lien vers la source ? */
        });
    </script>
</head>
<body id="app-layout">
    <?php
    if(Auth::check()){
        
        if(Auth::user()->groupe == null || Auth::user()->groupe == 0) {
            $route = Route::getCurrentRoute()->getPath();
            
            if($route != "infos-incomplete")
            { 
                ?>
                <meta http-equiv="refresh" content="0; URL=https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/infos-incomplete">
                <?php
            }
        }
    }
    ?>
    <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1191177720971169',
      xfbml      : true,
      version    : 'v2.8'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/fr_FR/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

    <div id="fb-root"></div>

    
@if (session('message'))
    <div class="alert alert-info" role="alert" id="messageDeconnexion">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        {{ session('message') }}
        <a href="#fermerMessage" title="Fermer" type="button" class="fermer"><span aria-hidden="true">&times;</span></a>
    </div>
@endif 
    
    @include('include/header')
    
    <main>
        <div id="@yield('id-page')" class="@yield('class-page')">
            @if (!\Request::is('/'))
                <div class="container-fluid global-page">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul id="breadcrumb">
                                <li><a href="{{ url('/') }}">Accueil</a></li>
                                @yield('breadcrumb')
                            </ul> 
                        </div>
                    </div>
                    @if(!Request::is('programme/*/*'))
                        <div class="row">
                            <div class="col-sm-12">
                                <h1>@yield('h1')</h1>
                            </div>
                        </div>
                    @endif  
                </div>
            @endif

            @yield('content') 
        </div>
        
        <div id="parallax">
            <div id="arcenciel"></div>
            <div id="mascotte"></div>
            <div id="arbre"></div>
        </div>
    </main>
    
    @include('include/footer')
    
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    
    <script>jQuery.noConflict();</script>
    <script type="text/javascript" src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/js/jquery.parallax-1.1.3.js"></script>
    <script type="text/javascript" src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/js/main.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('#arcenciel').parallax("20%", 0.1);
            jQuery('#mascotte').parallax("50%", 0.2);
            jQuery('#arbre').parallax("80%", 0.4);
            
            jQuery('#popupInscription').on('shown.bs.modal', function () {
            });
            jQuery('#popupConnexion').on('shown.bs.modal', function () {
            });
            jQuery(function(){
                if(jQuery('#messageDeconnexion').is(':visible')){
                    jQuery('a[href="#fermerMessage"]').click(function(){
                      jQuery("#messageDeconnexion").fadeOut('slow');
                    }); 
                    //setTimeout(jQuery("#messageDeconnexion").fadeOut('slow'),10000);
                };
            });
        })
        
    </script>
    
    <script type="text/javascript">
        tarteaucitron.user.gajsUa = 'UA-90706665-1';
        tarteaucitron.user.gajsMore = function () { /* add here your optionnal _ga.push() */ };
        (tarteaucitron.job = tarteaucitron.job || []).push('gajs');
    </script>
</body>
</html>
