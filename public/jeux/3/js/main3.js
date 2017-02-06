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
            arrShapeBox1:['cat', 'cat2', 'cat3'],
            arrShapeBox2:['bird', 'bird2', 'bird3'],
            arrShapeBox3:['fish', 'fis2', 'fish3'],            
        },
        randomShape: null,
        randomShapeBox: null,
        thisRandomShape: null,
    },
    activeMenu: null,
    arrRandomValue: []
};

document.addEventListener("DOMContentLoaded", Main, false); // appel au chargement de la page

/**
* Fonction principale
* Appelée au chargement de la page
*
*/
function Main(){    
    // création de la zone de jeu - API Canvas
    game = new Phaser.Game(model.width, model.height, Phaser.AUTO, '', { preload: preload, create: create});
    console.log(game.state.current);
}

function preload(){
    this.scale.pageAlignHorizontally = true;
    //this.game.load.image('hueso', huesoURI);
    //this.game.load.image('flecha', flechaURI);
      
    this.load.image("bg", "img/bg.png");
    this.load.image('cat', 'img/cat.png');
    this.load.image('bird', 'img/bird.png');
    this.load.image('fish', 'img/fish.png');
    this.load.image('life', 'img/life.png');
    this.load.image('boxFly', 'img/boxFly.png');
    this.load.image('boxWalk', 'img/boxWalk.png');
    this.load.image('boxSwim', 'img/boxSwim.png');
}

function create(){
    this.game.physics.startSystem(Phaser.Physics.ARCADE);
    model.self = this;
    background =  model.self.add.sprite(0, 0, 'bg');
    scoreText = model.self.add.text(10, 10, 'Vos points : 0', {fontSize: '33px', fill: '#fff'}); // ajoute le score
    
    updateLife(); // J'initialise l'affichage des points de vie
    createBox(); // Je créée mes différentes boites
    initRandomShape(model.self); // J'instancie au hasard ma forme
    createShape(); // Je crée ma forme
}

function stopDrag(currentSprite, endSprite){
    console.log(currentSprite.id);
    console.log(endSprite.id);
    if (!this.game.physics.arcade.overlap(currentSprite, endSprite, function() {
    currentSprite.input.draggable = false;
    currentSprite.position.copyFrom(endSprite.position); 
    currentSprite.anchor.setTo(endSprite.anchor.x, endSprite.anchor.y);
    model.score++;
    CheckCardWin();
    next();
    scoreText.text = 'Vos points : ' + model.score;
    console.log('good');
  })) {
    currentSprite.position.copyFrom(currentSprite.originalPosition);
    console.log('bad');
    model.lifes--;
    updateLife();
    restart();
  }
}

function createBox(){
    /************/    
    var randBox = randomArray(model.box.boxNames);
//    var randShape = randomArray(model.shape.arrShapeName);
//    console.log(randShape);
//    model.shape.arrShapeName = randShape;
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
    var randomBox = model.box.boxNames[Math.floor(model.box.boxNames.length * Math.random())];
    model.box.randomBox = randomBox; // model.box.randomBox est la réponse à choisir
    
    /* Récupérer aléatoirement le contenu d'un item de mon objet */
    var keysObject = Object.keys(model.shape.arrays);
    var randomItem = model.shape.arrays[keysObject[Math.floor(keysObject.length * Math.random())]]; 

    // Je récupère aléatoirement un élement de mon item
    var randElementOfItem = randomItem[Math.floor(Math.random() * randomItem.length)];
    
    for(var name in model.shape.arrays){
        var value = model.shape.arrays[name];
        if(randomItem === value){
            model.shape.randomShapeBox = name;
        }        
    }
    
    console.log(model.shape.randomShapeBox);
    model.shape.randomShape = randElementOfItem;
    switch(model.box.randomBox) {
        case 'boxWalk':
            model.box.thisRandomBox = self.boxWalk;
            console.log(model.box.thisRandomBox.id);
            break;
        case 'boxFly':
            model.box.thisRandomBox = self.boxFly;
            console.log(model.box.thisRandomBox.id);
            break;
        case 'boxSwim':
            model.box.thisRandomBox = self.boxSwim;
            console.log(model.box.thisRandomBox.id);
            break;
        default:
            model.box.thisRandomBox = '';
    }
}

function createShape(){
    model.self.shape = model.self.game.add.sprite(model.self.game.world.centerX, 0, model.shape.randomShape);
    model.self.shape.anchor.x = 0.5;
    model.self.game.physics.arcade.enable(model.self.shape);
    model.self.shape.inputEnabled = true;
    model.self.shape.input.enableDrag();
    model.self.shape.id = model.shape.randomShapeBox;
    console.log(model.self.shape.id);
    model.self.shape.originalPosition = model.self.shape.position.clone();
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

function restart(){
    console.log('restart');
    if(model.lifes < 1){
        
    for(var i = 0; i < model.box.arrBoxThis.length; i++){
        model.box.arrBoxThis[i].kill();
    }
    
    model.shape.thisRandomShape.kill();
    
    score = 0;
    model.box.arrBoxThis = [];
    model.shape.thisRandomShape = null;
    
    scoreText.text = 'Vos points : ' + score;
    
    createBox();
    initRandomShape(model.self);
    createShape();
    
    model.lifes = 3;
    }
    updateLife();
    
    if(model.activeMenu === true){        
        // Remove the menu and the label
        menu.destroy();
        choiseLabel.destroy();

        // Unpause the game
        game.paused = false;
        activeMenu = false;
    }
}

function next(){
    console.log('next');
    for(var i = 0; i < model.box.arrBoxThis.length; i++){
        model.box.arrBoxThis[i].kill();
    }
    model.shape.thisRandomShape.kill();
    
    model.box.arrBoxThis = [];
    model.shape.thisRandomShape = null;
    
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

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};
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