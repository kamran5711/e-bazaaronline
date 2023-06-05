<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Traits\SendResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\StatusNotification;
use App\SendOtp;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use SendResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @rturn \Illuminate\Http\Response
     */

    public function userSignUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'full_name' => 'required',
        ]);
        // return $validator->errors()->all();
        if ($validator->fails()) {
            $errors = $validator->errors()->first('full_name')."".$validator->errors()->first('email').''.$validator->errors()->first('username')."".$validator->errors()->first('password').$validator->errors()->first('confirm_password');
            return $this->SendResponse(false,$errors, []);
        }
        // register user
        $user = new User();
        $user->email = $request->email;
        $user->username = $request->username;
        $user->name =  $request->full_name ? $request->full_name : "user".random_int(100000, 999999);
        $user->status = 'active';
        $user->password = bcrypt($request->password);
        $user->city     = $request->city;
        $user->postcode = $request->post_code;
        $user->area     = $request->area;
        $user->address1  = $request->address1;
        $user->address2  = $request->address2;
        $user->building  = $request->building_number;
        $user->role = 'user';
        $user->save();
        Auth::loginUsingId($user->id);
        $user = User::find($user->id);
        $token = $user->createToken('ebazaar')->plainTextToken;

        return $this->SendResponse(true,'user registered', ['token' => $token,'user' => $user]);

    }

    public function update_profile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'full_name'=>'required',
                'email'=>'required|unique:users,email,'.auth('sanctum')->user()->id,
                'username'=>'required|unique:users,username,'.auth('sanctum')->user()->id,
                // 'building'=>'required',
                'address1'=>'string|required',
                'address2'=>'string|nullable',
                'area'=>'required',
                'city'=>'required',
                // 'postcode'=>'required',
                // 'phone' => 'required|digits:11',
                // 'delivery_date'=>'required',
                'order_notes'=>'string|nullable'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errors = implode('\n', $errors);
                return $this->SendResponse(false,$errors, []);
            }
            $user = User::find(auth('sanctum')->user()->id);
            $user->name = $request->full_name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->building = $request->building;
            $user->address1 = $request->address1;
            $user->address2 = $request->address2;
            $user->area = $request->area;
            $user->city = $request->city;
            $user->postcode = $request->postcode;
            $user->phone = $request->phone;
            $user->save();
            return $this->SendResponse(true,'profile updated', ['user' => $user]);
        } catch (\Exception $e) {
            return $this->SendResponse(false,$e->getMessage(), []);
        }
    }

    public function check_user_email_username(Request $request)
    {
        try{
           $res['email_error'] = false;
           $res['username_error'] = false;
           $check_email = User::where('email',$request->email);
            if($check_email->count() > 0){
                $res['email_error'] = true;
              }
           $check_username = User::where('username',$request->username);
            if($check_username->count() > 0){
                $res['username_error'] = true;
              }
            return $this->SendResponse(true, 'success', $res);

        } catch(\Exception $e){
            return $this->SendResponse(false,$e->getMessage(), []);
        }
    }

    public function userSignIn(request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->first('email').''.$validator->errors()->first('username').$validator->errors()->first('password');
            return $this->SendResponse(false,$errors, []);
        }
     
        $user = User::where('username', $request->username)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) { 
            return $this->SendResponse(false,'The User name or password is incoreect', []);
        }
        $token = $user->createToken('ebazaar')->plainTextToken;
        $user->token = $token;
        
        return $this->SendResponse(true,'user registered', ['token' => $token,'user' => $user]);

    }

    public function userForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->first('email');
            return $this->SendResponse(false,$errors, []);
        }
        $user = User::where('email', $request->email)->first();
        if (! $user) { 
            return $this->SendResponse(false,'The email is incorrect', []);
        }
        $to_mail        =$request->input('email');
        Mail::send('email.forget_password',['user'=>$user], function ($message) use ($to_mail ,$user) {
          $message->to($to_mail);
           $message->subject('Registration');
         });

    }

    public function forgot_password_sendmail(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->first('email');
                return $this->SendResponse(false,$errors, []);
            }
            $user = User::where('email', $request->email)->first();
            if (! $user) { 
                return $this->SendResponse(false,'The email is incorrect', []);
            }
            $to_mail=$request->input('email');
            // $otp = random_int(1000, 9999);
            $otp = 1234;
            SendOtp::create([
                'email'=>   $to_mail,
                'otp'=> $otp,
                'is_verified'=> 0,
            ]);
            Mail::send('email.forget_password',['otp'=>$otp], function ($message) use ($to_mail) {
              $message->to($to_mail);
               $message->subject('Reset Password OTP');
             });

            return $this->SendResponse(true,'An email is sent to '.$to_mail, []);
        } catch(\Exception $e){
            return $this->SendResponse(false,$e->getMessage(), []);
        }
    }

    public function forgot_password_verify_otp(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'otp' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->first('otp');
                return $this->SendResponse(false,$errors, []);
            }
            $otp = SendOtp::where('otp', $request->otp)->where('email',$request->email)->where('is_verified',0)->first();
            if (! $otp) { 
                return $this->SendResponse(false,'The OTP is incorrect', []);
            }
            if($otp->is_verified == 1){
                return $this->SendResponse(false,'The OTP is already used', []);
            }
            $otp->is_verified = 1;
            $otp->save();
            return $this->SendResponse(true,'OTP is verified', ['email'=> $request->email ]);
        } catch(\Exception $e){
            return $this->SendResponse(false,$e->getMessage(), []);
        }
    }

    public function forgot_password_reset(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->first('email').''.$validator->errors()->first('new_password').''.$validator->errors()->first('confirm_password');
          
                return $this->SendResponse(false,$errors, []);
            }
            $user = User::where('email', $request->email)->first();
            if (! $user) { 
                return $this->SendResponse(false,'The email is incorrect', []);
            }
            $user->password = bcrypt($request->password);
            $user->save();
            return $this->SendResponse(true,'Password reset successfully', []);
        } catch(\Exception $e){
            return $this->SendResponse(false,$e->getMessage(), []);
        }
    }
}
