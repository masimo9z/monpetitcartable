<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;

use Auth;
use Socialite;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
        
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
 
    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect('auth/facebook');
        }
 
        $authUser = $this->findOrCreateUser($user);
 
        Auth::login($authUser, true);
 
        return redirect('/');
    }
 

//        @param $facebookUser
//        @return User
         
    private function findOrCreateUser($facebookUser)
    {
        $authUser = User::where('email', '=', $facebookUser->email)->first();
 
        if(!$authUser){
            return User::create([
                'pseudo' => $facebookUser->name,
                'rang' => '1',
                'email' => $facebookUser->email,
                'id_facebook' =>$facebookUser->id,
                'avatar' => '1',
                'id_classe' => '1',
                'vie' => '3',
                'ip' => $_SERVER['REMOTE_ADDR'],
            ]);
        }
        return $authUser;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        
        function TestCaptcha($code, $ip = null)
        {
            if(empty($code)){
                return false; // On vérifie si y'a déjà une entrée
            }
      
            $params = [
                'secret'    => '6LcxpggUAAAAAOOzKaAVr3D-EsQCC4nfh_MQVbFi',
                'response'  => $code
            ];
    
            if($ip){
                $params['remoteip'] = $ip;
            }
    
            $url = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
            if (function_exists('curl_version')) {
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_TIMEOUT, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
                $response = curl_exec($curl);
            } 
            else 
            {
                $response = file_get_contents($url);
            }
            
            if (empty($response) || is_null($response)) {
                return false;
            }

            $json = json_decode($response);
            return $json->success;
        }
        
        $captcha = TestCaptcha($_POST['g-recaptcha-response']);
            
        return Validator::make($data, [
            'nom' => 'required|max:255',
            'prenom' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:mpc_user',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'groupe' => 'required',
            'g-recaptcha-response' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'id' => '',
            'id_facebook' => '',
            'pseudo' => $data['name'],
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'rang' => '1',
            'groupe' => $data['groupe'],
            'classe' => '0',
            'id_classe' => '0',
            'avatar' => '1',
            'vie' => '3',
            'date_naissance' => '',
            'ip' => $_SERVER['REMOTE_ADDR'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'sexe' => '0',
            'date_inscription' => date("Y-m-d H:i:s"),
            'remember_token' => '',
        ]);   
    }
}
