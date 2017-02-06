var model = {
    width:800,
    height:600,
    self:null,
    lifes: 3,
    arrLifes: [],
    score: 0,
    cardScore: [10,20,30,40,50,60,70,80,90,100],
    box:{
        boxNames:['boxWalk', 'boxFly', 'boxSwim'],
        arrBoxThis: [],
        boxXPosition: [250, 435, 620],
        randomBox: null,
        thisRandomBox: null
    },
    shape:{
        arrays:{
            arrShapeBox1:['square', 'square2', 'square3', 'rectangle', 'rectangle2'],
            arrShapeBox2:['circle', 'circle2', 'circle3'],
            arrShapeBox3:['star', 'star2', 'star3'],            
        },
        randomShape: null,
        randomShapeBox: null,
        thisRandomShape: null,
        gravity: 0,
        gravityScores:[5,10,15,20,25,30,35,40,45,50]
    },
    rules:{
        rules: '',
        rules_text: '',
        rules_one: false
    },
    menu:{
        menu: null,
        activeMenu: null
    },
    arrRandomValue: []
};
var rules;

document.addEventListener("DOMContentLoaded", Main, false); // appel au chargement de la page

/**
* Fonction principale
* Appelée au chargement de la page
*
*/
function Main(){    
    // création de la zone de jeu - API Canvas
    game = new Phaser.Game(model.width, model.height, Phaser.AUTO, 'idGameDiv', { preload: preload, create: create});
    console.log(game.state.current);
}

