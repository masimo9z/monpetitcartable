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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGames()
    {
        genereMoyenne();
        
        $meilleurs_jeux = DB::table('mpc_jeu')
            ->leftJoin('mpc_moyenneJeu', 'mpc_jeu.id', '=', 'mpc_moyenneJeu.id_jeu')
            ->orderBy('moyenne', 'desc')
            ->limit(3)
            ->get();
        
        return view('index', [
            'meilleurs_jeux' => $meilleurs_jeux
        ]);
    }
}
