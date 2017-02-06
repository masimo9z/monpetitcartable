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
use Input;

class BoutiqueController extends Controller
{  
    public function getVente(){
        
        if(Auth::guest())
            return redirect('connexion');  
        else
        {
            $userId = Auth::id();
            
            $avatars_possedes = DB::table('mpc_avatars')
                ->where('id_membre', $userId)
                ->count();
            
            if($avatars_possedes > 0){
                
                $infos_avatars = DB::table('mpc_avatars')
                    ->where('id_membre', $userId)
                    ->get();
                
                foreach($infos_avatars as $info){
                    $avatars = DB::table('mpc_boutique')
                        ->whereNotIn('id_avatar', [$info->id_avatar])
                        ->get();
                }  
            }
            else
            {
                $avatars = DB::table('mpc_boutique')
                    ->get();
            }
            
            return view('boutique', [
                'avatars' => $avatars
            ]);
        }  
    }
    
    public function doAchat(){
        
        if(Auth::guest())
            return redirect('connexion');  
        else
        {
            $userId = Auth::id();
            $avatar_choisi = Input::get('choice');
            
            if($avatar_choisi >= 6 && $avatar_choisi <= 10){
            
                $havechoice = DB::table('mpc_avatars')
                    ->where('id_membre', $userId)
                    ->where('id_avatar', $avatar_choisi)
                    ->count();
                
                if($havechoice > 0){
                    
                    $textemessage = "Vous avez déjà acheté cet avatar ! Redirection en cours...";
                    $lienredirect = "/boutique";
                     
                    return view('redirect', [
                        'message' => $textemessage,
                        'lienredirect' => $lienredirect
                    ]);
                }
                else
                {
                    $cost_avatars = DB::table('mpc_boutique')
                        ->where('id_avatar', $avatar_choisi)
                        ->get();
                    
                    foreach($cost_avatars as $price){
                        if(Auth::user()->vie >= $price->prix){
                            
                            $depense = Auth::user()->vie - $price->prix;
                            
                            DB::table('mpc_user')
                                ->where('id', $userId)
                                ->update([
                                    'avatar' => $avatar_choisi,
                                    'vie' => $depense
                                ]);
                            
                            DB::table('mpc_avatars')
                                ->insert([
                                    'id' => '',
                                    'id_membre' => $userId,
                                    'id_avatar' => $avatar_choisi
                                ]);
                            
                            $textemessage = "Vous avez acheté cet avatar ! Redirection en cours...";
                            $lienredirect = "/compte";
                     
                            return view('redirect', [
                                'message' => $textemessage,
                                'lienredirect' => $lienredirect
                            ]);
                        }
                        else
                        {
                            $textemessage = "Vous n'avez pas assez de Vies ! Redirection en cours...";
                            $lienredirect = "/boutique";
                     
                            return view('redirect', [
                                'message' => $textemessage,
                                'lienredirect' => $lienredirect
                            ]);
                        }
                    }
                }
            
            }
            else
            {
                $textemessage = "Cet avatar n'existe pas ! Redirection en cours...";
                $lienredirect = "/boutique";
                     
                return view('redirect', [
                    'message' => $textemessage,
                    'lienredirect' => $lienredirect
                ]);
            }
               
        }
         
    }
}