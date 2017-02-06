var gameId = 1;
var lifeNb = 3;
var stars; 
var game; 
var score = 0;
var arrReponse = [];
var reponse;
var calcul;
var arrScore = [0];
var arrText = [];
var arrStars = [];
var arrBullets = [];
var cardScore = [2,20,30,40,50,60,70,80,90,100];
var textSprite;
var activeMenu = false;
var menu;
var arrLifes = [];
var rules = '';
var rules_text = '';
var rules_one = false;
var w = 800, h = 600;

document.addEventListener("DOMContentLoaded", Main, false); // appel au chargement de la page

/**
* Fonction principale
* Appelée au chargement de la page
*
*/
function Main(){
    console.log('Main');
    
    // création de la zone de jeu - API Canvas
    game = new Phaser.Game(800, 600, Phaser.CANVAS, 'idGameDiv', { preload: preload, create: create, update: update, render: render});
    console.log(game.state.current);
}



function preload() {

    game.load.image('arrow', 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/1/img/arrow.png');
    game.load.image('bullet', 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/1/img/waterball.png');
    game.load.image('fallObject', 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/1/img/fireball.png');
    game.load.image('ground', 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/1/img/ground.png');
    game.load.image("background", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/1/img/sky.png");
    game.load.image('menu', 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/1/img/button3.png', 400, 90);
    game.load.image("wind", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/1/img/wind.png");    
    game.load.image("rules", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/1/img/rules.png");
    game.load.image("life", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/1/img/life.png");
}

var sprite;
var ground;
var background;
var callOnce = false;
var level;
var bullets;
var wind = '';
var textWind;
var callOnce = false;

var fireRate = 100;
var nextFire = 0;

function create() {
    background =  game.add.sprite(0, 0, 'background');
    
    scoreText = game.add.text(550, 10, 'Vos points : 0', {fontSize: '33px', fill: '#fff'}); // ajoute le score
    calcul = game.add.text(10, 0, '', {fontSize: '60px', fill: '#fff'}); // ajoute le calcul
    game.physics.startSystem(Phaser.Physics.ARCADE);
    
    game.stage.backgroundColor = '#313131';

    var grounds = game.add.group(); // ajout des étoiles dans un groupe
    //ground = game.add.sprite(0, 420, 'ground');
    grounds.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    ground = grounds.create(0, 320, 'ground'); // création d'une étoile dans le groupe 'étoiles'
    
    bullets = game.add.group();
    bullets.enableBody = true;
    bullets.physicsBodyType = Phaser.Physics.ARCADE;

    bullets.createMultiple(50, 'bullet');
    bullets.setAll('checkWorldBounds', true);
    bullets.setAll('outOfBoundsKill', true);
    
    
    sprite = game.add.sprite(400, 550, 'arrow');
    sprite.anchor.set(0.5);
    
    game.physics.enable(sprite, Phaser.Physics.ARCADE);

    sprite.body.allowRotation = false;
    
    stars = game.add.group(); // ajout des étoiles dans un groupe
    stars.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    stars.setAll('checkWorldBounds', true);
    stars.setAll('outOfBoundsKill', true);
    
    texts = game.add.group();
    texts.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    
    // Create a label to use as a button
    pause_label = game.add.text(w - 100, h/2 + 90, 'Menu', { font: '24px Arial', fill: '#fff' });
    pause_label.inputEnabled = true;
    pause_label.events.onInputUp.add(function () {
        displayMenu();
    });
    
//    getJSON('level', function(data){
        initCalcul();
        
        var randomReponse = randomArray(arrReponse);
        var nb_stars = 3;
        createStars(nb_stars, randomReponse, game);
        updateLife(game); // initialise les 3 vies de départ

        // Unpause the game
        game.paused = true;
        displayRules(grounds);
//    });
    
    // Add a input listener that can help us return from being paused
    game.input.onDown.add(unpause, self);

    // And finally the method that handels the pause menu
    function unpause(event){
        // Only act if paused
        if(game.paused){
            // Calculate the corners of the menu
            // qd onajoute un bouton changer le premier nombre de la division, ici 400. Ne pas toucher au 2
            var x1 = w/2 - 400/2, x2 = w/2 + 400/2,
                y1 = h/2 - 90/2, y2 = h/2 + 90/2;

            // Check if the click was inside the menu
            if(event.x > x1 && event.x < x2 && event.y > y1 && event.y < y2 ){
                // The choicemap is an array that will help us see which item was clicked
                var choisemap = ['play', 'restart', 'rules'];

                // Get menu local coordinates for the click
                var x = event.x - x1,
                    y = event.y - y1;

                // Calculate the choice 
                var choise = Math.floor(x / 134) + 2*Math.floor(y / 90);
                
                // Display the choice
                if(choisemap[choise] == 'play'){
                    play();
                }
                else if(choisemap[choise] == 'restart'){
                    menu.destroy();
                    choiseLabel.destroy();

                    // Unpause the game
                    game.paused = false;
                    activeMenu = false;
                    lifeNb = 3;
                    restart();
                }
                else if(choisemap[choise] == 'rules'){
                    displayRules(grounds);
                }
            }
            else{
                // Remove the menu and the label
                menu.destroy();
                choiseLabel.destroy();
                destroyRules();

                // Unpause the game
                game.paused = false;
                activeMenu = false;
            }
        }
    };
}

function update() {

    sprite.rotation = game.physics.arcade.angleToPointer(sprite);

    if (game.input.activePointer.isDown)
    {
        fire();
    }
    game.physics.arcade.overlap(bullets, stars, collectStar, null, this); // collision entre les joueurs et les plateformes
    game.physics.arcade.overlap(ground, stars, restartMenu, null, this); // collision entre les joueurs et les plateformes
    
    if(callOnce == false && score >= 10 && score <= 11){
        wind = game.add.sprite(20, h/2, 'wind');
        textWind = game.add.text(20, h/2 - 50, 'Attention, ça souffle !', { font: 'bold 15pt Arial', fill: "#fff"});
        callOnce = true;
    }
    if(wind != '' && score >= 4){
        wind.destroy();
        textWind.kill();
    }
    //game.physics.arcade.collide(stars, ground, restart);
}

function next() {
    for(var i = 0; i < arrStars.length; i++){
        arrStars[i].kill();
    }    
    
    for(var i = 0; i < arrBullets.length; i++){
        arrBullets[i].kill();
    }
    
    for(var i = 0; i < arrText.length; i++){
        arrText[i].kill();
    }
    arrReponse = [];
    arrText = [];
    arrStars = [];
    arrBullets = [];
    initCalcul();
    
    stars = game.add.group(); // ajout des étoiles dans un groupe
    stars.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    
    texts = game.add.group();
    texts.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    
    var randomReponse = randomArray(arrReponse);
    var nb_stars = 3;
    createStars(nb_stars, randomReponse, game);
}

function fire() {

    if (game.time.now > nextFire && bullets.countDead() > 0)
    {
        nextFire = game.time.now + fireRate;

        var bullet = bullets.getFirstDead();

        bullet.reset(sprite.x - 16, sprite.y - 8);

        game.physics.arcade.moveToPointer(bullet, 400);
        if(score >= 10 && score <= 11){
            game.add.tween(bullet).to( { angle: 360 }, 2000, Phaser.Easing.Linear.None, true);
        }
        
        arrBullets.push(bullet);
    }

}

function render() {
    //game.debug.text('Active Bullets: ' + stars.countLiving() + ' / ' + stars.total, 32, 32);
    //game.debug.spriteInfo(sprite, 32, 450);

}

/**
*
* Le joueur attrape une étoile
* @param {[type]} player  [description]
* @param {[type]} star    [description]
* @return {[type]}        [description]
*/

function collectStar(bullets, star, text){
    var idStar = star.id;
    if(star.value == reponse){
        bullets.kill(); // supprime la balle de l'écran de jeu
        star.kill(); // supprime l'étoile de l'écran de jeu
        arrText[idStar].kill();
        score += 1;
        scoreText.text = 'Vos points : ' + score;
        CheckCardWin();
        next();
    }
    else{
        if(lifeNb > 1){
            lifeNb--;
            restart();
        }
        else{
            displayMenu('Vous avez perdu ...');
            for(var i = 0; i<arrScore.length; i++){
                if(score > arrScore[i]){
                    var added;
                    if(added != true){
                        added = true;
                        addBDD('score', score);
                    }
                }
            }
            arrScore.push(score);
            restart();
        }
    }
    // mets à jour le score du jeu 
}

function CheckCardWin(){
    if(cardScore.indexOf(score) != -1){
        $('.card').addClass('cardWin');
        addBDD('life', 1);
        setTimeout(function(){
            $('.card').removeClass('cardWin');
        }, 5000);
    }
}

/**
*
* Initilise le calcul ainsi que sa réponse
*
* @return {[type]}        [description]
*/

function initCalcul(){
    var arrFirstNum = [];
    var arrSecondNum = [];
    var easyMode;
    
    var arrSeparator = [];
    var randomSep;
    var randomFirst;
    var randomSecond;
    var negatifMode;
    var maxValue = 10;
    
    level = $('.user-active').attr('data-groupe');
    
    switch (level) {
        case '1':
            arrSeparator.push(' + ');
            negatifMode = true;
            easyMode = true;
            break;
            
        case '2':
            arrSeparator.push(' + ');
            arrSeparator.push(' x ');
            negatifMode = true;
            easyMode = true;
            break;
            
        case '3':
            arrSeparator.push(' + ');
            arrSeparator.push(' x ');
            arrSeparator.push(' - ');
            negatifMode = true;
            easyMode = true;
            break;
            
        case '4':
            arrSeparator.push(' + ');
            arrSeparator.push(' x ');
            arrSeparator.push(' - ');
            negatifMode = true;
            easyMode = false;
            break;
            
        case '5':
            arrSeparator.push(' + ');
            arrSeparator.push(' x ');
            arrSeparator.push(' - ');
            negatifMode = false;
            easyMode = false;
            break;
            
        default: 
            arrSeparator.push(' + ');
            arrSeparator.push(' x ');
            arrSeparator.push(' - ');
            negatifMode = false;
            easyMode = false;
    }
    
    if(easyMode == true){
        if(score <= 5){
            maxValue = 5;
        }
    }

    for(var i = 0; i <= maxValue; i++){
        arrFirstNum.push(i);
    }
    
    for(var i = 0; i <= maxValue; i++){
        arrSecondNum.push(i);
    }
    
    randomSep = arrSeparator[Math.floor(Math.random()*arrSeparator.length)];
    
    console.log(randomSep);
    randomFirst = arrFirstNum[Math.floor(Math.random()*arrFirstNum.length)];
    randomSecond = arrSecondNum[Math.floor(Math.random()*arrSecondNum.length)];
    
    if(negatifMode == true){
        while(randomFirst < randomSecond){
            randomFirst = arrFirstNum[Math.floor(Math.random()*arrFirstNum.length)];
        }        
    }
    
    
    if(randomSep == ' + '){
        arrReponse.push(parseInt(randomFirst) * parseInt(randomSecond));
        arrReponse.push(parseInt(randomFirst) + parseInt(randomSecond));
        arrReponse.push(parseInt(randomFirst) + parseInt(randomSecond) + 2);
        reponse = parseInt(randomFirst) + parseInt(randomSecond);
    }
    else if(randomSep == ' - '){        
        arrReponse.push(parseInt(randomFirst) * parseInt(randomSecond));
        arrReponse.push(parseInt(randomFirst) - parseInt(randomSecond));
        arrReponse.push(parseInt(randomFirst) - parseInt(randomSecond) +2);
        reponse = parseInt(randomFirst) - parseInt(randomSecond);
    }
    else if(randomSep == ' x '){        
        arrReponse.push(parseInt(randomFirst) + parseInt(randomSecond));
        arrReponse.push(parseInt(randomFirst) * parseInt(randomSecond));
        arrReponse.push(parseInt(randomFirst) * parseInt(randomSecond) + 4);
        reponse = parseInt(randomFirst) * parseInt(randomSecond);
    }
//    calcul.text = randomFirst + randomSep + randomSecond;
    calcul.text = ""+ randomFirst + randomSep + randomSecond;
}

function randomArray(arrayToModif){
    for(var position=0; position<arrayToModif.length; position++){
        //hasard reçoit un nombre entier aléatoire entre 0 et position
        var hasard=Math.floor(Math.random()*(position+1));

        //Echange
        var sauve=arrayToModif[position];
        arrayToModif[position]=arrayToModif[hasard];
        arrayToModif[hasard]=sauve;
    }
    return arrayToModif;
    
}

function restart(){
    for(var i = 0; i < arrStars.length; i++){
        arrStars[i].kill();
    }    
    
    for(var i = 0; i < arrBullets.length; i++){
        arrBullets[i].kill();
    }
    
    for(var i = 0; i < arrText.length; i++){
        arrText[i].kill();
    }
    score = 0;
    arrReponse = [];
    arrText = [];
    arrStars = [];
    arrBullets = [];
    initCalcul();
    
    scoreText.text = 'Vos points : ' + score;
    
    stars = game.add.group(); // ajout des étoiles dans un groupe
    stars.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    
    texts = game.add.group();
    texts.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    
    var randomReponse = randomArray(arrReponse);
    var nb_stars = 3;
    createStars(nb_stars, randomReponse, game);
    if(lifeNb < 1)
        lifeNb = 3;
    updateLife(game);
    
    if(activeMenu === true){        
        // Remove the menu and the label
        menu.destroy();
        choiseLabel.destroy();

        // Unpause the game
        game.paused = false;
        activeMenu = false;
    }
    
    if(wind != ''){
        wind.destroy();        
        textWind.kill();
    }
}

function play(){
    // Remove the menu and the label
    menu.destroy();
    choiseLabel.destroy();

    // Unpause the game
    game.paused = false;
    activeMenu = false;
}

function displayMenu(message){
    if(message === '' || message === undefined){
        var message = 'Cliquez en dehors du menu pour continuer';
    }
    // When the paus button is pressed, we pause the game
    game.paused = true;

    // Then add the menu
    menu = game.add.sprite(w/2, h/2, 'menu');
    menu.anchor.setTo(0.5, 0.5);

    // And a label to illustrate which menu item was chosen. (This is not necessary)
    choiseLabel = game.add.text(w/2, h/3, message, { font: '30px Arial', fill: '#fff' });
    choiseLabel.anchor.setTo(0.5, 0.5);
}

function addBDD(name ,value){
    var data;
    var userId = getUserId();
    if(name == 'score'){
        data = 'userId='+userId+'&score='+value+'&gameId='+gameId;
    }
    else if(name == 'life'){
        data = 'userId='+userId+'&life=1';
    }
    var request = $.ajax({
        url : 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/1/add.php',
        method : 'GET',
        data : data,
        dataType : 'html'
    });

    request.done(function( msg ) {
        console.log(msg);
    });
}

function restartMenu(message){    
    lifeNb = 3;
    restart();
    displayMenu('Vous avez perdu ...');
}

function createStars(nbStars, randomReponse, element){
    for(var i = 0; i < nbStars; i++){
        var star = stars.create(i * 300, -250, 'fallObject'); // création d'une étoile dans le groupe 'étoiles'
        
        var text = game.add.text(i * 300, -100, randomReponse[i], { font: 'bold 24pt Arial', fill: "#fff", id: i});

        text.anchor.setTo(0.5);
        arrText.push(text);
        textSprite = game.add.sprite(game.world.centerX-350, game.world.centerY-240, null);
        textSprite.addChild(arrText[i]);
        game.physics.enable(textSprite, Phaser.Physics.ARCADE);
        textSprite.body.gravity.y = 20;
        
        star.body.gravity.y = 20; // ajoute la gravité sur l'étoile
        star.id = i;// valeur de rebond légèrement aléatoire
        star.value = randomReponse[i];// valeur de rebond légèrement aléatoire
        arrStars.push(star);
    }
}

function updateLife(element){
    for(var i = 0; i < arrLifes.length; i++){
        arrLifes[i].kill();
    }
    lifes = element.add.group(); // ajout des coeurs dans un groupe
    lifes.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    
    for(var i = 1; i <= lifeNb; i++){
        var life = lifes.create(i * 20, 70, 'life'); // création d'une étoile dans le groupe 'étoiles'
        life.id = i;// valeur de rebond légèrement aléatoire
        arrLifes.push(life);
    }
}

function displayRules(grounds){
    if(rules_one === false){
        if(menu != undefined){
            menu.destroy();
            choiseLabel.destroy();            
        }
        
        var regles = "C'est l'invasion de météorites ! Protéges toi en dirigeant le canon à glace et cliques avec ta souris sur la météorite qui répond au calcul en haut à gauche.";
        rules_text = game.add.text(w/2 - 130, 200, regles, { font: '18px Arial', fill: '#000'});
        //rules_button = game.add.text(w/2 - 30, 380, 'Jouer', { font: '18px Arial', fill: '#000', backgroundColor: '#fff'});
        rules = grounds.create(w/2 - 200, 100, 'rules'); // création d'une étoile dans le groupe 'étoiles'
        rules_text.wordWrap = true;
        rules_text.wordWrapWidth = 270;
        rules_text.lineSpacing = 5;
        rules_one = true;
    }
}

function destroyRules(){
    if(rules != '' && rules_text != ''){
        rules_text.kill();
        rules.destroy();
        rules_one = false;
    }
}

//function getJSON(value, callback){
//    var request = $.ajax({
//        url : 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/1/getJSON.php',
//        method : 'GET',
//        data : 'value='+value,
//        dataType : 'json'
//    });
//
//    request.done(function(msg) {
//        if(value == 'level'){
//            level = msg;
//        }
//        callback();
//    });
//}

function getUserId(){
    var userId = $('.user-active').attr('data-number');
    console.log(userId);
    return userId;
}

/******** JQUERY ***********/
$(document).ready(function(){
    $('.btn-play').on('click', function(){
        // Unpause the game
        game.paused = false;
        destroyRules();
        $(this).fadeOut();
    });
});