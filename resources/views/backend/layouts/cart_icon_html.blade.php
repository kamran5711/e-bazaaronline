@if(session('cart'))
<li class="nav-item dropdown no-arrow mx-1">
  <a class="nav-link dropdown-toggle" href="{{route('shopOrder')}}"  data-toggle="tooltip" data-placement="bottom" title="cart"  role="button">
    <i class="fas fa-shopping-cart"></i>
    <sup>{{ count(session('cart') ?: []) }} Items</sup>
  </a>
</li>
@endif
