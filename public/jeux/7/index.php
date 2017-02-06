<!DOCTYPE html>
<html lang="en">
<head>

    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="description" content="A memory game, built for fun with HTML, CSS, and JavaScript.">
    <meta name="author" content="Nick Salloum">

    <!-- title -->
    <title>Memory Game!</title>

    <!-- css -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto+Slab">
    <link rel="stylesheet" href="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/css/memory.css">

    <!-- og -->
    <meta property="og:title" content="Memory Game!">
    <meta property="og:url" content="http://callmenick.com/memory/">
    <meta property="og:image" content="http://callmenick.com/memory/img/og-image.png">
  
    <script src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/js/jquery.min.js"></script>

</head>
<body>
  
  <div class="wrapper memory">    
    <div class="content">
        <div class="user-active" data-number="<?php echo Auth::user()->id; ?>" data-groupe="<?php echo Auth::user()->classe; ?>"></div>
        <div class="card"></div>
            <div class="container">
                
            <div id="my-memory-game"></div>
        </div>
    </div><!-- /.content -->

  </div><!-- /.wrapper -->
  
  <!-- js -->
  <script src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/js/classList.min.js"></script>
  <script src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/js/memory.js"></script>

  <!-- start memory! -->
  <script>
    (function(){
      var myMem = new Memory({
        wrapperID : "my-memory-game",
        cards : [
          {
              id : 1,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/algeria.png"
              },
              {
                id : 2,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/brazil.png"
              },
              {
                id : 3,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/canada.png"
              },
              {
                id : 4,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/china.png"
              },
              {
                id : 5,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/france.png"
              },
              {
                id : 6,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/germany.png"
              },
              {
                id : 7,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/india.png"
              },
              {
                id : 8,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/italy.png"
              },
              {
                id : 9,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/japan.png"
              },
              {
                id : 10,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/mexico.png"
              },
              {
                id : 11,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/morocco.png"
              },
              {
                id : 12,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/turkey.png"
              },
              {
                id : 13,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/portugal.png"
              },
              {
                id : 14,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/south_africa.png"
              },
              {
                id : 15,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/usa.png"
              },
              {
                id : 16,
                img: "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/7/img/default/spain.png"
              }
        ],
        onGameStart : function() { return false; },
        onGameEnd : function() { return false; }
      });
    })();
  </script>
  
  <!-- ads, fb, twitter, github, analytics -->
  <script>
    (function(){
      var fusoionad_script = document.createElement("script");
      fusoionad_script.type = "text/javascript";
      fusoionad_script.async = true;
      fusoionad_script.id = "_fusionads_js";
      fusoionad_script.src = "http://cdn.fusionads.net/fusion.js?zoneid=1332&serve=C6SDP2Y&placement=callmenickcom";
      document.getElementById("footer__ad--container").appendChild(fusoionad_script);
    })();

    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=222982931164932&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

    (function(){
      var gitFork = document.createElement("iframe");
      gitFork.setAttribute( "src", "http://ghbtns.com/github-btn.html?user=callmenick&repo=Memory&type=fork&count=true" );
      gitFork.setAttribute( "allowtransparency", "true" );
      gitFork.setAttribute( "frameborder", "0" );
      gitFork.setAttribute( "scrolling", "0" );
      gitFork.style.width = "95px";
      gitFork.style.height = "20px";
      document.getElementById("footer__social--icons-github").appendChild(gitFork);

      var gitWatch = document.createElement("iframe");
      gitWatch.setAttribute( "src", "http://ghbtns.com/github-btn.html?user=callmenick&repo=Memory&type=watch&count=true" );
      gitWatch.setAttribute( "allowtransparency", "true" );
      gitWatch.setAttribute( "frameborder", "0" );
      gitWatch.setAttribute( "scrolling", "0" );
      gitWatch.style.width = "110px";
      gitWatch.style.height = "20px";
      document.getElementById("footer__social--icons-github").appendChild(gitWatch);
    })();

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-34160351-1']);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>

  <div id="fb-root"></div>

</body>
</html>