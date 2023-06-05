<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Ebazar">
    <meta name="keywords" content="Ebazar , Online Shopping in Pakistan: Fashion, Electronic, Home Appliances - eBazar Pakistan">
    <meta name="description" content="Ebazar , Pakistan&#39;s best online shopping store with 15+ million products at resounding discounts in Karachi ✓ Lahore ✓ Islamabad ✓ All across Pakistan with cash on delivery (COD). Pick your favorite Mobiles, Appliances, Apparels, and Fashion accessories on amazing deals exclusively available at e-bazaaronline.com.">
  
  
    <link rel="icon" type="image/png" href="https://www.ebazarpk.com/wp-content/uploads/2021/04/cropped-eBazar-Logo-01-e1617471042831-1.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="site_name" content="Online Shopping in Pakistan: Fashion, Electronic, Home Appliances - eBazar Pakistan">
    <title>Ebazaar | Online Shopping Experience</title>
    <link rel="stylesheet" href="{{ asset('mainCSS/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('mainCSS/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('mainCSS/set1.css') }}">
    <link rel="stylesheet" href="{{ asset('mainCSS/style2.css') }}">
    
    @yield('styles')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Y9TPHYEERH"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-Y9TPHYEERH');
    </script>
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TQ4JSXW');</script>
    <!-- End Google Tag Manager -->



</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TQ4JSXW"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    <script src="{{ asset('mainJS/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('mainJS/popper.min.js') }}"></script>
    <script src="{{ asset('mainJS/bootstrap.min.js') }}"></script>

    <script>
        $(window).scroll(function() {
            // 100 = The point you would like to fade the nav in.

            if ($(window).scrollTop() > 100) {

                $('.fixed').addClass('is-sticky');

            } else {

                $('.fixed').removeClass('is-sticky');

            };
        });
    </script>
    @yield('scripts')

    <script>
        jQuery.noConflict();
    </script>
</body>

</html>
