{{-- here is navigation for super admin role --}}
@if(Auth::user()->role_id == 1)
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('superadmin.dashboard')}}">
      <div class="sidebar-brand-icon rotate-n-15">
        {{-- <i class="fas fa-laugh-wink"></i> --}}
      </div>
      <div class="sidebar-brand-text mx-3">Dashboard</div>
    </a>

    <li class="nav-item">
      <a class="nav-link" href="{{URL('/')}}">
        <i class="fas fa-fw fa-home"></i>
        <span>Website</span></a>
    </li>

    <!-- stores or Bussiness -->
    <li class="nav-item {{ ( Route::currentRouteName() === 'get_store_list' || Route::currentRouteName() === 'pending_for_approval' ? 'active' : '')}}">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#stores_bussiness" aria-expanded="true" aria-controls="stores_bussiness">
        <i class="fas fa-store"></i>
        <span>Stores | Bussiness</span>
      </a>
      <div id="stores_bussiness" class="collapse {{ Route::currentRouteName() === 'pending_for_approval' || Route::currentRouteName() === 'get_store_list' ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item {{ (Route::currentRouteName() === 'pending_for_approval' ? 'active' : '')}}" href="{{route('pending_for_approval')}}">Pending</a>
          <a class="collapse-item {{ Route::currentRouteName() === 'get_store_list' ? 'active' : '' }}" href="{{route('get_store_list')}}">All</a>
        </div>
      </div>
    </li>

    <!-- membership -->
    <li class="nav-item {{ (Route::currentRouteName() === 'expired-memberships') || (Route::currentRouteName() === 'all-membership') ? 'active' : ''}}">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#membership" aria-expanded="true" aria-controls="membership">
        {{-- <i class="fas fa-cog"></i> --}}
        <i class="fas fa-handshake"></i>
        <span>Memberships</span>
      </a>
      <div id="membership" class="collapse {{ (Route::currentRouteName() === 'expired-memberships') || (Route::currentRouteName() === 'all-memberships') ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item {{ (Route::currentRouteName() === 'expired-memberships') ? 'active' : ''}}" href="{{route('expired-memberships')}}">Expired</a>
          <a class="collapse-item {{ (Route::currentRouteName() === 'all-memberships') ? 'active' : ''}}" href="{{route('all-memberships')}}">All</a>
        </div>
      </div>
    </li>
    
        <!-- invoices -->
    <li class="nav-item {{ (Route::currentRouteName() === 'pending-invoices') || (Route::currentRouteName() === 'all-invoices') ? 'active' : ''}}">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#invoices" aria-expanded="true" aria-controls="invoices">
        {{-- <i class="fas fa-cog"></i> --}}
        <i class="fas fa-file-invoice"></i>
        <span>Invoices</span>
      </a>
      <div id="invoices" class="collapse {{ (Route::currentRouteName() === 'pending-invoices') || (Route::currentRouteName() === 'all-invoices') ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item {{ (Route::currentRouteName() === 'pending-invoices') ? 'active' : ''}}" href="{{route('pending-invoices')}}">Pending</a>
          <a class="collapse-item {{ (Route::currentRouteName() === 'all-invoices') ? 'active' : ''}}" href="{{route('all-invoices')}}">All</a>
        </div>
      </div>
    </li>

    <!-- stores or Bussiness -->
    <li class="nav-item {{ ( Route::currentRouteName() === 'store-registration-email' || Route::currentRouteName() === 'store-varification-email'|| Route::currentRouteName() === 'order-placement-email'|| Route::currentRouteName() === 'order-status-change-email' ? 'active' : '')}}">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#email_settings" aria-expanded="true" aria-controls="email_settings">
        <i class="fas fa-envelope"></i>
        <span>Emails Settings</span>
      </a>
      <div id="email_settings" class="collapse {{ Route::currentRouteName() === 'store-registration-email' || Route::currentRouteName() === 'store-varification-email'|| Route::currentRouteName() === 'order-placement-email'|| Route::currentRouteName() === 'order-status-change-email' ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item {{ (Route::currentRouteName() === 'store-registration-email' ? 'active' : '')}}" href="{{route('store-registration-email')}}">Store Registration</a>
          <a class="collapse-item {{ (Route::currentRouteName() === 'store-varification-email' ? 'active' : '')}}" href="{{route('store-varification-email')}}">Store Varification</a>
          <a class="collapse-item {{ (Route::currentRouteName() === 'order-placement-email' ? 'active' : '')}}" href="{{route('order-placement-email')}}">Order Placement</a>
          <a class="collapse-item {{ (Route::currentRouteName() === 'order-status-change-email' ? 'active' : '')}}" href="{{route('order-status-change-email')}}">Order Status Change</a>
        </div>
      </div>
    </li>

    {{-- page settings --}}
    <li class="nav-item {{ (Request::is('admin/about_us') || Request::is('admin/terms') || Request::is('admin/privacy_policy') || Request::is('admin/faq') ? 'active' : '')}}">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pages" aria-expanded="true" aria-controls="pages">
        <i class="far fa-file-alt"></i>
        <span>Page Settings</span>
      </a>
      <div id="pages" class="collapse {{ (Request::is('admin/about_us') || Request::is('admin/terms') || Request::is('admin/privacy_policy') || Request::is('admin/faq') ? 'show' : '')}}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item {{ (Request::is('admin/about_us') ? 'active' : '')}}" href="{{route('admin.about_us')}}">About us</a>
          <a class="collapse-item {{ (Request::is('admin/terms') ? 'active' : '')}}" href="{{route('admin.terms')}}">Terms & Conditions</a>
          <a href="{{route('admin.privacy_policy')}}" class="collapse-item {{ (Request::is('admin/privacy_policy') ? 'active' : '')}}">Privacy & policy</a>
          <a href="{{route('faq.index')}}" class="collapse-item {{ (Request::is('admin/faq') ? 'active' : '')}}">FAQs</a>
        </div>
      </div>
    </li>

    <li class="nav-item {{ (Request::is('superadmin/color') || Request::is('superadmin/size') ? 'active' : '')}}">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productSettings" aria-expanded="true" aria-controls="productSettings">
        <i class="fas fa-box"></i>
        <span>Product Settings</span>
      </a>
      <div id="productSettings" class="collapse  {{ (Request::is('superadmin/color') || Request::is('superadmin/size') ? 'show' : '')}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item {{ (Request::is('superadmin/color') ? 'active' : '')}}" href="{{route('color.index')}}">Colors</a>
          {{-- <a class="collapse-item {{ (Request::is('superadmin/size') ? 'active' : '')}}" href="{{route('size.index')}}">Sizes</a> --}}
        </div>
      </div>
  </li>
  </ul>

