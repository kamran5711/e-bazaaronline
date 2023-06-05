<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <title>Ebazaar </title>
    <link rel="stylesheet" href="{{asset('mainCSS/dashlite.css?ver=1.4.0')}}">
    <link id="skin-default" rel="stylesheet" href="{{asset('mainCSS/theme.css?ver=1.4.0')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <style type="text/css">
        .nk-footer{  margin-top: auto !important;
    background: #fff !important;
    border-top: 1px solid #e5e9f2 !important;
    padding: 20px 6px !important;}
    </style>
</head>
<body class="nk-body npc-subscription has-aside ui-clean ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap ">
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-header-brand">
                                <a href="{{url('/')}}" class="logo-link">
                                  <img class="logo" alt="Ebazar" src="{{asset('images/logo.png')}}">
                                </a>
                            </div><!-- .nk-header-brand -->
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-name dropdown-indicator d-none d-sm-block">{{ auth('superadmin')->user()?->username}}</div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="lead-text">{{ auth('superadmin')->user()?->username }}</span>
                                                        <span class="sub-text">{{ auth('superadmin')->user()?->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="{{url('superadmin/profile')}}"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                                </ul>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                             {{ csrf_field() }}
                                            </form>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-lg-none">
                                        <a href="#" class="toggle nk-quick-nav-icon mr-n1" data-target="sideNav"><em class="icon ni ni-menu"></em></a>
                                    </li>
                                </ul><!-- .nk-quick-nav -->
                            </div><!-- .nk-header-tools -->
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <div class="nk-content ">
                    <div class="container wide-xl">
                        <div class="nk-content-inner">
                            <div class="nk-aside" data-content="sideNav" data-toggle-overlay="true" data-toggle-screen="lg" data-toggle-body="true">
                                <div class="nk-sidebar-menu" data-simplebar>
                                    <ul class="nk-menu">
                                        <li class="nk-menu-heading">
                                            <h6 class="overline-title">Menu</h6>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('superadmin.dashboard')}}" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                                                <span class="nk-menu-text">Dashboard</span>
                                            </a>
                                        </li>
                                         <li class="nk-menu-item">
                                            <a 
                                            {{-- href="{{route('superadmin.stores')}}" --}}
                                             class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                                <span class="nk-menu-text">Business </span>
                                            </a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{url('superadmin/invoices/list?status=unpaid')}}" class="nk-menu-link">
                                                <span class="nk-menu-icon">
                                                    <em class="icon ni ni-tranx"></em></span><span class="nk-menu-text">Unpaid invoices
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div><!-- .nk-sidebar-menu -->
                                <div class="nk-aside-close">
                                    <a href="#" class="toggle" data-target="sideNav"><em class="icon ni ni-cross"></em></a>
                                </div><!-- .nk-aside-close -->
                            </div><!-- .nk-aside -->
                             <div class="nk-content-body">
                             @yield('content')
                            </div>
                        </div>
                          <!-- footer @s -->
                            <div class="nk-footer">
                                <div class="container wide-xl">
                                    <div class="nk-footer-wrap g-2">
                                        <div class="nk-footer-copyright"> &copy; {{date('Y')}} Ebazar.  
                                        </div>
                                        <div class="nk-footer-links"><ul class="nav nav-sm">
                                             <li class="nav-item"><a class="nav-link" href="{{url('terms_and_condition')}}">Terms &amp; Condition</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{url('privacy_policy')}}">Privacy Policy</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{url('about_us')}}">About Us</a></li>
                             </ul>
                                </div>
                                 </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<!------ <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
---------->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<!------ Include the above in your HEAD tag ---------->

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

  <script>
    $(document).ready(function() {
    $('#example').DataTable(
        
         {     
"responsive": true,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "iDisplayLength": 5
       } 
        );
} );


function checkAll(bx) {
  var cbs = document.getElementsByTagName('input');
  for(var i=0; i < cbs.length; i++) {
    if(cbs[i].type == 'checkbox') {
      cbs[i].checked = bx.checked;
    }
  }
}
</script>
</body>
</html>

 
