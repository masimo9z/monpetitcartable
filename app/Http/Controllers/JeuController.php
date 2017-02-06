<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Validator;
use Auth;
use DB;
use Input;


class JeuController extends Controller
{
    public function getJeu($classe, $matiere, $game){   
        $userId = Auth::id();
        
        if(Auth::guest())
            return redirect('https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/programme/'.$classe.'/'.$matiere.'#connexion');  
        else
        {
            if($classe == "cp")
                $niveau = 1;
            else if($classe == "ce1")
                $niveau = 2;
            else if($classe == "ce2")
                $niveau = 3;
            else if($classe == "cm1")
                $niveau = 4;
            else if($classe == "cm2")
                $niveau = 5;
            else
            {
                $textemessage = "Cette page n'existe pas. Redirection en cours...";
                $lienredirect = "";
                     
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
            
            if($matiere == "mathematiques")
                $cours = 1;
            else if($matiere == "francais")
                $cours = 2;
            else if($matiere == "geographie")
                $cours = 3;
            else
            {
                $textemessage = "Cette page n'existe pas. Redirection en cours...";
                $lienredirect = "";
                     
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
            
            $exist_jeu = DB::table('mpc_jeu')
                ->where('matiere', $matiere)
                ->where('id', $game)
                ->count();
            
            if($exist_jeu < 1)
            {
                $textemessage = "Page inexistante. Redirection en cours...";
                $lienredirect = "";
                     
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
            else
            {
                $exist_notes = DB::table('mpc_noteJeu')
                    ->where('jeu_id', $game)
                    ->count();
                
                $infos_jeu = DB::table('mpc_jeu')
                    ->where('id', $game)
                    ->get();
                
                if($exist_notes < 1){
                    $note = 0;
                    $result = "Pas encore de résultat";
                    $tanote = 0;
                }
                else
                {
                    $note = 1;
                    
                    $moy_notes = DB::table('mpc_noteJeu')
                        ->where('jeu_id', $game)
                        ->sum('note_value');
                    
                    
                    $result1 = $moy_notes/$exist_notes;
                    $result = round($result1);
                    
                    DB::table('mpc_moyenneJeu')
                        ->where('id_jeu', $game)
                        ->update(['moyenne' => $result]);
                    
                    $tanote = DB::table('mpc_noteJeu')
                        ->where('jeu_id', $game)
                        ->where('user_id', $userId)
                        ->pluck('note_value');
                }
                
                // Les commentaires
                
                $comment_exist = DB::table('mpc_comments')
                    ->where('id_jeu', $game)
                    ->count();
                
                if($comment_exist < 1){
                    $comments = "Il n'y a pas encore de commentaire.";
                }
                else
                {
                    $comments = DB::table('mpc_comments')
                        ->leftJoin('mpc_user', 'mpc_comments.id_user', '=', 'mpc_user.id')
                        ->where('id_jeu', $game)
                        ->get();
                }
                
                return view('jeu', [
                    'infos_jeu' => $infos_jeu,
                    'note' => $note,
                    'result' => $result,
                    'tanote' => $tanote,
                    'comments' => $comments
                    ]);
      
            }
        }
    }
    
    public function addNote($classe, $matiere, $game){   
        $userId = Auth::id();
        
        if(Auth::guest())
            return redirect('https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/programme/'.$classe.'/'.$matiere.'#connexion');  
        else
        {
            if($classe == "cp")
                $niveau = 1;
            else if($classe == "ce1")
                $niveau = 2;
            else if($classe == "ce2")
                $niveau = 3;
            else if($classe == "cm1")
                $niveau = 4;
            else if($classe == "cm2")
            $niveau = 5;
            else
            {
                $textemessage = "Page inexistante. Redirection en cours...";
                $lienredirect = "";
                     
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
            
            if($matiere == "mathematiques")
                $cours = 1;
            else if($matiere == "francais")
                $cours = 2;
            else if($matiere == "geographie")
                $cours = 3;
            else
            {
                $textemessage = "Page inexistante. Redirection en cours...";
                $lienredirect = "";
                     
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
            
            $exist_jeu = DB::table('mpc_jeu')
                ->where('matiere', $matiere)
                ->where('id', $game)
                ->count();
            
            if($exist_jeu < 1)
            {
                $textemessage = "Page inexistante. Redirection en cours...";
                $lienredirect = "";
                     
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
            else
            {
                $deja_note = DB::table("mpc_noteJeu")
                    ->where('user_id', $userId)
                    ->where('jeu_id', $game)
                    ->count();
                
                $note = Input::get('rank');
                
                if($deja_note < 1){
                    DB::table('mpc_noteJeu')->insert([
                        'id' => '',
                        'jeu_id' => $game,
                        'user_id' => $userId,
                        'note_value' => $note,
                        'date_ajout' => date("Y-m-d H:i:s"),
                    ]);
                }
                else
                {
                    DB::table('mpc_noteJeu')
                        ->where('user_id', $userId)
                        ->where('jeu_id', $game)
                        ->update([
                            'note_value' => $note,
                            'date_ajout' => date("Y-m-d H:i:s")
                        ]);
                }
                
                echo "Votre note a été prise en compte. Redirection...";
                    
                return redirect()->back();

            }
        }
    }
    
    public function addComment($classe, $matiere, $game, Request $request){
        $userId = Auth::id();
        
        if(Auth::guest())
            return redirect('https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/programme/'.$classe.'/'.$matiere.'#connexion');
        else
        {
            if($classe == "cp")
                $niveau = 1;
            else if($classe == "ce1")
                $niveau = 2;
            else if($classe == "ce2")
                $niveau = 3;
            else if($classe == "cm1")
                $niveau = 4;
            else if($classe == "cm2")
                $niveau = 5;
            else
            {
                $textemessage = "Page inexistante. Redirection en cours...";
                $lienredirect = "";
                     
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
            
            if($matiere == "mathematiques")
                $cours = 1;
            else if($matiere == "francais")
                $cours = 2;
            else if($matiere == "geographie")
                $cours = 3;
            else
            {
                $textemessage = "Page inexistante. Redirection en cours...";
                $lienredirect = "";
                     
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
            
            $exist_jeu = DB::table('mpc_jeu')
                ->where('matiere', $matiere)
                ->where('id', $game)
                ->count();
            
            if($exist_jeu < 1)
            {
                $textemessage = "Page inexistante. Redirection en cours...";
                $lienredirect = "";
                     
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
            else
            {
                $this->validate($request, [
                    'comment' => 'required',
                ]);
                
                $comment_ok = htmlspecialchars($request['comment']);
                
                DB::table('mpc_comments')
                    ->insert([
                        'id' => '',
                        'id_user' => $userId,
                        'id_jeu' => $game,
                        'comment' => $comment_ok,
                        'timestamp' => date("Y-m-d H:i:s")
                    ]);
                
                return redirect()->back();
            }
        }
    }
}