@else
@if(Auth::user()->role_id == 2)
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    @php
      $store_slug = \App\StoreModal::find(Auth::user()->store_id)->slug;
      // dd($store_slug);
    @endphp
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
      <div class="sidebar-brand-icon rotate-n-15">
        {{-- <i class="fas fa-laugh-wink"></i> --}}
      </div>
      <div class="sidebar-brand-text mx-3">{{ Auth::user()->name }}</div>
    </a>
    
    <li class="nav-item">
      <a class="nav-link" href="{{URL('store/'.$store_slug)}}">
        <i class="fas fa-fw fa-home"></i>
        <span>Website</span></a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ (Request::is('admin') ? 'active' : '')}}">
      <a class="nav-link" href="{{route('admin')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    {{-- start Shop Setting --}}
    <li class="nav-item {{ (Request::is('admin/banner') ? 'active' : '')}}">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shop" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-image"></i>
        <span>Banner Setting</span>
      </a>
      <div id="shop" class="collapse {{ (Request::is('admin/banner') ? 'show' : '')}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item {{ (Request::is('admin/banner') ? 'active' : '')}}" href="{{route('banner.index')}}">Banners</a>
          
        </div>
      </div>
    </li>
    {{-- Start Banner --}}
    {{-- <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-image"></i>
        <span>Banners</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Banner Options:</h6>
          <a class="collapse-item" href="{{route('banner.index')}}">View Banners</a>
          <a class="collapse-item" href="{{route('banner.create')}}">Add Banners</a>
        </div>
      </div>
    </li> --}}

    <!-- Categories -->
    <li class="nav-item {{ (Request::is('admin/color') || Request::is('admin/size') || Request::is('admin/brand') || Request::is('admin/taxs') || Request::is('admin/discounts') || Request::is('admin/category') || Request::is('admin/product')  || Request::is('admin/coupon') || Request::is('admin/payments') || Request::is('admin/shipping') ? 'active' : '')}}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse" aria-expanded="true" aria-controls="categoryCollapse">
          <i class="fas fa-cog"></i>
          <span>Product Settings</span>
        </a>
        <div id="categoryCollapse" class="collapse  {{ (Request::is('admin/color') || Request::is('admin/size') || Request::is('admin/brand') || Request::is('admin/taxs') || Request::is('admin/discounts') || Request::is('admin/category') || Request::is('admin/product')  || Request::is('admin/coupon') || Request::is('admin/payments') || Request::is('admin/shipping') ? 'show' : '')}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ (Request::is('admin/brand') ? 'active' : '')}}" href="{{route('brand.index')}}">Brands</a>
            <a class="collapse-item {{ (Request::is('admin/category') ? 'active' : '')}}" href="{{route('category.index')}}">Category</a>
            <a class="collapse-item {{ (Request::is('admin/discounts') ? 'active' : '')}}" href="{{route('discounts.index')}}">Discount</a>
            <a class="collapse-item {{ (Request::is('admin/size') ? 'active' : '')}}" href="{{route('size.index')}}">Sizes</a>
            <a class="collapse-item {{ (Request::is('admin/product') ? 'active' : '')}}" href="{{route('product.index')}}">Products</a>
            <a class="collapse-item {{ (Request::is('admin/taxs') ? 'active' : '')}}" href="{{route('taxs.index')}}">Tax</a>
            <a class="collapse-item {{ (Request::is('admin/payments') ? 'active' : '')}}" href="{{route('payments.index')}}">Payment Method</a>
            <a class="collapse-item {{ (Request::is('admin/coupon') ? 'active' : '')}}" href="{{route('coupon.index')}}">Coupon</a>  
            <a class="collapse-item {{ (Request::is('admin/shipping') ? 'active' : '')}}" href="{{route('shipping.index')}}">Shipping</a>
          </div>
        </div>
    </li>
      {{--  Start POS--}}
      @php
        $modules = json_decode(\App\User::find(Auth::user()->id)->store->modules, true);
      @endphp
      @if(isset($modules) &&  $modules['shop'] == '1')
      <li class="nav-item {{ (Request::is('admin/web/sales') ? 'active' : '')}}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#posCollapse" aria-expanded="true" aria-controls="posCollapse">
          <i class="fas fa-cubes"></i>
          <span>POS</span>
        </a>
        <div id="posCollapse" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ (Request::is('admin/web/sales') ? 'active' : '')}}" href="{{route('shopOrder')}}">Sale </a>
          </div>
        </div>
    </li>
    @endif
        <!-- For sale -->
        <li class="nav-item {{ (Request::is('admin/web/sales') ? 'active' : '')}}">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#saleCollapse" aria-expanded="true" aria-controls="saleCollapse">
            <i class="fas fa-sitemap"></i>
            <span>Sales</span>
          </a>
          <div id="saleCollapse" class="collapse {{ ( (Request::is('admin/web/sales') || Request::is('admin/app/sales') || Request::is('admin/shop/sales') ) ? 'show' : '')}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item {{ (Request::is('admin/web/sales') ? 'active' : '')}}" href="{{route('web.sale')}}">Website</a>
              @if(isset($modules) &&  $modules['app'] == '1')
              <a class="collapse-item {{ (Request::is('admin/app/sales') ? 'active' : '')}}" href="{{route('app.sale')}}">App</a>
              @endif
              @if(isset($modules) &&  $modules['shop'] == '1')
                <a class="collapse-item {{ (Request::is('admin/shop/sales') ? 'active' : '')}}" href="{{route('shop.sale')}}">Shop</a>
              @endif
            </div>
          </div>
      </li>
    {{-- Add Products Tax --}}
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taxCollapse" aria-expanded="true" aria-controls="taxCollapse">
          <i class="fas fa-cubes"></i>
          <span>Tax and Discount</span>
        </a>
        <div id="taxCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tax Options:</h6>
            
          </div>
        </div>
    </li> --}}
    {{-- Products --}}
    {{-- <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse" aria-expanded="true" aria-controls="productCollapse">
        <i class="fas fa-cubes"></i>
        <span>Products</span>
      </a>
      <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Product Options:</h6>
          <a class="collapse-item" href="{{route('product.index')}}">View Products</a>
          <a class="collapse-item" href="{{route('product.create')}}">Add Product</a>
        </div>
      </div>
  </li> --}}
    {{-- Brands --}}
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brandCollapse" aria-expanded="true" aria-controls="brandCollapse">
          <i class="fas fa-table"></i>
          <span>Brands</span>
        </a>
        <div id="brandCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Brand Options:</h6>
            <a class="collapse-item" href="{{route('brand.index')}}">View Brands</a>
            <a class="collapse-item" href="{{route('brand.create')}}">Add Brand</a>
          </div>
        </div>
    </li> --}}

    {{-- Shipping  --}}
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shippingCollapse" aria-expanded="true" aria-controls="shippingCollapse">
          <i class="fas fa-truck"></i>
          <span>Shipping</span>
        </a>
        <div id="shippingCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Shipping Options:</h6>
            <a class="collapse-item" href="{{route('shipping.index')}}">Shipping</a>
            <a class="collapse-item" href="{{route('shipping.create')}}">Add Shipping</a>
          </div>
        </div>
    </li> --}}

    <!--Orders Return -->
    @php $return_count = \App\Models\ReturnOrders::where('seen', '0')->count(); @endphp
    <li class="nav-item {{(Request::is('admin/return-orders') ? 'active' : '' )}}">
        <a class="nav-link" href="{{route('order.return')}}">
            <i class="fas fa-reply fa-chart-area"></i>
            <span>Return Orders @if($return_count)<span class="badge badge-danger badge-counter pr-2 mr-2 mt-1">{{ $return_count }}</span>@endif</span>
        </a>
    </li>


    <!--Orders -->
    <li class="nav-item {{(Request::is('admin/order') ? 'active' : '' )}}">
        <a class="nav-link" href="{{route('order.index')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Orders History</span>
        </a>
    </li>

    <!-- Reviews -->
    <li class="nav-item {{ Request::is('review') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('review.index')}}">
            <i class="fas fa-comments"></i>
            <span>Reviews History</span></a>
    </li>

    
    <!-- Posts -->
    <li class="nav-item {{ (Request::is('admin/post-tag') || (Request::is('admin/post-category')) || (Request::is('admin/post')) ) ? 'active' : '' }}">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCollapse" aria-expanded="true" aria-controls="postCollapse">
        <i class="fas fa-fw fa-folder"></i>
        <span>Posts Settings</span>
      </a>
      <div id="postCollapse" class="collapse {{ (Request::is('admin/post-tag') || (Request::is('admin/post-category')) || (Request::is('admin/post')) ) ? 'show' : '' }} " aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item {{ (Request::is('admin/post-tag')) ? 'active' : '' }}" href="{{route('post-tag.index')}}">Tags</a>
          <a class="collapse-item {{ (Request::is('admin/post-category')) ? 'active' : '' }} " href="{{route('post-category.index')}}">Categories</a>
          <a class="collapse-item {{ (Request::is('admin/post')) ? 'active' : '' }} " href="{{route('post.index')}}">Posts</a>
        </div>
      </div>
    </li>
    {{-- page settings --}}
    <li class="nav-item {{ (Request::is('admin/about_us') || (Request::is('admin/terms')) || (Request::is('admin/privacy_policy')) || (Request::is('admin/faq')) ) ? 'active' : '' }}">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#information-pages" aria-expanded="true" aria-controls="information-pages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Information Pages</span>
      </a>
      <div id="information-pages" class="collapse {{ (Request::is('admin/about_us') || (Request::is('admin/terms')) || (Request::is('admin/privacy_policy')) || (Request::is('admin/faq')) ) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          {{-- <h6 class="collapse-header">Settings Options:</h6> --}}
          <a class="collapse-item {{ (Request::is('admin/about_us')) ? 'active' : '' }}" href="{{url('admin/about_us')}}">About us</a>
          <a class="collapse-item {{ (Request::is('admin/terms')) ? 'active' : '' }}" href="{{url('admin/terms')}}">Terms & Conditions</a>
          <a href="{{url('admin/privacy_policy')}}" class="collapse-item {{ (Request::is('admin/privacy_policy')) ? 'active' : '' }}">Privacy & policy</a>
          <a href="{{url('admin/faq')}}" class="collapse-item {{ (Request::is('admin/faq')) ? 'active' : '' }}">FAQs</a>
        </div>
      </div>
    </li>

    {{-- Customer Service --}}
    <li class="nav-item {{ (Request::is('admin/payment_methods') || (Request::is('admin/money_back')) || (Request::is('admin/return')) || (Request::is('admin/shipping-policy')) ) ? 'active' : '' }}">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#customer-service-pages" aria-expanded="true" aria-controls="customer-service-pages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Customer Service Pages</span>
      </a>
      <div id="customer-service-pages" class="collapse {{ (Request::is('admin/payment_methods') || (Request::is('admin/money_back')) || (Request::is('admin/return')) || (Request::is('admin/shipping-policy')) ) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          {{-- <h6 class="collapse-header">Settings Options:</h6> --}}
          <a class="collapse-item {{ (Request::is('admin/payment_methods')) ? 'active' : '' }}" href="{{url('admin/payment_methods')}}">Payment Methods</a>
          <a class="collapse-item {{ (Request::is('admin/money_back')) ? 'active' : '' }}" href="{{url('admin/money_back')}}">Money back</a>
          <a class="collapse-item {{ (Request::is('admin/return')) ? 'active' : '' }}" href="{{url('admin/return')}}" >Returns</a>
          <a class="collapse-item {{ (Request::is('admin/shipping-policy')) ? 'active' : '' }}" href="{{url('admin/shipping-policy')}}">Shipping</a>
        </div>
      </div>
    </li>

    
    

     <!-- Category -->
     {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCategoryCollapse" aria-expanded="true" aria-controls="postCategoryCollapse">
          <i class="fas fa-sitemap fa-folder"></i>
          <span>Post Category</span>
        </a>
        <div id="postCategoryCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Category Options:</h6>
            <a class="collapse-item" href="{{route('post-category.index')}}">View Category</a>
            <a class="collapse-item" href="{{route('post-category.create')}}">Add Category</a>
          </div>
        </div>
      </li> --}}

      <!-- Tags -->
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tagCollapse" aria-expanded="true" aria-controls="tagCollapse">
            <i class="fas fa-tags fa-folder"></i>
            <span>Post Tags</span>
        </a>
        <div id="tagCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tag Options:</h6>
            <a class="collapse-item" href="{{route('post-tag.index')}}">View Tag</a>
            <a class="collapse-item" href="{{route('post-tag.create')}}">Add Tag</a>
            </div>
        </div>
    </li> --}}

      <!-- Comments -->
      <li class="nav-item {{ (Request::is('comment') ? 'active' : '') }}">
        <a class="nav-link" href="{{route('comment.index')}}">
            <i class="fas fa-comments fa-chart-area"></i>
            <span>Comments</span>
        </a>
      </li>

      <li class="nav-item {{ ((Route::currentRouteName() === 'store-pending-invoices') ? 'active' : '') }}">
        <a class="nav-link" href="{{route('store-pending-invoices')}}">
            <i class="fas fa-file-invoice"></i>
            <span>Invoices</span>
        </a>
      </li>

      


        <!-- Payment Method -->
    {{-- <li class="nav-item">
      <a class="nav-link" href="{{route('payments.index')}}">
          <i class="fas fa-table"></i>
          <span>Payment Method</span></a>
    </li> 
     <li class="nav-item">
      <a class="nav-link" href="{{route('coupon.index')}}">
          <i class="fas fa-table"></i>
          <span>Coupon</span></a>
    </li> --}}
     <!-- Users -->
     {{-- <li class="nav-item {{ (Request::is('admin/users') ? 'active' : '') }}">
        <a class="nav-link" href="{{route('users.index')}}">
            <i class="fas fa-users"></i>
            <span>Customers</span></a>
    </li> --}}
     <!-- General settings -->
     <li class="nav-item {{(Request::is('admin/social-links')? 'active' : '') }}">
        <a class="nav-link" href="{{route('admin.social_links')}}">
            <i class="fas fa-cog"></i>
            <span>Social Links Settings</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
@endif
@if(Auth::user()->role=='operator')
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Operator</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('admin')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Operator</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!--Orders -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('order.index')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Orders History</span>
        </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <!-- <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> -->

</ul>
@endif

@endif