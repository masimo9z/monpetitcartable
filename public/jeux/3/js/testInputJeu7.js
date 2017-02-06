var gameId = 1;
var lifeNb = 3;
var stars; 
var game;
var menu;
var score = 0;
var arrReponse = [];
var reponse;
var calcul;
var arrScore = [0];
var arrText = [];
var arrAnimals = [];
var arrStars = [];
var arrLifes = [];
var textSprite;
var activeMenu = false;
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
    game = new Phaser.Game(800, 600, Phaser.CANVAS, 'idGameDiv', { preload: preload, create: create, update: update, render: render, restart:restart });
    console.log(game.state.current);
}



function preload() {
    game.load.image('fallObject', 'img/shadow.png');
    game.load.image('ground', 'img/ground.png');
    game.load.image('menu', 'img/button3.png', 400, 90);
    game.load.image("bg", "img/bg.png");
    game.load.image("cow", "img/cow.png");
    game.load.image("chicken", "img/chicken.png");
    game.load.image("background", "img/sky.png");
    game.load.image("rules", "img/rules.png");
    game.load.image("life", "img/life.png");
}

var sprite;
var ground;
var background;
var callOnce = false;
var level;

var fireRate = 100;
var nextFire = 0;

function create() {
    game.add.plugin(Fabrique.Plugins.InputField);
    //background =  game.add.sprite(0, 0, 'background');
    background =  game.add.sprite(0, 0, 'bg');
    
    scoreText = game.add.text(10, 10, 'Vos points : 0', {fontSize: '33px', fill: '#fff'}); // ajoute le score
    game.physics.startSystem(Phaser.Physics.ARCADE);
    
    game.stage.backgroundColor = '#313131';
    
    var grounds = game.add.group(); // ajout des étoiles dans un groupe
    //ground = game.add.sprite(0, 420, 'ground');
    grounds.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    //ground = grounds.create(0, 430, 'ground'); // création d'une étoile dans le groupe 'étoiles'
    
    stars = game.add.group(); // ajout des étoiles dans un groupe
    stars.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    stars.setAll('checkWorldBounds', true);
    stars.setAll('outOfBoundsKill', true);
    
    animals = game.add.group(); // ajout des étoiles dans un groupe
    animals.setAll('checkWorldBounds', true);
    animals.setAll('outOfBoundsKill', true);
    
    texts = game.add.group();
    texts.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    
    // Create a label to use as a button
    pause_label = game.add.text(w - 100, 10, 'Menu', { font: '24px Arial', fill: '#fff' });
    pause_label.inputEnabled = true;
    pause_label.events.onInputUp.add(function () {
        displayMenu();
    });
    
    // Unpause the game
    game.paused = true;
    displayRules(grounds);
    
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
    var input = game.add.inputField(10, 90);
}

function update() {
    game.physics.arcade.overlap(ground, stars, restartMenu, null, this); // collision entre les joueurs et les plateformes
    //game.physics.arcade.overlap(bullets, stars, collectStar, null, this); // collision entre les joueurs et les plateformes
}

function next() {
    for(var i = 0; i < arrStars.length; i++){
        arrStars[i].kill();
    }
    
    for(var i = 0; i < arrText.length; i++){
        arrText[i].kill();
    }
    
    for(var i = 0; i < arrAnimals.length; i++){
        arrAnimals[i].kill();
    }
    arrReponse = [];
    arrText = [];
    arrStars = [];
    arrAnimals = [];
    initCalcul();
    
    stars = game.add.group(); // ajout des étoiles dans un groupe
    stars.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    
    texts = game.add.group();
    texts.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    
    var randomReponse = randomArray(arrReponse);
    var nb_stars = 3;
    createStars(nb_stars, randomReponse, game);
    createAnimals(reponse, game);
}

function render() {
    //game.debug.text('Active Bullets: ' + stars.countLiving() + ' / ' + stars.total, 32, 32);
    //game.debug.spriteInfo(sprite, 32, 450);

}

