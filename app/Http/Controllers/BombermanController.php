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


class BombermanController extends Controller
{  
    public function getGame(){
        
        if(Auth::guest())
            return redirect('connexion');  
        else
        {
            $userId = Auth::id();
            
            $nombre_vies = DB::table('mpc_bomberman')
                ->where('id_user', $userId)
                ->count();
            
            if($nombre_vies == 0){
                return redirect('achat-partie');
            }
            else{
                
            }
                
        
            return view('bomberman', [
             
            ]);
        }
    }
    
    public function achatPartie(){
        if(Auth::guest())
            return redirect('connexion');  
        else
        {
            $userId = Auth::id();
            
            $nombre_vies = DB::table('mpc_bomberman')
                ->where('id_user', $userId)
                ->count();
            
            if($nombre_vies == 0){
                return view('achat-partie');
            }
            else{
                return redirect('bomberman');
            }
        
            
        }
    }
    
    public function validationAchat(){
        if(Auth::guest())
            return redirect('connexion');  
        else
        {
            $userId = Auth::id();
            
            $nombre_vies = DB::table('mpc_bomberman')
                ->where('id_user', $userId)
                ->count();
            
            if($nombre_vies == 0){
                if(Auth::user()->vie >= 10){
                    $depense = Auth::user()->vie - 10;
                            
                    DB::table('mpc_user')
                        ->where('id', $userId)
                        ->update([
                            'vie' => $depense
                        ]);
                                
                    DB::table('mpc_bomberman')
                        ->insert([
                            'id' => '',
                            'id_user' => $userId
                        ]);
                    
                    $textemessage = "Vous avez acheté une partie ! Redirection en cours...";
                    $lienredirect = "/bomberman";
                 
                    return view('redirect', [
                        'message' => $textemessage,
                        'lienredirect' => $lienredirect
                    ]);  
                }
                else
                { 
                    $textemessage = "Vous n'avez pas assez de vies pour effectuer un achat. Redirection en cours...";
                    $lienredirect = "/compte";
                
                    return view('redirect', [
                        'message' => $textemessage,
                        'lienredirect' => $lienredirect
                    ]);
                }
            }
            else
            {
                $textemessage = "Vous avez encore une partie ! Redirection en cours...";
                $lienredirect = "/compte";
                
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }  
        }
    }
}