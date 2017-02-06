<?php
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function(){
//    return view('index');
//});
//Route::get('/{parameters}', function(){
//    if(Auth::user()->groupe == null ) // use Auth::check instead of Auth::user
//        {
//            return "fb";
//    //        Route::get('/', 'PagesController@logged_in_index');
//        }
//})->where('parameters', '.*');


Route::get('/', 'HomeController@getGames');

//Route::group(['prefix' => '/'], function()
//{
//    if(Auth::check()){
//        if(Auth::user()->groupe == null ) // use Auth::check instead of Auth::user
//        {
//            return "fb";
//    //        Route::get('/', 'PagesController@logged_in_index');
//        } else{
//            return "pas fb";
//        }
//    }
//});

//Route::get('/', function(){
//    if(Auth::check()){
//        if(Auth::user()->classe == null || Auth::user()->groupe == null){
//            echo "<h1>Connecté via <span style='color: #3b5998'>Facebook</span></h1>";
//            echo "<h3>Certaines infos doivent être complétées pour poursuivre la navigation</h3>
//            <p style='color: red'><strong>Informations obligatoires :</strong></p>
//            ";
//
//            echo Form::open(array('url' => 'infos-incomplete', 'method' => 'PUT')); 
//
//            echo "<p>Vous êtes :</p>";
//            echo Form::select('Groupe', 
//            array(
//                '1' => 'Un élève',
//                '2' => 'Un parent', 
//                '3' => 'Un enseignant')
//            ); 
//
//            echo "<p>En quelle <strong>classe</strong> êtes-vous ?</p>";
//            echo Form::select('Classe', 
//            array(
//                '1' => 'CP',
//                '2' => 'CE1', 
//                '3' => 'CE2', 
//                '4' => 'CM1',
//                '5' => 'CM2')
//            );      
//
//            echo Form::submit('Envoyer !');
//            echo Form::close(); 
//
//        }
//        else{
//            return view('index');
//        }
//    }
//    else{
//        return view('index');
//    }
//
//});

Route::get('infos-incomplete', 'InfosIncompleteController@getForm');
Route::post('infos-incomplete', 'InfosIncompleteController@postInfos');

Route::get('article/{n}', 'ArticleController@show')->where('n', '[0-9]+');

// Inscription
//Route::get('inscription', 'InscriptionController@getInfos');
//
//Route::post('inscription', 'InscriptionController@postInfos');

// Connexion
Route::get('inscription', function(){
    if(Auth::check()){
        return redirect()->back()
            ->with('message', 'Vous êtes déjà connecté');
    } 
    else{
        return View::make('auth/register');
    }
});

Route::post('inscription', 'Auth\AuthController@postRegister');

Route::get('connexion', function()
{
    if(Auth::check()) {
        return redirect()->back()
            ->with('message', 'Vous êtes déjà connecté');
    } 
    else
    {
        return View::make('auth/login');
    }
});

Route::get('deconnexion', function(){
    if(Auth::check()){
        Auth::logout();
        //echo "vous êtes maintenant déconnecté";
        return redirect('/')
            ->with('message', 'Vous êtes maintenant déconnecté');
    }
    else{
        return redirect('/')
            ->with('message', "Vous n'êtes pas connecté");
    }
});

Route::post('connexion', function()
{
    $nom = Input::get('pseudo');
    $passe = Input::get('password');
 
    if(Auth::attempt(array('pseudo' => $nom, 'password' => $passe)))
        return Redirect::back();
    else
        return Redirect::to(URL::previous() . "#connexion")
            ->with('messageErreurPopup', 'Erreurs d\'identifiant');
        /*redirect()->back()
            ->with('messageErreurPopup', 'Erreurs d\'identifiant');*/
});


Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');


Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
//Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail'); Désactivé envoi de mail est bloqué

Route::get('compte', function(){
    if(Auth::guest())
        return redirect('connexion');  
    else
        return View::make('compte');
});

Route::post('compte', 'ProfilController@updateInfos');

Route::post('comptemdp', 'ProfilController@updatePassword');
Route::post('compteinfo', 'ProfilController@updateName');

Route::get('create-compte-enfant', function(){
    if(Auth::guest())
        return redirect('connexion');  
    else
        return View::make('create-compte-enfant');
});

Route::post('create-compte-enfant', 'ProfilController@insertKid');

Route::get('create-classe', function(){
     if(Auth::guest())
        return redirect('connexion');  
    else
        return View::make('create-classe');
});

Route::post('create-classe', 'ProfilController@insertClasse');

Route::get('profil/{id}', 'ProfilController@getInfosProfil');
Route::get('classe/{id}', 'ClasseController@getInfos');

Route::get('classe/delete/{id_membre}', 'ClasseController@deleteKid');
Route::get('classe/delete-classe/{id_classe}', 'ClasseController@deleteClasse');

Route::get('programme/{classe}', 'NiveauController@getContent');

Route::get('programme/{classe}/{matiere}', 'NiveauController@getMatiere');

Route::get('programme/{classe}/{matiere}/{game}', 'JeuController@getJeu');
Route::post('programme/{classe}/{matiere}/{game}', 'JeuController@addNote');
Route::post('programme/{classe}/{matiere}/{game}/comment', 'JeuController@addComment');


Route::get('vous-etes-professeur', function(){
    return View::make('vous-etes-professeur');
});
    
Route::get('vous-etes-parent', function(){
    return view('vous-etes-parent');
});

Route::get('vous-etes-eleve', function(){
    return view('vous-etes-eleve');
});

Route::get('contact', function(){
    return view('contact'); 
});
Route::get('mentions-legales', function(){
    return view('mentions-legales'); 
});

Route::get('qui-sommes-nous', function(){
    return view('qui-sommes-nous');
});

Route::get('classement', 'ClassementController@getScore');
Route::get('boutique', 'BoutiqueController@getVente');
Route::post('boutique', 'BoutiqueController@doAchat');

Route::get('bomberman', 'BombermanController@getGame');
Route::get('achat-partie', 'BombermanController@achatPartie');
Route::post('achat-partie', 'BombermanController@validationAchat');


