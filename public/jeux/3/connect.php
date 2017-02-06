<?php
header("Content-Type: application/json");
ini_set('display_errors',1);
try
{

/*********
** POUR LOCALHOST **
*********/

//$DB = new PDO('mysql:host=130.79.158.79:3306;port:22;dbname=dweb02', 'dweb02', 'OT%7TK3m0OMI2pSU');
$DB = new PDO('mysql:host=base.iha.unistra.fr;dbname=dweb02', 'dweb02', 'OT%7TK3m0OMI2pSU');
$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$DB->exec('SET NAMES utf8, lc_time_names = "fr_FR"');
session_start();
}
catch(Exception $e)
{
// En cas d'erreur, on affiche un message et on arrête tout
die('Erreur : '.$e->getMessage());
}

if(!empty($_POST)){
    
    $mdp = $_POST['motdepasse'];

    $motdepasse = $DB->quote($_POST['motdepasse']);
    $login = $DB->quote($_POST['login']);


    $result = $DB->query("SELECT * FROM connect_access WHERE login=$login");

}

?>