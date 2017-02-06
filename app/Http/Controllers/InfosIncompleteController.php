<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Hash;
use Auth;

class InfosIncompleteController extends Controller
{
    public function getForm()
    {
        if(Auth::guest())
            return redirect('connexion');  
        else
            
            return view('infos-incomplete');
	}
    
    public function postInfos(Request $request)
    {
        $userId = Auth::id();
        
        $this->validate($request, [
            'groupe' => 'required',
            'nom' => 'required|max:30',
            'prenom' => 'required|max:20',
        ]);
        
        $nom_ok = htmlspecialchars(addslashes($request['nom']));
        $prenom_ok = htmlspecialchars(addslashes($request['prenom']));
            
        DB::table('mpc_user')
            ->where('id', $userId)
            ->update([
                'nom' => $nom_ok,
                'prenom' => $prenom_ok,
                'groupe' => $request['groupe']
            ]);
        
        $textemessage = "Informations enregistrées. Redirection en cours...";
        $lienredirect = "/compte";
                     
        return view('redirect', [
            'message' => $textemessage,
            'lienredirect' => $lienredirect
        ]);
    }
}

