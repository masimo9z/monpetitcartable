<?php

// Ces fonctions tansposent les id des groupes en mots
function userId()
{
    return Auth::id();
}

function myGroup(){
    if(Auth::user()->groupe == 1)
        return "Elève";
    
    else if(Auth::user()->groupe == 2)
        return "Enseignant";
    
    else if(Auth::user()->groupe == 3){
        return "Parent";
    }
    
    else
        return "Administrateur";
}

function myClass(){
    if(Auth::user()->classe == 1)
        return "CP";
    
    else if(Auth::user()->classe == 2)
        return "CE1";
    
    else if(Auth::user()->classe == 3)
        return "CE2";
    
    else if(Auth::user()->classe == 4)
        return "CM1";
    
    else if(Auth::user()->classe == 5)
        return "CM2";
    
    else
        return "Pas de classe";
}

function myFamily(){
    $family_exist = DB::table('mpc_family')
        ->select('*', DB::raw('COUNT(*)'))
        ->where('id_parent', userId())
        ->count();
    
    if($family_exist < 1)
        return "<a href='/projets/dweb02/laravel/monpetitcartable/public/create-compte-enfant'>Créer un compte enfant</a>";
    else
    {
        $family_infos = DB::table('mpc_family')
            ->leftJoin('mpc_user', 'mpc_family.id_enfant', '=', 'mpc_user.id')
            ->where('id_parent', userId())
            ->get();
        
        
        foreach($family_infos as $family_info){
            echo "<a href='/projets/dweb02/laravel/monpetitcartable/public/profil/".$family_info->id_enfant."'>".$family_info->prenom."</a>";
        }
    }
}

function niveauClasse(){
    $userId = Auth::id();
    
//    $nbr_classe = DB::table('mpc_classe')
//        ->
    $niveaux = DB::table('mpc_classe')
        ->where('id_enseignant', $userId)
        ->get();
    
    foreach($niveaux as $niveau){
        if($niveau->niveau == 1)
            echo "CP";
    
        if($niveau->niveau == 2)
            echo "CE1";
    
        if($niveau->niveau == 3)
            echo "CE2";
    
        if($niveau->niveau == 4)
            echo "CM1";
    
        if($niveau->niveau == 5)
            echo "CM2";
    }
}
    
function mySchool(){
    $userId = Auth::id();
    $school_exist = DB::table('mpc_classe')
        ->where('id_enseignant', $userId)
        ->count();
    
    if($school_exist > 0){
        $school_infos = DB::table('mpc_classe')
            ->where('id_enseignant', $userId)
            ->get();
        
        foreach($school_infos as $school_info){
            if($school_info->niveau == 1)
                $niveau = "CP";
    
            if($school_info->niveau == 2)
                $niveau = "CE1";
    
            if($school_info->niveau == 3)
                $niveau = "CE2";
    
            if($school_info->niveau == 4)
                $niveau = "CM1";
    
            if($school_info->niveau == 5)
                $niveau = "CM2";
            
            echo "<a href='/projets/dweb02/laravel/monpetitcartable/public/classe/".$school_info->id."'>".$niveau."</a>";
        }
    }
    else
        return "<a href='/projets/dweb02/laravel/monpetitcartable/public/create-classe'>Créez une nouvelle classe</a>";
}

function createPassword(){
    $random_password = "";
    
    $nb_caractere = 8;
    $chaine = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ023456789+@!$%?&";
    $longeur_chaine = strlen($chaine);
       
    for($i = 1; $i <= $nb_caractere; $i++){
        $place_aleatoire = mt_rand(0,($longeur_chaine-1));
        $random_password .= $chaine[$place_aleatoire];
    }
    
    return $random_password;   
}

function rewriteNiveau(){
    $url = $_SERVER['REQUEST_URI'];
    $urlexplode = explode("/", $url);
    $counturlexplode = count($urlexplode);
    $classe = $urlexplode[$counturlexplode - 1];

    if ($classe == 'cp')
        return 'CP';
    elseif ($classe == 'ce1')
         return 'CE1';
    elseif ($classe == 'ce2')
         return 'CE2';
    elseif ($classe == 'cm1')
         return 'CM1';
    elseif ($classe == 'cm2')
         return 'CM2';
}

function rewriteClasse(){
    $url = $_SERVER['REQUEST_URI'];
    $urlexplode = explode("/", $url);
    $counturlexplode = count($urlexplode);
    $classe = $urlexplode[$counturlexplode - 2];

    if ($classe == 'cp')
        return 'CP';
    elseif ($classe == 'ce1')
         return 'CE1';
    elseif ($classe == 'ce2')
         return 'CE2';
    elseif ($classe == 'cm1')
         return 'CM1';
    elseif ($classe == 'cm2')
         return 'CM2';
}

function rewriteMatiere(){
    $url = $_SERVER['REQUEST_URI'];
    preg_match("/[^\/]+$/", "http://".$url, $matches);
    $matiere = $matches[0];
    
    if ($matiere == 'mathematiques')
        return 'Mathématiques';
    elseif ($matiere == 'francais')
         return 'Français';
    elseif ($matiere == 'geographie')
         return 'Géographie';
}

function rankObjectMatiere(){
    $url = $_SERVER['REQUEST_URI'];
    preg_match("/[^\/]+$/", "http://".$url, $matches);
    $matiere = $matches[0];
    
    if ($matiere == 'mathematiques')
        return '0';
    elseif ($matiere == 'francais')
         return '1';
    elseif ($matiere == 'geographie')
         return '2';
}
function rankObjectClasse(){
    $url = $_SERVER['REQUEST_URI'];
    $urlexplode = explode("/", $url);
    $counturlexplode = count($urlexplode);
    $classe = $urlexplode[$counturlexplode - 2];

    if ($classe == 'cp')
        return '0';
    elseif ($classe == 'ce1')
         return '1';
    elseif ($classe == 'ce2')
         return '2';
    elseif ($classe == 'cm1')
         return '3';
    elseif ($classe == 'cm2')
         return '4';
}

function rankObjectNiveau(){
    $url = $_SERVER['REQUEST_URI'];
    $urlexplode = explode("/", $url);
    $counturlexplode = count($urlexplode);
    $classe = $urlexplode[$counturlexplode - 1];

    if ($classe == 'cp')
        return '0';
    elseif ($classe == 'ce1')
         return '1';
    elseif ($classe == 'ce2')
         return '2';
    elseif ($classe == 'cm1')
         return '3';
    elseif ($classe == 'cm2')
         return '4';
}

function genereMoyenne(){
    $allgames = DB::table('mpc_jeu')->get();
    
    foreach($allgames as $allgame){
        
        $existmoyenne = DB::table('mpc_moyenneJeu')
            ->where('id_jeu', $allgame->id)
            ->count();
        
        if($existmoyenne == 0){
            DB::table('mpc_moyenneJeu')->insert([
                'id' => '',
                'id_jeu' => $allgame->id,
                'moyenne' => '0',
            ]);
        } 
        
    }
}
?>