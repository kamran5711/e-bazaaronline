@php
$store_id = (request()->has('k')) ? Crypt::decrypt(request()->get('k') ) : 0;
$store = DB::table('stores')->where('id',$store_id)->first();
// dd($settings);
@endphp 
<!DOCTYPE html>
<html lang="zxx">
<head>
	<!-- Title Tag  -->
	<title> @yield('page-title') {{ ! is_null($store) ? strip_tags($store->name) :''}} </title>

	@include('frontend.layouts.head')	

</head>
<body class="js">
	
	<!-- Preloader -->
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	<!-- End Preloader -->	
	@include('frontend.layouts.notification')
	@include('frontend.layouts.header-customer')
	@yield('main-content')
	@include('frontend.layouts.footer-customer')
	<!--/ End Header -->
	
 <script src='https://www.google.com/recaptcha/api.js'></script>
  <script>

function get_action(form) 
{
    var v = grecaptcha.getResponse();
    if(v.length == 0)
    {
        document.getElementById('captcha').innerHTML="You can't leave Captcha Code empty";
        return false;
    }
    else
    {
         document.getElementById('captcha').innerHTML="Captcha completed";
        return true; 
    }
}
</script>
</body>
</html>