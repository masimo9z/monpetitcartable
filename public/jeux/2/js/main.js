/* 
Level 1 : Cp/CE1
Level 2 : Ce2
Level 3 CM1/CM2
*/
$(document).ready(function (){

    var model = {
        arrReponse: [],
        arrIndications: [],
        modes: null,
        level: null,
        chosenMode: null,
        lifes: null,
        score: 0,
        cardScore: [10,20,30,40,50,60,70,80,90,100]
    }
    Main();
    
    function getJSON(file, value, callback){
        if(file === '' || file === undefined)
        var file = 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/2/getJSON.php';
        var request = $.ajax({
            url : file,
            method : 'GET',
            data : 'value='+value,
            dataType : 'json'
        });

        request.done(function(msg) {
            callback(msg);
        });
        
        request.fail(function(d, textStatus, error) {
            console.log("getJSON failed, status: " + textStatus + ", error: "+ error);
        });
    }
    
    function Main(){

        getJSON('', 'level', function(niveau){
                    niveau = $('.user-active').attr('data-groupe');
            
            
            if(niveau == 0)
                niveau = 5;
            

            if(niveau < 3)
                model.level = 1;
            if(niveau == 3)
                model.level = 2;
            if(niveau > 3)
                model.level = 3;
            getJSON('https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/2/textes.json', '', function(data){
                // Pour initialiser les boutons des différents modes
                model.lifes = 3;
                model.modes = data;
                renderMode(model.modes.modesNames);
                initSelectors();
                renderLifes();
                renderScore();
            });
        });
    }
    
    function renderMode(arrMode){
        var reponse = "";
        $.each(arrMode, function(index, value) {
            reponse += "<p class='modeText' data-id='"+index+"'>"+value+"</p>";
        });
        $('#content .modes').append(reponse);
    }
    
    function renderTexte(texte){
        $.each(model.arrReponse, function(index, value) {
            texte = texte.replace(value, "<input type='text' class='inputText' placeholder='"+model.arrIndications[index]+"'>");
        });
                
        $('#content .exercice').html('');
        $('#content .exercice').append('<p class="exercice-text">'+texte+"</p>");
        $('#content .exercice').append('<button class="exercice-submit">Valider</button>');
        $('#content .exercice').fadeIn();
    }
    
    function renderHelp(texte){
        var consigne = "<p class='help-text'>Aide : "+texte+"</p>";
        $('#content .help').html('');
        $('#content .help').append(consigne);
        $('#content .help').fadeIn();
    }
    
    function initTexte(dataId){
        var levelText = 'level'+model.level;
        // Get the size of an object
        var size = Object.size(model.modes.modes[dataId][levelText]);
        var randomValue = Math.floor(Math.random() * size);
        var randomElmt = model.modes.modes[dataId][levelText][randomValue];
        model.arrReponse = model.modes.corrections[dataId][levelText][randomValue+1];
        model.arrIndications = model.modes.indications[dataId][levelText][randomValue+1];
        renderTexte(randomElmt);
    }
    
    function initHelp(dataId){
        var levelText = 'level'+model.level;
        var consigne = model.modes.modesConsignes[dataId];
        renderHelp(consigne);
    }
    
    function initSelectors(){
        $('#content .modes').on('click', '.modeText', function(e){
            if($(this).hasClass('active'))
                return false;
            /*if($('.modes .modeText.active').length > 0){
                if(alertChange('En changeant de mode, votre score sera réinitilisaé, êtes-vous sûr(e) ?')){
                    $('.modeText').removeClass('active');
                    $(this).addClass('active');
                    $('.modeText').css('height', 'auto');
                    $('.modeText').css('line-height', '30px');
                    $('.modeText').css('font-size', '15px');
                    var dataId = $(this).attr('data-id');
                    model.chosenMode = dataId;
                    initHelp(dataId); 
                    initTexte(dataId);
                }
            }
            else{*/
                $('.modeText').removeClass('active');
                $(this).addClass('active');
                $('.modeText').addClass('started');
                var dataId = $(this).attr('data-id');
                model.chosenMode = dataId;
                initHelp(dataId); 
                initTexte(dataId); 
            /*}*/
    });
        
        $('#content .exercice').on('click', '.exercice-submit', function(){
            checkWin();
        });
        
        $('#content .exercice').on('click', '.exercice-next', function(){
            next();
        });
    }
    
    function checkWin(){
        var inputs = $('.exercice .inputText');
        
        $.each(inputs, function(index, element) {
            if($(element).val().toLowerCase() == model.arrReponse[index].toLowerCase()){
                $(element).removeClass('bad');
                $(element).addClass('good');
                if($('.exercice .inputText.good').length == model.arrReponse.length){
                    initNext();
                    model.score++;
                    renderScore();
                    return false;
                }
            }
            else{
                model.lifes--;
                if(model.lifes == 0){
                    restart();                    
                }
                else{
                    renderLifes();
                    $(element).removeClass('good');
                    $(element).addClass('bad');                    
                }
                return false;
            }
        });
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
            url : 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/2/add.php',
            method : 'GET',
            data : data,
            dataType : 'html'
        });

        request.done(function( msg ){
        });
    }
    
    function renderScore(){
        $('.score #score-value').html(model.score);
        if(model.score > 4){
            $('#content .help').fadeOut(function(){$('#content .help').html('');});
            $('#content .exercice-text').css('margin-top','2px');
            CheckCardWin();
        }
        
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
    
    function renderLifes(){
        reponse = "";
        for(var i=1; i<=model.lifes; i++){
            reponse += "<li class='life-item'><img src='https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/2/img/life.png' alt=''></li>";
        }
        $('.lifes-list').html(reponse);
    }
    
    function initNext(){
        $('#content .exercice .exercice-submit').remove();
        $('#content .exercice').append('<button class="exercice-next">Suivant</button>');
    }
    
    function next(){
        initTexte(model.chosenMode);
    }
    
    function restart(){
        model.lifes = 3;
        model.score = 0;
        renderLifes();
        renderScore();
        $('#content .exercice').fadeOut(function(){ $(this).html('');});
        $('#content .help').fadeOut(function(){ $(this).html('');});

        $('.modeText').removeClass('started').removeClass('active');
    }
    
    function alertChange(message){
        if(confirm(message)) {
            return true;
        }
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
});