/**
*
* Initialise le calcul ainsi que sa réponse
*
* @return {[type]}        [description]
*/

function initCalcul(){
    var arrFirstNum = [];
    var arrSecondNum = [];
    var easyMode;
    
    var arrSeparator = [];
    var randomFirst;
    var negatifMode;
    var maxValue = 9;
    
    for(var i = 1; i <= maxValue; i++){
        arrFirstNum.push(i);
    }
    
    randomFirst = arrFirstNum[Math.floor(Math.random()*arrFirstNum.length)];
    reponse = parseInt(randomFirst);
        
    switch (level) {
        case 1:
            easyMode = true;
            break;
            
        case 2:
            easyMode = true;
            break;
            
        case 3:
            easyMode = true;
            break;
            
        case 4:
            easyMode = false;
            break;
            
        case 5:
            easyMode = false;
            break;
    }
    
    if(easyMode == true){
        if(score <= 5){
            maxValue = 5;
        }
    }
    
    arrReponse.push(parseInt(randomFirst) + 2);
    arrReponse.push(parseInt(randomFirst) - 1);
    arrReponse.push(parseInt(randomFirst));
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
    
    for(var i = 0; i < arrText.length; i++){
        arrText[i].kill();
    }
    
    for(var i = 0; i < arrAnimals.length; i++){
        arrAnimals[i].kill();
    }
    score = 0;
    arrReponse = [];
    arrText = [];
    arrStars = [];
    arrAnimals = [];
    initCalcul();
    
    scoreText.text = 'Vos points : ' + score;
    
    stars = game.add.group(); // ajout des étoiles dans un groupe
    stars.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    
    texts = game.add.group();
    texts.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    
    var randomReponse = randomArray(arrReponse);
    var nb_stars = 3;
    createStars(nb_stars, randomReponse, game);
    createAnimals(reponse, game);
    if(lifeNb < 1)
        lifeNb = 3;
    updateLife(game); // 
    
    if(activeMenu === true){        
        // Remove the menu and the label
        menu.destroy();
        choiseLabel.destroy();

        // Unpause the game
        game.paused = false;
        activeMenu = false;
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
    if(name == 'score'){
        data = 'score='+value+'&gameId='+gameId;
    }
    else if(name == 'life'){
        data = 'life=1';
    }
    var request = $.ajax({
        url : 'add.php',
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

function checkWin(star){
    var idStar = star.id;
    var arrGetLife = [];
    if(star.value == reponse){
        star.kill(); // supprime l'étoile de l'écran de jeu
        arrText[idStar].kill();
        score += 1;
        scoreText.text = 'Vos points : ' + score;
        for(i=1; i<=20; i++){
            arrGetLife.push(i*10);
        }
        if(arrGetLife.indexOf(score) != -1){
            addBDD('life', 1);
        }
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
        
        var regles = "M. Paysan n'est pas sûr du nombre de vaches qu'il a dans son enclos. Peux-tu l'aider ?       Utilises ta souris pour cliquer sur la bonne réponse à droite.";
        rules_text = game.add.text(w/2 - 120, 200, regles, { font: '18px Arial', fill: '#000'});
        //rules_button = game.add.text(w/2 - 30, 380, 'Jouer', { font: '18px Arial', fill: '#000', backgroundColor: '#fff'});
        rules = grounds.create(w/2 - 200, 100, 'rules'); // création d'une étoile dans le groupe 'étoiles'
        rules_text.wordWrap = true;
        rules_text.wordWrapWidth = 270;
        rules_text.lineSpacing = 5;
        rules_one = true;
        game.world.bringToTop(grounds);
        game.world.bringToTop(rules_text);
    }
}

function destroyRules(){
    if(rules != '' && rules_text != ''){
        rules_text.kill();
        rules.destroy();
        rules_one = false;
    }
}

function createStars(nbStars, randomReponse, element){
    for(var i = 0; i < nbStars; i++){
        if(i == 0){
            var x = i + 500;
            var y = 450;
            var star = stars.create(x, y, 'fallObject'); // création d'une étoile dans le groupe 'étoiles'
            var text = element.add.text(x+3, y, randomReponse[i], { font: 'bold 24pt Arial', fill: "#fff", id: 'text_'+i});            
        }
        else if(i == 1){
            var x = 600;
            var y = 350;
            var star = stars.create(x, y, 'fallObject'); // création d'une étoile dans le groupe 'étoiles'
            var text = element.add.text(x+3, y, randomReponse[i], { font: 'bold 24pt Arial', fill: "#fff", id: 'text_'+i});            
        }
        else if(i == 2){
            var x = 650;
            var y = 480;
            var star = stars.create(x, y, 'fallObject'); // création d'une étoile dans le groupe 'étoiles'
            var text = element.add.text(x+3, y, randomReponse[i], { font: 'bold 24pt Arial', fill: "#fff", id: 'text_'+i});            
        }
        
        text.anchor.setTo(0.5);
        arrText.push(text);
        
        textSprite = game.add.sprite(element.world.centerX-350, element.world.centerY-240, null);
        textSprite.addChild(arrText[i]);
        element.physics.enable(textSprite, Phaser.Physics.ARCADE);
        star.inputEnabled = true;
        star.id = i;// valeur de rebond légèrement aléatoire
        star.value = randomReponse[i];// valeur de rebond légèrement aléatoire
        // input listener waiting for mouse or touch input, then calling moveSquare method
        star.events.onInputDown.add(checkWin, element);  
        arrStars.push(star);
    }
}

function createAnimals(nbAnimals, element){
    randomAnimal = Math.floor(Math.random()*nbAnimals);
    for(var i = 0; i < nbAnimals; i++){
        if(i<4){
            if(score >= 5 && i == randomAnimal){
                var poule = animals.create(i * 150, i*20 + 280, 'chicken'); // création d'un animal dans le tableau arrAnimals
                reponse--;
            }
            else{
                var animal = animals.create(i * 150, i*20 + 280, 'cow'); // création d'un animal dans le tableau arrAnimals
            }
        }
        else if(i<7){
            if(score >= 5 && i == randomAnimal){
                var poule = animals.create((i-4) * 170, i*10 + 350, 'chicken'); // création d'un animal dans le tableau arrAnimals
                reponse--;
            }
            else{
                var animal = animals.create((i-4) * 170, i*10 + 350, 'cow'); // création d'un animal dans le tableau arrAnimals
            }
        }
        else if(i<10){
            if(score >= 5 && i == randomAnimal){
                var poule = animals.create((i-7) * 150, i*5 + 450, 'chicken'); // création d'un animal dans le tableau arrAnimals
                reponse--;
            }
            else{
                var animal = animals.create((i-7) * 150, i*5 + 450, 'cow'); // création d'un animal dans le tableau arrAnimals
            }
        }
        if(animal !== undefined){
            animal.inputEnabled = true; 
            arrAnimals.push(animal);
        }
    }
}

function getJSON(value, callback){
    var request = $.ajax({
        url : 'getJSON.php',
        method : 'GET',
        data : 'value='+value,
        dataType : 'json'
    });

    request.done(function(msg) {
        if(value == 'level'){
            level = msg;
        }
        callback();
    });
}

/******** JQUERY ***********/
$(document).ready(function(){
    $('.btn-play').on('click', function(){
        
        getJSON('level', function(data){
            initCalcul();

            var randomReponse = randomArray(arrReponse);
            var nb_stars = 3;
            createStars(nb_stars, randomReponse, game);
            createAnimals(reponse, game);
            updateLife(game); // initialise les 3 vies de départ
        });  
        
        // Unpause the game
        game.paused = false;
        destroyRules();
        $(this).fadeOut();
    });
});