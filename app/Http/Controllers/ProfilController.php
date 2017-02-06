<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Validator;
use Auth;
use DB;
use Hash;


class ProfilController extends Controller
{
    public function getInfosProfil($id){   
        $userId = Auth::id();
        
        if(Auth::guest())
            return redirect('connexion');  
        else
        {
            $existChildrens = DB::table('mpc_family')
                ->where('id_parent', $userId)
                ->where('id_enfant', $id)
                ->count();
            
            if($existChildrens > 0){
                $infos_enfant = DB::table('mpc_user')
                    ->where('id', $id)
                    ->get();
                
                $files = DB::table('mpc_family')
                    ->where('id_parent', $userId)
                    ->where('id_enfant', $id)
                    ->get();
                
                return view('profil', ['infos' => $infos_enfant, 'fichiers' => $files]);
            }
            else
            {
                $textemessage = "Vous ne pouvez pas accéder à ce profil ! Redirection en cours...";
                $lienredirect = "/compte";
                
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
        }
    }
    
    public function updatePassword(Request $request){
        $userId = Auth::id();
        
        $this->validate($request, [
            'newmdp' => 'required|min:5',
            'newmdp-confirm' => 'required|same:newmdp',
        ]);
          
            $pass = bcrypt($request['newmdp']);                            
            DB::table('mpc_user')->where('id', $userId)->update(['password' => $pass]);
        
        $textemessage = "Votre mot de passe a été mis-à-jour. Redirection en cours...";
        $lienredirect = "/compte";
                
        return view('redirect', [
            'message' => $textemessage,
            'lienredirect' => $lienredirect
        ]);
    }
    
    public function updateName(Request $request){
        $userId = Auth::id();
        
        $this->validate($request, [
            'nom' => 'required_without_all:prenom',
            'prenom' => 'required_without_all:nom',
        ]);
        
        if($request['nom'] == null){
            $prenom_ok = htmlspecialchars(addslashes($request['prenom']));
            DB::table('mpc_user')->where('id', $userId)->update(['prenom' => $prenom_ok]);   
        }
        else if($request['prenom'] == null){
            $nom_ok = htmlspecialchars(addslashes($request['nom']));
            DB::table('mpc_user')->where('id', $userId)->update(['nom' => $nom_ok]);
        }
        else{
            $prenom_ok = htmlspecialchars(addslashes($request['prenom']));
            $nom_ok = htmlspecialchars(addslashes($request['nom']));
            DB::table('mpc_user')->where('id', $userId)->update(['nom' => $nom_ok, 'prenom' => $prenom_ok]);
        }
        
        $textemessage = "Informations modifiées";
        $lienredirect = "/compte";
                
        return view('redirect', [
            'message' => $textemessage,
            'lienredirect' => $lienredirect
        ]);
    }   
    
	public function updateInfos(Request $request)
	{
        $avatar = $request->input('avatar');
        
        $userId = Auth::id();
        
        if(empty($avatar)){
            return redirect('/compte')
                ->with('message', 'Le champ n\'est pas rempli');
        }
        else
        {
            if(isset($avatar)){
                if($avatar < 1 || $avatar > 10){
                    $textemessage = "Cet avatar n'existe pas.";
                    $lienredirect = "/compte";
                  
                    return view('redirect', [
                        'message' => $textemessage,
                        'lienredirect' => $lienredirect
                    ]);
                    
                }
                else
                {
                    if($avatar > 5){
                        $verif_possession = DB::table('mpc_avatars')
                            ->where('id_membre', $userId)
                            ->where('id_avatar', $avatar)
                            ->count();
                        
                        if($verif_possession < 1){
                            $textemessage = "Vous n'avez pas cet avatar. Rendez-vous à la boutique. Redirection en cours...";
                            $lienredirect = "/compte";
                
                            return view('redirect', [
                                'message' => $textemessage,
                                'lienredirect' => $lienredirect
                            ]);
                        }       
                    }
                    
                    DB::statement("UPDATE mpc_user SET avatar = ".$avatar." where id = ".$userId."");
                    DB::table('mpc_user')->where('id', $userId)->update(['avatar' => $avatar]);
                    
                    $textemessage = "Vous avez changé d'avatar ! Redirection en cours...";
                    $lienredirect = "/compte";
                
                    return view('redirect', [
                        'message' => $textemessage,
                        'lienredirect' => $lienredirect
                    ]);
                }
            }   
            else
            {
                $textemessage = "Action inexistante ! Redirection en cours...";
                $lienredirect = "/compte";
                
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
        }
	}
    
    public function insertKid(Request $request){
        $userId = Auth::id();
        $randomPass = createPassword();
        
        $this->validate($request, [
            'nom' => 'required|max:30',
            'prenom' => 'required|max:20',
            'pseudo' => 'required|max:10|unique:mpc_user',
            'classe' => 'required',
        ]);
        
        // Validateur ok !
        
        $nbr_users = DB::table('mpc_user')->count();
        $nbr_users++;
        
        // Création de l'user
        DB::table('mpc_user')->insert([
            'id' => '',
            'id_facebook' => '0',
            'pseudo' => $request['pseudo'],
            'nom' => $request['nom'],
            'prenom' => $request['prenom'],
            'rang' => '1',
            'groupe' => '1',
            'classe' => $request['classe'],
            'id_classe' => '',
            'avatar' => '1',
            'vie' => '3',
            'date_naissance' => isset($request['date_naissance'])?$request['date_naissance']:null,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'email' => '',
            'password' => bcrypt($randomPass),
            'sexe' => isset($request['genre'])?$request['genre']:null,
            'date_inscription' => date("Y-m-d H:i:s"),
            'remember_token' => '',
        ]);
        
        $prefix_fichier = rand(1, 1000000000);
        $nom_file = "".$request['pseudo']."_".$prefix_fichier.".txt";
        $texte = "Pseudo : ".$request['pseudo']." - Mot de passe : ".$randomPass."";
        
        $recups = DB::table('mpc_user')
            ->where('pseudo', $request['pseudo'])
            ->get();
        
        foreach($recups as $recup){
            // Création du lien familial
            DB::table('mpc_family')->insert([
                'id' => '',
                'id_parent' => $userId,
                'id_enfant' => $recup->id,
                'filepass' => $nom_file,
            ]);
        }
        
        
        
        
        
        // création du fichier
        $file = fopen("passwords/".$nom_file, "x+");
        // écriture
        fputs($file, $texte );
        // fermeture
        fclose($file);
        
        $textemessage = "Le compte enfant a été créé. Redirection en cours...";
        $lienredirect = "/compte";
                
        return view('redirect', [
            'message' => $textemessage,
            'lienredirect' => $lienredirect
        ]);
    }
    
    public function insertClasse(Request $request){
        $userId = Auth::id();
        
        $this->validate($request, [
            'ecole' => 'required|max:30',
            'classe' => 'required',
            'nbreleve' => 'required|max:2',
            'prefixe' => 'required|max:10|unique:mpc_classe',
        ]);
        
        // Validateur OK !
        
        if($request['nbreleve'] > 50)
        {
            $textemessage = "Vous ne pouvez pas ajouter plus de 50 élèves. Redirection en cours...";
            $lienredirect = "/compte";
                
            return view('redirect', [
                'message' => $textemessage,
                'lienredirect' => $lienredirect
            ]);
        }
        else
        {
            $verif_prefix = DB::table('mpc_classe')
                ->where('prefixe', $request['prefixe'])
                ->count();
            
            if($verif_prefix > 0)
            {
                $textemessage = "Ce préfixe existe déjà. Redirection en cours...";
                $lienredirect = "/compte";
                
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }

            $prefix_fichier = rand(1, 1000000000);
            $nom_file = $userId."_".$prefix_fichier.".txt";
            
            DB::table('mpc_classe')->insert([
                'id' => '',
                'id_enseignant' => $userId,
                'ecole' => htmlspecialchars($request['ecole']),
                'niveau' => $request['classe'],
                'nbr_eleves' => $request['nbreleve'],
                'prefixe' => htmlspecialchars($request['prefixe']),
                'filepass' => $nom_file,
            ]);
            
            $file = fopen("passwords/".$nom_file, "x+");
            
            for($nbrPassword = 1; $nbrPassword <= $request['nbreleve']; $nbrPassword++){
                $randomPass = createPassword();
                $prefixe_complet = $request['prefixe']."_".$nbrPassword;
                $texte = "Pseudo : ".$prefixe_complet." - Mot de passe : ".$randomPass."\r\n";
                
                $ids = DB::table('mpc_classe')
                    ->where('prefixe', $request['prefixe'])
                    ->get();
                
                foreach($ids as $id)
                {
                    DB::table('mpc_user')->insert([
                        'id' => '',
                        'id_facebook' => '0',
                        'pseudo' => $prefixe_complet,
                        'nom' => 'Anonyme',
                        'prenom' => 'Anonyme',
                        'rang' => '1',
                        'groupe' => '1',
                        'classe' => $request['classe'],
                        'id_classe' => $id->id,
                        'avatar' => '1',
                        'vie' => '3',
                        'date_naissance' => '',
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'email' => '',
                        'password' => bcrypt($randomPass),
                        'sexe' => '',
                        'date_inscription' => date("Y-m-d H:i:s"),
                        'remember_token' => '',
                    ]);
                }
                
                fwrite($file, $texte );
            }
            
            fclose($file);
            
            $textemessage = "Les comptes de vos élèves ont été créés. Redirection en cours...";
            $lienredirect = "/compte";
                
            return view('redirect', [
                'message' => $textemessage,
                'lienredirect' => $lienredirect
            ]);
        }
        
    }
    

}