function preload(){
    var self = this;
    self.scale.pageAlignHorizontally = true;
    //this.game.load.image('hueso', huesoURI);
    //this.game.load.image('flecha', flechaURI);

    $.each(model.shape.arrays, function(index, value) {
        for(i=0; i<model.shape.arrays[index].length; i++){
            console.log(model.shape.arrays[index][i]);
            self.load.image(model.shape.arrays[index][i], "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/5/img/"+model.shape.arrays[index][i]+".png");
        }
    });
    
    self.load.image('life', 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/5/img/life.png');
    self.load.image("bg", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/5/img/bg.png");
    self.load.image('boxWalk', 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/5/img/boxSquare.png');
    self.load.image('boxFly', 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/5/img/boxCircle.png');
    self.load.image('boxSwim', 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/5/img/boxStar.png');
    self.load.image('menu', 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/5/img/button3.png', 400, 90);
    self.load.image("rules", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/5/img/rules.png");
}

function create(){
    this.game.physics.startSystem(Phaser.Physics.ARCADE);
    model.self = this;
    
    rules = game.add.group(); // ajout des étoiles dans un groupe
    rules.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    var grounds = game.add.group(); // ajout des étoiles dans un groupe
    //ground = game.add.sprite(0, 420, 'ground');
    grounds.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    background = grounds.create(0, 0, 'bg'); // création d'une étoile dans le groupe 'étoiles'
    
    scoreText = model.self.add.text(10, 10, 'Vos points : 0', {fontSize: '33px', fill: '#000'}); // ajoute le score
    
    // Create a label to use as a button
    pause_label = model.self.add.text(model.width - 100, 10, 'Menu', { font: '33px Arial', fill: '#000' });
    pause_label.inputEnabled = true;
    pause_label.events.onInputUp.add(function () {
        displayMenu();
    });
    
    game.paused = true;
    updateLife(); // J'initialise l'affichage des points de vie
    createBox(); // Je créée mes différentes boites
    initRandomShape(model.self); // J'instancie au hasard ma forme
    createShape(); // Je crée ma forme
    displayRules(grounds);
    
        // Add a input listener that can help us return from being paused
    game.input.onDown.add(unpause, self);

    // And finally the method that handels the pause menu
    function unpause(event){
        // Only act if paused
        if(game.paused){
            // Calculate the corners of the menu
            // qd onajoute un bouton changer le premier nombre de la division, ici 400. Ne pas toucher au 2
            var x1 = model.width/2 - 400/2, x2 = model.width/2 + 400/2,
                y1 = model.height/2 - 90/2, y2 = model.height/2 + 90/2;

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
                    model.menu.menu.destroy();
                    choiseLabel.destroy();

                    // Unpause the game
                    game.paused = false;
                    model.menu.activeMenu = false;
                    model.lifes = 0;
                    restart();
                }
                else if(choisemap[choise] == 'rules'){
                    displayRules(grounds);
                }
            }
            else{
                // Remove the menu and the label
                model.menu.menu.destroy();
                choiseLabel.destroy();
                destroyRules();

                // Unpause the game
                game.paused = false;
                model.menu.activeMenu = false;
            }
        }
    };
}

function stopDrag(currentSprite, endSprite){
    if (!this.game.physics.arcade.overlap(currentSprite, endSprite, function() {
    currentSprite.input.draggable = false;
    currentSprite.position.copyFrom(endSprite.position); 
    currentSprite.anchor.setTo(endSprite.anchor.x, endSprite.anchor.y);
    model.score++;
    CheckCardWin();
    next();
    scoreText.text = 'Vos points : ' + model.score;
  })) {
    currentSprite.position.copyFrom(currentSprite.originalPosition);
    model.lifes--;
    updateLife();
    restart();
  }
}

function createBox(){
    var randBox = randomArray(model.box.boxNames);
    model.box.boxNames = randBox;
    
    for(var i=0; i<randBox.length; i++){
        switch(randBox[i]) {
            case 'boxWalk':
                model.self.boxWalk = model.self.game.add.sprite(model.box.boxXPosition[i], model.self.game.world.height, 'boxWalk');
                model.self.boxWalk.anchor.setTo(0, 1);
                model.self.boxWalk.id = 'arrShapeBox1';
                model.self.game.physics.arcade.enable(model.self.boxWalk);
                model.box.arrBoxThis.push(model.self.boxWalk);
                break;
            case 'boxFly':
                model.self.boxFly = model.self.game.add.sprite(model.box.boxXPosition[i], model.self.game.world.height, 'boxFly');
                model.self.boxFly.anchor.setTo(0, 1);
                model.self.boxFly.id = 'arrShapeBox2';
                model.self.game.physics.arcade.enable(model.self.boxFly);
                model.box.arrBoxThis.push(model.self.boxFly);
                break;
            case 'boxSwim':
                model.self.boxSwim = model.self.game.add.sprite(model.box.boxXPosition[i], model.self.game.world.height, 'boxSwim');
                model.self.boxSwim.anchor.setTo(0, 1);
                model.self.boxSwim.id = 'arrShapeBox3';
                model.self.game.physics.arcade.enable(model.self.boxSwim);
                model.box.arrBoxThis.push(model.self.boxSwim);
                break;
            default:
                model.box.thisRandomBox = '';
        }
    }
}

function initRandomShape(self){
    /*
    par rapport à lid de la box je sélctionne une valeur au hasard du tableau,
    puis j'attribue à cette valeur l'id de la boite pour ensuite la vérifier dans stopDrag() */
    
    var randomBox = model.box.boxNames[Math.floor(model.box.boxNames.length * Math.random())];
    model.box.randomBox = randomBox; // model.box.randomBox est la réponse à choisir
    
    switch(model.box.randomBox) {
        case 'boxWalk':
            model.box.thisRandomBox = self.boxWalk;
            break;
        case 'boxFly':
            model.box.thisRandomBox = self.boxFly;
            break;
        case 'boxSwim':
            model.box.thisRandomBox = self.boxSwim;
            break;
        default:
            model.box.thisRandomBox = '';
    }
    var randElementOfItem = model.shape.arrays[model.box.thisRandomBox.id][Math.floor(model.shape.arrays[model.box.thisRandomBox.id].length * Math.random())];
    model.shape.randomShape = randElementOfItem;
    
    for(var name in model.shape.arrays){
        if(model.box.thisRandomBox.id === name){
            model.shape.randomShapeBox = name;
        }        
    }
}

function createShape(){
    model.self.shape = model.self.game.add.sprite(model.self.game.world.centerX, 0, model.shape.randomShape);
    model.self.shape.anchor.x = 0.5;
    model.self.game.physics.arcade.enable(model.self.shape);
    model.self.shape.inputEnabled = true;
    model.self.shape.input.enableDrag();
    model.self.shape.id = model.shape.randomShapeBox;
    game.physics.enable(model.self.shape, Phaser.Physics.ARCADE);
    model.self.shape.body.gravity.y = model.shape.gravity;
    model.self.shape.originalPosition = model.self.shape.position.clone();
    model.self.shape.checkWorldBounds = true;
    model.self.shape.events.onOutOfBounds.add(function(currentSprite){
        currentSprite.position.copyFrom(currentSprite.originalPosition);
        model.lifes--;
        updateLife();
        restart();
    }, this);
    model.self.shape.events.onDragStop.add(function(currentSprite){
      stopDrag(currentSprite, model.box.thisRandomBox);
    }, model.self);
    model.shape.thisRandomShape = model.self.shape;
}

function CheckCardWin(){
    if(model.cardScore.indexOf(model.score) != -1){
        $('.card').addClass('cardWin');
        addBDD('life', 1);
        setTimeout(function(){
            $('.card').removeClass('cardWin');
        }, 5000);
    }
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
        url : 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/5/add.php',
        method : 'GET',
        data : data,
        dataType : 'html'
    });

    request.done(function( msg ) {
        console.log(msg);
    });
}

function restart(){
    if(model.lifes < 1){
        displayMenu('Vous avez perdu ...');
        for(var i = 0; i < model.box.arrBoxThis.length; i++){
            model.box.arrBoxThis[i].kill();
        }

        model.shape.thisRandomShape.kill();

        model.score = 0;
        model.box.arrBoxThis = [];
        model.shape.thisRandomShape = null;
        model.shape.gravity = 0;

        scoreText.text = 'Vos points : ' + model.score;

        createBox();
        initRandomShape(model.self);
        createShape();

        model.lifes = 3;
    }
    updateLife();
    
    if(model.menu.activeMenu === true){        
        // Remove the menu and the label
        model.menu.menu.destroy();
        choiseLabel.destroy();

        // Unpause the game
        game.paused = false;
        model.menu.activeMenu = false;
    }
}

function play(){
    // Remove the menu and the label
    model.menu.menu.destroy();
    choiseLabel.destroy();

    // Unpause the game
    game.paused = false;
    model.menu.activeMenu = false;
}

function displayMenu(message){
    if(message === '' || message === undefined){
        var message = 'Menu Pause';
    }
    // When the paus button is pressed, we pause the game
    game.paused = true;

    // Then add the menu
    model.menu.menu = game.add.sprite(model.width/2, model.height/2, 'menu');
    model.menu.menu.anchor.setTo(0.5, 0.5);

    // And a label to illustrate which menu item was chosen. (This is not necessary)
    choiseLabel = game.add.text(model.width/2, model.height/3, message, { font: '30px Arial', fill: '#000' });
    choiseLabel.anchor.setTo(0.5, 0.5);
}

function displayRules(grounds){
    if(model.rules.rules_one === false){
        if(model.menu.menu != undefined){
            model.menu.menu.destroy();
            choiseLabel.destroy();            
        }
        
        var regles = "Des animaux sauvages nous envahissent. Glisses chacun d'eux dans la bonne boite.        Utilises ta souris pour les glisser et déposer dans la boîte.";
        model.rules_text = game.add.text(model.width/2 - 120, 200, regles, { font: '18px Arial', fill: '#fff'});
        model.rules = rules.create(model.width/2 - 200, 100, 'rules'); // création d'une étoile dans le groupe 'étoiles'
        model.rules_text.wordWrap = true;
        model.rules_text.wordWrapWidth = 270;
        model.rules_text.lineSpacing = 5;
        model.rules.rules_one = true;
        model.self.world.bringToTop(rules);
        model.self.world.bringToTop(model.rules_text);
    }
}

function destroyRules(){
    if(model.rules != '' && model.rules_text != ''){
        model.rules_text.kill();
        model.rules.destroy();
        model.rules.rules_one = false;
    }
}

function next(){
    for(var i = 0; i < model.box.arrBoxThis.length; i++){
        model.box.arrBoxThis[i].kill();
    }
    model.shape.thisRandomShape.kill();
    
    model.box.arrBoxThis = [];
    model.shape.thisRandomShape = null;
    
    if(model.shape.gravityScores.indexOf(model.score) != -1){
        model.shape.gravity+=5;
    }
    
    createBox();
    initRandomShape(model.self);
    createShape();
}

function updateLife(){
    for(var i = 0; i < model.arrLifes.length; i++){
        model.arrLifes[i].kill();
    }
    lifes = game.add.group(); // ajout des coeurs dans un groupe
    lifes.enableBody = true; // active les lois physiques pour les objets ajoutés dans ce groupe
    
    for(var i = 1; i <= model.lifes; i++){
        var life = lifes.create(i * 20, 70, 'life'); // création d'une étoile dans le groupe 'étoiles'
        life.id = i;// valeur de rebond légèrement aléatoire
        model.arrLifes.push(life);
    }
}

function randomArray(arrayToModif){ // faire script pour reoganiser deux tableaux en meme temps, et les mettre à juor dans cette fonction
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

function getUserId(){
    var userId = $('.user-active').attr('data-number');
    console.log(userId);
    return userId;
}

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

/******** JQUERY ***********/
$(document).ready(function(){
    $('.btn-play').on('click', function(){
        // Unpause the game
        game.paused = false;
        destroyRules();
        $(this).fadeOut();
    });
});

/*
var game = new Phaser.Game(800, 600, Phaser.AUTO, '', {
  preload: function(){
    this.scale.pageAlignHorizontally = true;
    this.game.load.image('hueso', huesoURI);
    this.game.load.image('flecha', flechaURI);
      
    this.load.image('boxFly', 'img/boxFly.png');
    this.load.image('boxWalk', 'img/boxWalk.png');
    this.load.image('boxSwim', 'img/boxSwim.png');
  },
  create: function(){
    this.game.physics.startSystem(Phaser.Physics.ARCADE);
    this.hueso = this.game.add.sprite(this.game.world.centerX, this.game.world.height, 'hueso');
    this.hueso.anchor.setTo(1.5, 1);
    this.game.physics.arcade.enable(this.hueso);
    this.hueso.tint= 0xff00ff; // rose pâle
      
    this.hueso2 = this.game.add.sprite(this.game.world.centerX, this.game.world.height, 'hueso');
    this.hueso2.anchor.setTo(0, 1);
    this.game.physics.arcade.enable(this.hueso2);
    this.hueso2.tint= 0xff00ff; // rose pâle
    
    this.huesoCopy = this.game.add.sprite(this.game.world.centerX, 0, this.hueso.key, this.hueso.frame);
    this.huesoCopy.anchor.x = 0.5;
    this.game.physics.arcade.enable(this.huesoCopy);
    this.huesoCopy.inputEnabled = true;
    this.huesoCopy.input.enableDrag();
    this.huesoCopy.originalPosition = this.huesoCopy.position.clone();
    this.huesoCopy.events.onDragStop.add(function(currentSprite){
      this.stopDrag(currentSprite, this.hueso);
    }, this);
    
    this.flecha = this.game.add.sprite(this.game.world.centerX, this.game.world.centerY, 'flecha');
    this.flecha.anchor.set(0.5);
  },
  stopDrag: function(currentSprite, endSprite){
    if (!this.game.physics.arcade.overlap(currentSprite, endSprite, function() {
    currentSprite.input.draggable = false;
    currentSprite.position.copyFrom(endSprite.position); 
    currentSprite.anchor.setTo(endSprite.anchor.x, endSprite.anchor.y); 
  })) { currentSprite.position.copyFrom(currentSprite.originalPosition);
  }
  }
});*/