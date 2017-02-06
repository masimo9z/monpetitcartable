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


class ClassementController extends Controller
{  
    public function getScore(){
        
        if(Auth::guest())
            return redirect('connexion');  
        else
        {
            $userId = Auth::id();
            
            $bestusers = DB::table('mpc_user')
                ->orderBy('vie', 'desc')
                ->limit('3')
                ->where('groupe', '1')
                ->get();
            
            $users = DB::table('mpc_user')
                ->orderBy('vie', 'desc')
                ->where('groupe', '1')
                ->get();
            
            $init = 1;
            $initbest = 1;
            
            return view('classement', [
                'users' => $users,
                'bestusers' => $bestusers,
                'init' => $init,
                'initbest' => $initbest
            ]);
        }
        
    }
}