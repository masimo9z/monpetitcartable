<?php
	include('connect.php');
	$idUser = (isset($_GET['userId'])) ? $_GET['userId'] : ""; /* Pour dire qu'on souhaite accéder aux musiques */
        $return = []; 
	if(!empty($idUser )){
	        $result = $DB->query("SELECT * FROM mpc_bomberman WHERE id_user  = ".$idUser);
		if($result != false){
			$DB->query("DELETE FROM mpc_bomberman WHERE id_user  = ".$idUser);
			$return['msg'] = 'success'; 
		        echo json_encode($return);
		}
    	}
	else{
        	$return['msg'] = 'error';
	        echo json_encode($return);
	}
?>