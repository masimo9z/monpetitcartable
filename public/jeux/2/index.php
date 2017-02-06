<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Titre de la page</title>
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <link rel="stylesheet" href="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/2/css/style.css">
        <script src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/2/js/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/2/js/main.js"></script>
    </head>
    <body>       
        <section class="dictee" id="content">
            <div class="user-active" data-number="<?php echo Auth::user()->id; ?>" data-groupe="<?php echo Auth::user()->classe; ?>"></div>
            <div class="card"></div>
            <h2 class="score">Votre score : <span id="score-value"></span></h2>
            <h1 class="title">Sélectionnez un exercice</h1>
            <div class="lifes">
                <ul class="lifes-list"></ul>
            </div>
            <div class="modes"></div>
            <div class="help"></div>
            <div class="exercice"></div>
        </section>
    </body>
</html>
