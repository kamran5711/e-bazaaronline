<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use App\User;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
        protected function redirectTo(){

            $user = Auth::user();
            // dd($user);
            switch ($user->role_id) {
                case 1:
                    return '/superadmin';
                    break;
                case 2:
                    return '/admin';
                    break;
                case 3:
                    return '/customer';
                    break;
                default:
                    return '/admin';
                    break;
            }

            // if($user->role == 'admin' || $user->role == 'operator'){
            //     return 'admin';
            // }else{
            //     return 'customer?k='.\Illuminate\Support\Facades\Crypt::encrypt($user->store_id);
            // }

        }
    // protected $redirectTo = ('/');
// protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

  function reCaptcha($recaptcha){
  $secret = "6Lfj_CQeAAAAAPnvt2gDUQAtGlmcGIyNdHhjHwO1";
  $ip = $_SERVER['REMOTE_ADDR'];

  $postvars = array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
  $url = "https://www.google.com/recaptcha/api/siteverify";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
  $data = curl_exec($ch);
  curl_close($ch);

  return json_decode($data, true);
}


    public function credentials(Request $request){

        //   $recaptcha = $request['g-recaptcha-response'];
        // $res = $this->reCaptcha($recaptcha);
        
        // if(!$res['success']){
            
        //        return back()->with('error', 'Please check the recaptcha');
        //        exit;
        //   // Error
        // }
        return ['email'=>$request->email,'password'=>$request->password,'status'=>'active','role'=>['admin','bussiness','user']];
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirect($provider)
    {
        // dd($provider);
     return Socialite::driver($provider)->redirect();
    }
 
    public function Callback($provider)
    {
        $userSocial =   Socialite::driver($provider)->stateless()->user();
        $users      =   User::where(['email' => $userSocial->getEmail()])->first();
        // dd($users);
        if($users){
            Auth::login($users);
            return redirect('/')->with('success','You are login from '.$provider);
        }else{
            $user = User::create([
                'name'          => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'image'         => $userSocial->getAvatar(),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
            ]);
         return redirect()->route('home');
        }
    }
}
