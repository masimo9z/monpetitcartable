<?php
    include('connect.php');

    $idUser = (isset($_GET['userId'])) ? $_GET['userId'] : ""; /* Pour dire qu'on souhaite accéder aux musiques */
    $score = (isset($_GET['score'])) ? $_GET['score'] : ""; /* Pour dire qu'on souhaite accéder aux musiques */
    $life = (isset($_GET['life'])) ? $_GET['life'] : ""; /* Pour dire qu'on souhaite accéder aux musiques */
    $gameId = (isset($_GET['gameId'])) ? $_GET['gameId'] : ""; /* Pour dire qu'on souhaite accéder aux musiques */
    $return = []; 

    if(!empty($score) && !empty($gameId)){
    // marche pas :     $DB->query("INSERT INTO mpc_group VALUES('', 'cc', ".$userId.")");
        $return['msg'] = 'success'; 
        echo json_encode($return);
    }
    else if(!empty($life)){
        // Il gagne un coeur
        $DB->query("UPDATE mpc_user SET vie = vie + 1 WHERE id  = ".$idUser);
        $return['msg'] = 'success'; 
        
        echo json_encode($return);
    }
    else{
        $return['msg'] = 'error'; 
        echo json_encode($return);
    }
    
?>