<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Titre de la page</title>
        <link rel="stylesheet" href="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/3/css/style.css">
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        
        <script src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/3/js/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/3/js/phaser.js"></script>
<!--        <script src="node_modules/phaser-input/build/phaser-input.js"></script>-->
        <script>document.write('<script src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/3/js/main.js?dev=' + Math.floor(Math.random() * 100) + '"\><\/script>');</script>
    </head>
    <body>
       
        <div class="separateur"></div>
        <section id="content">
            <div class="user-active" data-number="<?php echo Auth::user()->id; ?>" data-groupe="<?php echo Auth::user()->classe; ?>"></div>
            <div class="card"></div>
            <div id="idGameDiv">
                <button class="btn btn-play">
                    Jouer !
                </button>
            </div>
        </section>
    </body>
</html>
