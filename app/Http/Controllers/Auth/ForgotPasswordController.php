<?php
namespace App\Http\Controllers\Auth; 
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\User; 
use Mail; 
use Hash;
use Illuminate\Support\Str;
use Throwable;

class ForgotPasswordController extends Controller
{
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return view('auth.forgetPassword');
      }
   
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
        //  dd($request->all());
          $request->validate([
              'email' => 'required|email|exists:users',
          ]);
  
          $token = Str::random(64);
            $user = User::where('email', $request->email);
            if($user->first()):
                DB::table('password_resets')->insert([
                    'email' => $request->email, 
                    'token' => $token, 
                    'created_at' => Carbon::now()
                  ]);
          //    $data['email']=$request->email;
          //    $$data=$request->token;
            $user = $user->first();
                  try{
                      Mail::send('email.forgetPassword', ['token' => $token,'user' => $user], function($message) use($request){
                          $message->to($request->email);
                          $message->subject('Reset Password');
                      });
                  }catch(\Throwable $th){
                      return back()->with('message', 'Something went wrong!');
                  }
            endif;
    
         
  
          return back()->with('message', 'We have e-mailed your password reset link!');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 
         return view('auth.forgetPasswordLink', ['token' => $token]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          //dd( $request->all());
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
 // dd( $updatePassword);
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
          return redirect()->route('login')->with('message', 'Your password has been changed!');
      }
}