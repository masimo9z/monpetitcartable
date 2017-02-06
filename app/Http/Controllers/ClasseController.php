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


class ClasseController extends Controller
{  
    public function getInfos($id){
        $userId = Auth::id();
        
        if(Auth::guest())
            return redirect('connexion');  
        else
        {
            $existClass = DB::table('mpc_classe')
                ->where('id_enseignant', $userId)
                ->where('id', $id)
                ->count();

            if($existClass > 0){
                
                $existEleve = DB::table('mpc_user')
                    ->where('id_classe', $id)
                    ->count();
                
                $school_infos = DB::table('mpc_classe')
                    ->leftJoin('mpc_user', 'mpc_classe.id', '=', 'mpc_user.id_classe')
                    ->where('id_enseignant', userId())
                    ->get();
                
                $ourclasses = DB::table('mpc_classe')
                    ->where('id_enseignant', userId())
                    ->get();
                
                return view('ma-classe', [
                    'classes' => $school_infos, 
                    'fichiers' => $ourclasses, 
                    'nbreleve' => $existEleve
                ]);
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
    
    public function deleteKid($id_membre){
        $userId = Auth::id();
        
        if(Auth::user()->groupe != 2)
        {
            $textemessage = "Vous n'êtes pas autorisé à effectuer cette action ! Redirection en cours...";
            $lienredirect = "/compte";
                     
            return view('redirect', [
                'message' => $textemessage,
                'lienredirect' => $lienredirect
            ]);
        }
        
        $existEleve = DB::table('mpc_user')
            ->where('id', $id_membre)
            ->count();
        
        if($existEleve < 1)
        {
            $textemessage = "Cet élève n'existe pas ! Redirection en cours...";
            $lienredirect = "/compte";
                     
            return view('redirect', [
                'message' => $textemessage,
                'lienredirect' => $lienredirect
            ]);
        }
        
        $infosEleve = DB::table('mpc_user')
            ->leftJoin('mpc_classe', 'mpc_user.id_classe', '=', 'mpc_classe.id')
            ->where('mpc_user.id', $id_membre)
            ->get();
        
        foreach($infosEleve as $infoEleve){
            
            $infosClasses = DB::table('mpc_classe')
                ->where('id', $infoEleve->id_classe)
                ->where('id_enseignant', $userId)
                ->count();
                
            if($infosClasses < 1)
            {
                $textemessage = "Cet élève n'existe pas ! Redirection en cours...";
                $lienredirect = "/compte";
                     
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
            
            $nbrEleve = DB::table('mpc_user')
                ->where('id_classe', $infoEleve->id_classe)
                ->count();
            
            if($nbrEleve == 1){
                echo "<p>En supprimant votre dernier élève, votre classe est automatiquement supprimée.</p>";
                
                
                DB::table('mpc_classe')
                    ->where('id', $infoEleve->id_classe)
                    ->delete();
            }   
            
            DB::table('mpc_user')
                ->where('id', $id_membre)
                ->update(['id_classe' => '0']);
            
            $textemessage = "L'élève ".$infoEleve->nom." ".$infoEleve->prenom." (".$infoEleve->pseudo.") vient d'être supprimé de sa classe. Redirection en cours...";
            $lienredirect = "/compte";
                     
            echo view('redirect', [
                'message' => $textemessage,
                'lienredirect' => $lienredirect
            ]);
        }
    }
    
    public function deleteClasse($id_classe){
        $userId = Auth::id();
        
        if(Auth::user()->groupe != 2)
        {
            $textemessage = "Erreur 404. Redirection en cours...";
            $lienredirect = "/compte";
                     
            echo view('redirect', [
                'message' => $textemessage,
                'lienredirect' => $lienredirect
            ]);
        }
            
        else
        {
            $existClasse = DB::table('mpc_classe')
                ->where('id_enseignant', $userId)
                ->where('id', $id_classe)
                ->count();
        
            if($existClasse < 1)
                return "Cette classe n'est pas la votre.";
            else
            {
                $updateEleve = DB::table('mpc_user')
                    ->where('id_classe', $id_classe)
                    ->update(['id_classe' => '0']);
                
                $deleteClasse = DB::table('mpc_classe')
                    ->where('id', $id_classe)->delete();
                
                $textemessage = "Cette classe a été supprimée. Redirection en cours...";
                $lienredirect = "/compte";
                     
                echo view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
        }
    }
}