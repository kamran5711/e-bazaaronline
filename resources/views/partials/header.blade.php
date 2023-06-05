<div class="{{ request()->is('/', 'products', 'search') ? 'nav-menu bg transition' : 'dark-bg sticky-top'}}">
    <div class="container-fluid @if(request()->is('/', 'products', 'search')) fixed @endif" style="background:#510A32;">
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    
                    
      <a class="navbar-brand" href="{{ url('/') }}" ><img  class="logo" alt="Ebazar" src="{{asset('images/logo.png')}}" width="250" height="60"></a>


                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="true" aria-label="Toggle navigation">
                        <span class="icon-menu"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown" style="height: 30px;">
                        
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/about-us') }}">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/terms-and-conditions') }}">Terms and Conditions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/privacy-policy') }}">Privacy Policy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/faqs') }}">FAQS</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/track-orders') }}">Track Order</a>
                            </li>
                            @if(auth()->check())
                                @switch(auth()->user()->role_id)
                                    @case(1)
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('superadmin/')}}"> Dashboard</a>
                                        </li>
                                        @break
                        
                                    @case(2)
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('admin/')}}"> Dashboard</a>
                                        </li>
                                        @break
                        
                                    @default
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('customer/')}}"> Dashboard</a>
                                        </li>
                                @endswitch                              
                                <li class="nav-item">
                                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                </li>
                                <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('store.register') }}">Register</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>