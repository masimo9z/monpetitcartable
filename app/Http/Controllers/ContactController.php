<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

    public function getInfos()
    {
		return view('contact');
	}

	public function postInfos(Request $request)
	{
//		echo 'Le pseudo est ' . $request->input('pseudo'); 
//        
//        echo '<br />Le mdp est ' .$request->input('password');
//        
//        echo '<br />Le mdp confirm est ' .$request->input('pass-confirm');
//        
//        echo '<br />Le mail est ' .$request->input('email');
//        
//        echo '<br />Vous êtes ' .$request->input('garcon');
//        
//        echo '<br />Né le ' .$request->input('date_naissance');
//	}

}