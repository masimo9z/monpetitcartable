<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class ConnexionController extends Controller
{
    public function getForm()
    {
		return view('connexion');
	}

	public function postForm(Request $request)
	{
        $pseudo = $request->input('pseudo');
        $password = $request->input('password');
        $ip = $_SERVER['REMOTE_ADDR'];
        
        if(empty($pseudo) || empty($password)){
            echo "Tous les champs doivent être complétés.";
        }
        else
        {
            $pseudo_exist = DB::table('mpc_user')
                ->select('*', DB::raw('COUNT(*)'))
                ->where('pseudo', $pseudo)
                ->count();
            
            if($pseudo_exist < 1){
                echo "Pseudo inexistant";
            }
            else
            {
                // On vérifie le mot de passe
                $query = DB::table('mpc_user')
                    ->select('password')
                    ->where('pseudo', $pseudo)
                    ->lists('password');
                
                foreach($query as $pass)
                
                if($pass != md5($password)){
                     echo "Mot de passe incorrect";
                }
                else
                {
                    $query_id = DB::table('mpc_user')
                        ->select('id')
                        ->where('pseudo', $pseudo)
                        ->lists('id');
                
                    foreach($query_id as $id)
                        
                        session_start();
                        $_SESSION['id'] = $id;
                        $_SESSION['pseudo'] = $pseudo;
                        $time = time();
                    
                        echo "Vous êtes connecté ! <a href='./'>Retour à l'accueil</a>";
 
                    $pseudo = htmlspecialchars($_SESSION['pseudo']);

                    DB::insert('insert into mpc_connection (id, id_user, ip, timestamp) 
                    values ("", "'.$id.'",  "'.$ip.'", "'.$time.'")');

                }   
            }
        }
    }   
}   