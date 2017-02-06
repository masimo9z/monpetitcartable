<!doctype html> 
<html lang="en"> 
<head> 
	<meta charset="UTF-8" />
    <title>Bomb Boy Online</title>
    <script type="text/javascript">
        WebFontConfig = {
          google: { families: [ 'Carter+One::latin' ] }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http' ) +
              '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })(); 
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/bomberman/client/dist/main.js"></script>
    <script src="//cdn.jsdelivr.net/phaser/2.2.2/phaser.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.2.js"></script>
    <script src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/bomberman/client/dist/bomb_arena.js"></script>
    <style type="text/css">
        body {
            margin: 0;
        }
    </style>
</head>
<body>
<section id="bomberman-content">
<div class="user-active" data-number="<?php echo Auth::user()->id; ?>" data-groupe="<?php echo Auth::user()->classe; ?>"></div>
</section>
</body>
</html>