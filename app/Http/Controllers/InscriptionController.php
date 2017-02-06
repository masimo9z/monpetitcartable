<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Hash;

class InscriptionController extends Controller
{

    public function getInfos()
    {
		return view('inscription');
	}

	public function postInfos(Request $request)
	{
        
        function TestCaptcha($code, $ip = null)
        {
            if(empty($code)){
                return false; // On vérifie si y'a déjà une entrée
            }
      
            $params = [
                'secret'    => '6LcxpggUAAAAAOOzKaAVr3D-EsQCC4nfh_MQVbFi',
                'response'  => $code
            ];
    
            if($ip){
                $params['remoteip'] = $ip;
            }
    
            $url = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
            if (function_exists('curl_version')) {
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_TIMEOUT, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
                $response = curl_exec($curl);
            } 
            else 
            {
                $response = file_get_contents($url);
            }
            
            if (empty($response) || is_null($response)) {
                return false;
            }

            $json = json_decode($response);
            return $json->success;
        }

        // On récupère toutes les données envoyées :
        
        $pseudo = $request->input('pseudo');
        $password = $request->input('password');
        $password_confirm = $request->input('pass-confirm');
        $email = $request->input('email');
        $sexe = $request->input('sexe');
        $groupe = $request->input('groupe');
        $date_naissance = $request->input('date_naissance');
        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = TestCaptcha($_POST['g-recaptcha-response']);
   
        if(empty($pseudo) || empty($password) || empty($password_confirm) || 
           empty($email) || empty($groupe) || empty($captcha)){
            
            if(empty($pseudo)){
                echo "<p>Pseudo manquant</p>";
            }
        
            if(empty($password) || empty($password_confirm)){
                echo "<p>Mot de passe manquant</p>";
            }
            
            if(empty($email)){
                echo "<p>Email manquant</p>";
            }
            
            if(empty($groupe)){
                echo "<p>Groupe manquant</p>";
            }
            
            if(empty($captcha)){
                echo "<p>Captcha non validé</p>";
            }
        }
        else
        {
            // Traitement des pseudos
            $pseudo_exist = DB::table('mpc_user')
                ->select('*', DB::raw('COUNT(*)'))
                ->where('pseudo', $pseudo)
                ->count();
            
            if($pseudo_exist > 0){
                echo "<p>Ce pseudo existe déjà";
            }
            else
            {
                if(strlen($pseudo) > 10 && strlen($pseudo) < 3){
                    echo "<p>Le pseudo doit être compris entre 3 et 10 caractères</p>";
                }
                else
                {
                    // Traitement des password
                    if($password != $password_confirm){
                        echo "<p>Vos deux mots de passes sont différents";
                    }
                    else{
                        if(strlen($password) < 5){
                            echo "<p>Le mot de passe doit faire au minimum 5 caractères</p>";
                        }
                        else
                        {
                            // Traitement d'email
                            $email_exist = DB::table('mpc_user')
                                ->select('*', DB::raw('COUNT(*)'))
                                ->where('email', $email)
                                ->count();
                            
                            if($email_exist > 0){
                                echo "<p>Cette adresse e-mail est déjà utilisée</p>";
                            }
                            else
                            {
                                // L'inscription est bonne, on crypte le mot de passe
                                
                                $mdp_secure = Hash::make($password);
                                
                                DB::insert('insert into mpc_user (id, pseudo, rang, groupe, date_naissance, ip, email, password, sexe, date_inscription, remember_token) values ("", "'.$pseudo.'", "0", "'.$groupe.'", "'.$date_naissance.'", "'.$ip.'", "'.$email.'", "'.$mdp_secure.'", "'.$sexe.'", NOW()), ""');
                                
                                echo "Vous êtes inscrit à Mon petit cartable !";
                            }
                        }
                    }
                }
            }
        }
	}

}