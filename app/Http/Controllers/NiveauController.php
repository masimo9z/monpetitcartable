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


class NiveauController extends Controller
{  
    public function getContent($classe){
        $objectMatieres = array(
            0 => array(
                'href' => 'mathematiques',
                'name' => 'mathématiques',
                'Name' => 'Mathématiques'
            ),
            1 => array(
                'href' => 'francais',
                'name' => 'Français',
                'Name' => 'Français'
            ),
            2 => array(
                'href' => 'geographie',
                'name' => 'Géographie',
                'Name' => 'Géographie'
            )
        );
        $objectNiveaux = array(
            0 => array(
                'name' => 'cp',
                'Name' => 'CP'
            ),
            1 => array(
                'name' => 'ce1',
                'Name' => 'CE1'
            ),
            2 => array(
                'name' => 'ce2',
                'Name' => 'CE2'
            ),
            3 => array(
                'name' => 'cm1',
                'Name' => 'CM1'
            ),
            4 => array(
                'name' => 'cm2',
                'Name' => 'CM2'
            )
        );
        
        if($classe == "cp" || $classe == "ce1" || $classe == "ce2" || $classe == "cm1" || $classe == "cm2")
            return view('niveau/niveau', ['classe' => $classe, 'objectMatieres' => $objectMatieres, 'objectNiveaux' => $objectNiveaux]);
    }
    
    public function getMatiere($classe, $matiere){
        
        $lesmatieres = ['mathématiques','français','géographie'];
        $objectMatieres = array(
            0 => array(
                'href' => 'mathematiques',
                'name' => 'mathématiques',
                'Name' => 'Mathématiques'
            ),
            1 => array(
                'href' => 'francais',
                'name' => 'Français',
                'Name' => 'Français'
            ),
            2 => array(
                'href' => 'geographie',
                'name' => 'Géographie',
                'Name' => 'Géographie'
            )
        );
        $objectNiveaux = array(
            0 => array(
                'name' => 'cp',
                'Name' => 'CP'
            ),
            1 => array(
                'name' => 'ce1',
                'Name' => 'CE1'
            ),
            2 => array(
                'name' => 'ce2',
                'Name' => 'CE2'
            ),
            3 => array(
                'name' => 'cm1',
                'Name' => 'CM1'
            ),
            4 => array(
                'name' => 'cm2',
                'Name' => 'CM2'
            )
        );
        
        $niveaux = ['cp','ce1','ce2','cm1','cm2'];
        
        
        $games = DB::table('mpc_jeu')
            ->where('matiere', $matiere)
            ->get();
        
        if($classe == "cp" || $classe == "ce1" || $classe == "ce2" || $classe == "cm1" || $classe == "cm2")
            if($matiere == "mathematiques" || $matiere == "francais" || $matiere == "geographie")
                
                return view('matiere/matiere', ['matiere' => $matiere, 'lesmatieres' => $lesmatieres,'objectMatieres' => $objectMatieres, 'objectNiveaux' => $objectNiveaux, 'classe' => $classe, 'niveaux' => $niveaux, 'games' => $games]);
    }
}
