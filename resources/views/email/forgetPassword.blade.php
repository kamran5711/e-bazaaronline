<h1>Forget Password Email</h1>
   
You can reset password from bellow link:
<a href="{{ route('reset.password.get', $token) }}?k={{Crypt::encrypt($user->store_id)}}">Reset Password</a>