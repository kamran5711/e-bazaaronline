<?php

namespace App\Http\Controllers;
use Helper;
use DB;
use Auth;
use Hash;
use Session;
use App\User;
use Newsletter;
use App\Models\Cart;
use App\Models\Faq;
use App\Models\Address;
use App\Models\Post;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Banner;
use App\Models\PostTag;
use App\Models\Product;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use App\StoreModal;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class FrontendController extends Controller
{
    var $store_id;
    public function __construct(Request $request)
    {
       $this->store_id = ($request->has('k')) ? (int) Crypt::decrypt($request->k) : 0;
    }
    public function index(Request $request){

        $featured = Product::where('status','active') ->where('store_id',$this->store_id)->where('is_featured',1)->orderBy('price','DESC')->limit(2)->get();
        $posts = Post::where('status','active') ->where('store_id',$this->store_id)->orderBy('id','DESC')->limit(4)->get();
        $banners = Banner::where('status','active') ->where('store_id',$this->store_id)->limit(3)->orderBy('id','DESC')->get();
        $products = Product::where('status','active') ->where('store_id',$this->store_id)->orderBy('id','DESC')->limit(8)->get();
        $category = Category::where('status','active') ->where('store_id',$this->store_id)->where('is_parent',1)->orderBy('title','ASC')->get();
         // return $category;
         return view('frontend.index')
                 ->with('featured',$featured)
                 ->with('posts',$posts)
                ->with('banners',$banners)
                ->with('product_lists',$products)
                ->with('categories',$category)
                 ->with('category_lists',$category);

    }

    public function get_store_id_by_slug($slug = null){
        $storeAndUrl = Helper::getStoreAndUrlBySlug();
        $store = $storeAndUrl['store'];
        return $store->id;
    }

    public function getProducts($condition, $limit = 8)
    {        
        $products = Product::with(['productStock' => function ($query) {
            $query->with(['color' => function ($query1) {
                $query1->distinct('color_id');
            }, 'size' => function ($query2) {
                $query2->distinct('size_id');
            }]);
        }])
        // ->withSum(['productStock' => function ($query) {
        //     dd($query);
        //     $query->where('product_id', $query->product_id);
        // }], 'total')
        ->where($condition)
        ->orderBy('id','DESC')
        ->limit($limit)
        ->get();
        return $products;
    }
    public function home($slug){
        $store_id = $this->get_store_id_by_slug($slug);
        $featured = Product::where('status', 'active')
            ->where('is_featured',1)
            ->where('store_id', $store_id)
            ->orderBy('price','DESC')
            ->limit(2)
            ->get();
        $posts = Post::where('status','active')
            ->where('store_id', $store_id)
            ->orderBy('id','DESC')
            ->limit(4)
            ->get();
        $banners = Banner::where('status','active')
            ->limit(3)
            ->where('store_id', $store_id)
            ->orderBy('id','DESC')
            ->get();
        $new_products = Product::with(['productStock' => function ($query) {
            $query->with(['color', 'size']);
        }])
        ->where(array('condition' => 'new', 'status'=> 'active', 'store_id' => $store_id))
        ->orderBy('id','DESC')
        ->limit(12)
        ->get();

        $storeAndUrl = Helper::getStoreAndUrlBySlug();
        $last_slug = $storeAndUrl['last_slug'];
        $hot_products = $this->getProducts(array('condition' => 'hot', 'status'=> 'active', 'store_id' => $store_id), 12);
        $category_lists = $categories = Category::where('status','active')
            ->with('products')
            ->where('store_id', $store_id)
            ->orderBy('title','ASC')
            ->get();
        return view('frontend.index', compact('featured', 'posts', 'banners', 'hot_products', 'new_products', 'category_lists', 'categories', 'last_slug'));
    }


    public function payment_methods($slug = null){
        $store_id = $this->get_store_id_by_slug($slug);
        $user_id = User::where('store_id', $store_id)->first()->id;
        $payment_method = Page::where('type', '4')->where('user_id', $user_id)->first();
        return view('frontend.pages.store.payment-methods', ['payment_methods' => $payment_method]);
    }

    public function money_back($slug = null){
        $store_id = $this->get_store_id_by_slug($slug);
        $user_id = User::where('store_id', $store_id)->first()->id;
        $money_back = Page::where('type', '5')->where('user_id', $user_id)->first();
        return view('frontend.pages.store.money_back', ['money_back' => $money_back]);
    }

    public function returns($slug = null){
        $store_id = $this->get_store_id_by_slug($slug);
        $user_id = User::where('store_id', $store_id)->first()->id;
        $returns_ = Page::where('type', '6')->where('user_id', $user_id)->first();
        return view('frontend.pages.store.returns_', ['returns_' => $returns_]);
    }

    public function shipping($slug = null){
        $store_id = $this->get_store_id_by_slug($slug);
        $user_id = User::where('store_id', $store_id)->first()->id;
        $shipping = Page::where('type', '7')->where('user_id', $user_id)->first();
        return view('frontend.pages.store.shipping', ['shipping' => $shipping]);
    }


    public function faqs($slug = null){
        $user_id = 1;
        $view = 'frontend.pages.faqs';
        if(!empty($slug)){
            $store = StoreModal::where('slug', $slug)->first();
            $user_id = $store->user->id;
            $view = 'frontend.pages.store.faqs';
        }
        $faqs = Faq::where('user_id', $user_id)->get();
        return view($view, ['faqs' => $faqs]);
    }

    public function aboutUs($slug = null){
        $user_id = 1;
        $view = 'frontend.pages.about-us';
        if(!empty($slug)){
            $store = StoreModal::where('slug', $slug)->first();
            $user_id = $store->user->id;
            $view = 'frontend.pages.store.about-us';
        }
        $about_us = Page::where('type', '1')->where('user_id', $user_id)->first();
        return view($view ,['about_us' => $about_us]);
    }
    public function terms($slug = null){
        $user_id = 1;
        $view = 'frontend.pages.terms';
        if(!empty($slug)){
            $store = StoreModal::where('slug', $slug)->first();
            $user_id = $store->user->id;
            $view = 'frontend.pages.store.terms';
        }
        $terms = Page::where('type', '2')->where('user_id', $user_id)->first();
        return view($view, ['terms' => $terms]);
    }

    public function privacy_policy($slug = null){
        $user_id = 1;
        $view = 'frontend.pages.privacy_policy';
        if(!empty($slug)){
            $store = StoreModal::where('slug', $slug)->first();
            $user_id = $store->user->id;
            $view = 'frontend.pages.store.privacy_policy';
        }
        $privacy = Page::where('type','3')->where('user_id', $user_id)->first();
        return view($view, ['privacy' => $privacy]);
    }

    public function contact(){
        return view('frontend.pages.contact');
    }

    public function productDetail($store_slug, $product_slug){
        $last_slug = $store_slug;
        $product_detail = Product::with(['productStock' => function ($query) {
            $query->with(['color', 'size']);
        }, 'category', 'sub_category', 'brand', 'images', 'getReview'])->where('slug', $product_slug)->first();
        $rel_prods = Product::where('category_id', $product_detail->category_id)
                                ->where('id', '!=' , $product_detail->id)
                                ->inRandomOrder()
                                ->with(['productStock' => function ($query) {
                                        $query->with(['color', 'size']);
                                }])
                                ->limit(8)
                                ->get();
        return view('frontend.pages.product_detail', compact('product_detail', 'rel_prods', 'last_slug'));
    }

    public function productGrids(){

        $store_id = $this->get_store_id_by_slug();
        $products = Product::query()->with(['productStock' => function ($query) {
                        $query->with(['color', 'size']);
                    }]);
        $products->where(array('status'=> 'active', 'store_id' => $store_id));
        // ->orderBy('id','DESC')
        // ->limit(12)
        // ->get();
        // $products->where('store_id',$store_id);
        
        if(!empty($_GET['category'])){
            $slug = explode(',', $_GET['category']);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            $products->whereIn('cat_id', $cat_ids);
        }
        if(!empty($_GET['brand'])){
            $brands = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $brands)->pluck('id')->toArray();
            $products->whereIn('brand_id', $brand_ids);
        }
        if(!empty($_GET['sortBy'])){
            if($_GET['sortBy'] == 'title'){
                $products = $products->orderBy('title','ASC');
            }
            if($_GET['sortBy'] == 'price'){
                $products = $products->orderBy('price','ASC');
            }
        }

        if(!empty($_GET['price'])){
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));
            
            $products->whereBetween('price', $price);
        }
        
        $recent_products = Product::where(['status'=>'active', 'store_id' => $store_id])->orderBy('id','DESC')->limit(3)->get();
        
        // Sort by number
        if(!empty($_GET['show'])){
            $products = $products->paginate($_GET['show']);
        }
        else{
            $products = $products->paginate(10);
        }
        $min_price = Product::where('store_id', $store_id)->min('price');
        $max_price = Product::where('store_id', $store_id)->max('price');

        $categories = Category::with('sub_categories')->where('store_id', $store_id)->where('status', 'active')->get();
        $brands = Brand::where('store_id', $store_id)->orderBy('title', 'ASC')->where('status', 'active')->get();
        // Sort by name , price, category      
        return view('frontend.pages.product-grids', compact('products', 'recent_products', 'min_price', 'max_price', 'categories', 'brands'));
    }

    public function orderTrack(){
        return view('frontend.track-orders.index');
    }

    public function track_order_process(Request $request){
        $orders = null;
        if($request->order_type == 'order_number'){
            $orders = Order::where('order_number', $request->order_number_or_email)->orderBy('id', 'DESC')->get();
        }else{
            $user_id = User::where('email', $request->order_number_or_email)->first()->id;
            $orders = Order::where('user_id', $user_id)->orderBy('id', 'DESC')->get();
        }
        return view('frontend.track-orders.orders_list_by_number_or_email', compact('orders'));
    }

    public function order_details($id){
        $order = Order::with(['country', 'state', 'city', 'payment', 'shippings', 'order_details' => function ($query){
                $query->with(['color', 'size', 'return_order', 'product' => function ($productQuery){
                    $productQuery->with(['store'=> function ($query2){
                        $query2->with(['type', 'address' => function ($query3){
                            $query3->with(['country', 'state', 'city']);
                        }]);
                    }]);
                }]);
                }])->where('id', $id)->first();
        return View('frontend.track-orders.order_details', compact('order'));
    }

    public function productLists(Request $request){
        
        $products = Product::query();
        $products->where('store_id',$this->store_id);
        if(!empty($_GET['category'])){
            $slug = explode(',',$_GET['category']);
            $cat_ids = Category::select('id')->where('store_id',$this->store_id)->whereIn('slug',$slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id',$cat_ids)->paginate;
            // return $products;
        }
        if(!empty($_GET['brand'])){
            
            $slugs = explode(',',$_GET['brand']);
            $brand_ids=Brand::select('id')->where('store_id',$this->store_id)->whereIn('slug',$slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id',$brand_ids);
        }
        if(!empty($_GET['sortBy'])){
            if($_GET['sortBy']=='title'){
                $products=$products->where('status','active')->orderBy('title','ASC');
            }
            if($_GET['sortBy']=='price'){
                $products=$products->orderBy('price','ASC');
            }
        }

        if(!empty($_GET['price'])){
            $price=explode('-',$_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));
            
            $products->whereBetween('price',$price);
        }

        $recent_products = Product::where('status','active')->where('store_id',$this->store_id)->orderBy('id','DESC')->limit(3)->get();
        // Sort by number
        if(!empty($_GET['show'])){
            $products = $products->where('status','active')->paginate($_GET['show']);
        }
        else{
            $products = $products->where('status','active')->paginate(6);
        }
        // Sort by name , price, category

      
        return view('frontend.pages.product-lists')->with('products',$products)->with('recent_products',$recent_products);
    }
    public function productFilter(Request $request){

        $data = $request->all();
        // dd($data);
        $query_string = "";
        // if($request->has('show') || $request->has('sortBy') || $request->has('category') || $request->has('brand') || $request->has('price') ){
        //     $query_string = "?";
        // }
        $showURL = "";
        if(!empty($data['show'])){
            if($query_string == ''){
                $query_string = "?";
                $showURL .='show=' . $data['show'];
            }else {
                $showURL .='&show=' . $data['show'];
            }
        }

        $sortByURL='';
        if(!empty($data['sortBy'])){
            if($query_string == ''){
                $query_string = "?";
                $sortByURL .='sortBy=' . $data['sortBy'];
            }else {
                $sortByURL .='&sortBy=' . $data['sortBy'];
            }
        }

        $catURL="";
        if(!empty($data['category'])){
            foreach($data['category'] as $category){
                if($query_string == ''){
                    $query_string = "?";
                    if(empty($catURL)){
                        $catURL .='category=' . $category;
                    }
                    else{
                        $catURL .=',' . $category;
                    }
    
                }else {
                    if(empty($catURL)){
                        $catURL .='&category=' . $category;
                    }
                    else{
                        $catURL .=',' . $category;
                    }
    
                }


            }
        }

        $brandURL="";
        if(!empty($data['brand'])){
            foreach($data['brand'] as $brand){
                if($query_string == ''){
                    $query_string = "?";
                    if(empty($brandURL)){
                        $brandURL .='brand='.$brand;
                    }
                    else{
                        $brandURL .=','.$brand;
                    }
                }else {
                    if(empty($brandURL)){
                        $brandURL .='&brand='.$brand;
                    }
                    else{
                        $brandURL .=','.$brand;
                    }
                }
            }
        }

        $priceRangeURL = "";
        if(!empty($data['price_range'])){
            if($query_string == ''){
                $query_string = '?';
                $priceRangeURL .= 'price=' . $data['price_range'];
            }else {
                $priceRangeURL .= '&price=' . $data['price_range'];
            }
        }
        if(request()->get('prev_url') == 'product-grids')
        return redirect($data['store_slug'].'/'.'product-grids'.$query_string.$showURL.$sortByURL.$catURL.$brandURL.$priceRangeURL);
            // return redirect()->route('product-grids', $catURL.$brandURL.$priceRangeURL.$showURL.$sortByURL);
        return redirect()->route('product-lists', $showURL.$sortByURL.$catURL.$brandURL.$priceRangeURL);
    }

    public function search_products(Request $request){
        $store_id = $request->store_id;
        $products = Product::query()->with(['productStock' => function ($query) {
                        $query->with(['color', 'size']);
                    }]);
        $products->where(array('status'=> 'active', 'store_id' => $store_id));
        if($request->has('category_id') && $request->category_id != ''){
            $products = $products->where('category_id', $request->category_id);
        }
        $products = $products->where('title','like','%'.$request->search.'%');
        // $products = $products->orwhere('slug','like','%'.$request->search.'%');
        // $products = $products->orwhere('description','like','%'.$request->search.'%');
        $products = $products->paginate(1000);
        
        $recent_products = Product::where(['status'=>'active', 'store_id' => $store_id])->orderBy('id','DESC')->limit(3)->get();
        $min_price = Product::where('store_id', $store_id)->min('price');
        $max_price = Product::where('store_id', $store_id)->max('price');
        
        $categories = Category::with('sub_categories')->where('store_id', $store_id)->where('status', 'active')->get();
        $brands = Brand::where('store_id', $store_id)->orderBy('title', 'ASC')->where('status', 'active')->get();
        return view('frontend.pages.searched_product', compact('products', 'recent_products', 'min_price', 'max_price', 'categories', 'brands'));
    }

    public function productSearch(Request $request){
        $recent_products = Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $products = Product::orwhere('title','like','%'.$request->search.'%')
                    ->orwhere('slug','like','%'.$request->search.'%')
                    ->orwhere('description','like','%'.$request->search.'%')
                   // ->orwhere('summary','like','%'.$request->search.'%')
                   ->where('store_id',$this->store_id)
                    ->orwhere('price','like','%'.$request->search.'%')
                    ->orderBy('id','DESC')
                    ->paginate('9');
        return view('frontend.pages.product-grids')->with('products',$products)->with('recent_products',$recent_products);
    }

    
    public function get_products_by_condition($feild, $id){
        // echo "hi";
        $store_id = $this->get_store_id_by_slug();
        $products = Product::query()->with(['productStock' => function ($query) {
            $query->with(['color', 'size']);
        }]);
        $products->where(array('status'=> 'active', 'store_id' => $store_id));
        $products = $products->where($feild, '=', $id);

        $products = $products->paginate(1000);

        $recent_products = Product::where(['status'=>'active', 'store_id' => $store_id])->orderBy('id','DESC')->limit(3)->get();
        $min_price = Product::where('store_id', $store_id)->min('price');
        $max_price = Product::where('store_id', $store_id)->max('price');

        $categories = Category::with('sub_categories')->where('store_id', $store_id)->where('status', 'active')->get();
        $brands = Brand::where('store_id', $store_id)->orderBy('title', 'ASC')->where('status', 'active')->get();
        return view('frontend.pages.searched_product', compact('products', 'recent_products', 'min_price', 'max_price', 'categories', 'brands'));
    }

    public function product_category(Request $request, $slug, $id){
        return $this->get_products_by_condition('category_id', $id);
    }
    
    public function product_sub_category(Request $request, $slug, $id){
        return $this->get_products_by_condition('sub_category_id', $id);
    }

    public function product_brand(Request $request, $slug, $id){
        return $this->get_products_by_condition('brand_id', $id);
    }

    public function post_with_condition($field = null, $field_value = null) {
        $store_id = $this->get_store_id_by_slug();
        $posts = [];
        if($field == null && $field_value == null){
            $posts = Post::with('category', 'post_tags')->orderBy('id', 'DESC')->where('store_id', $store_id)->paginate(16);
        }
        if($field == 'category_id' && $field_value != null){
            $posts = Post::with('category', 'post_tags')->where($field, '=', $field_value)->where('store_id', $store_id)->orderBy('id', 'DESC')->get();
        }
        if($field == 'post_tag_id' && $field_value != null){
            $posts = Post::with('category', 'post_tags')->whereHas('post_tags', function ($q) use ($field, $field_value){
                return $q->where($field, $field_value);
            })->orderBy('id', 'DESC')->where('store_id', $store_id)->get();
        }

        if($field == 'search' && $field_value != null){
            $posts = Post::orwhere('title','like','%'.$field_value.'%')
            ->where('store_id', $store_id)
            // ->orwhere('quote','like','%'.$field_value.'%')
            // ->orwhere('summary','like','%'.$field_value.'%')
            ->orwhere('description','like','%'.$field_value.'%')
            ->orwhere('slug','like','%'.$field_value.'%')
            ->orderBy('id','DESC')
            ->get();
        }

        $categories = PostCategory::where(['status' => 'active', 'store_id' => $store_id])->get(['id', 'title', 'slug']);
        $tags = PostTag::where(['status' => 'active', 'store_id' => $store_id])->get(['id', 'title', 'slug']);
        $recent_posts = Post::where(['status' => 'active', 'store_id' => $store_id])
                        ->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog', compact('posts', 'recent_posts', 'tags', 'categories'));
    }
    public function blog(){
        return $this->post_with_condition();
    }

    public function blogDetail($slug, $post_slug){

        $store_id = $this->get_store_id_by_slug();
        $categories = PostCategory::where(['status' => 'active', 'store_id' => $store_id])->get(['id', 'title', 'slug']);
        $tags = PostTag::where(['status' => 'active', 'store_id' => $store_id])->get(['id', 'title', 'slug']);
        $post = Post::getPostBySlug($post_slug);
        $recent_posts = Post::where(['status'=>'active', 'store_id'=>$store_id])->where('id', '!=', $post->id)->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog-detail', compact('post', 'recent_posts', 'categories', 'tags', 'slug'));
    }

    public function blog_category($slug, $category_slug){
        $category = PostCategory::where(['status' => 'active', 'slug' => $category_slug])->first(['id', 'title', 'slug']);
        return $this->post_with_condition('category_id', $category->id);
    }

    public function blog_tag($slug, $tag_slug)
    {
        $tag = PostTag::where(['status' => 'active', 'slug' => $tag_slug])->first(['id', 'title', 'slug']);
        return $this->post_with_condition('post_tag_id', $tag->id);
    }

    public function blog_search(Request $request){
        return $this->post_with_condition('search', $request->search);
    }

   //**********************************************************************//
    // Login
    public function login()
    {
    return view('frontend.pages.login');
    } 

    public function loginCheckout()
    {
    return view('frontend.pages.logincheckout');
    } 
    
    public function loginSubmit(Request $request){
        // echo "45544";exit;
        $data= $request->all();
        // dd($data);
        //  $recaptcha = $request['g-recaptcha-response'];
        // $res = $this->reCaptcha($recaptcha);
        
        // if(!$res['success']){
            
        //        return back()->with('error', 'Please check the recaptcha');
        //        exit;
        //   // Error
        // }
        // dd(Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'status'=>'active']));
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'status'=>'active'])){
            Session::put('user',$data['email']);
            request()->session()->flash('success', 'Successfully login');

            $cart = $request->session()->get('cart');
            if( count($cart) > 0 ){
                $last_index = array_key_last($cart);
                $ids = explode('_', $last_index);
                $product = Product::with('store')->where('id', $ids[0])->first();
                return redirect()->to( '/' . $product->store->slug . '/cart');
            }
            return redirect()->back();
        }
        else{
            request()->session()->flash('error','Invalid email and password pleas try again!');
            return redirect()->back();
        }
    }

    
//**********************************************************************//

    public function logout(){
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success','Logout successfully');
        return  redirect()->to('/');
    }

    public function register(){
        $countries = Country::get(["id", "name"]);
        return view('frontend.pages.register', compact('countries'));
    }


     
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

    public function registerSubmit(Request $request){
        $this->validate($request,[
            'name'=>'string|required|min:2',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address1' =>['required'],
            // 'building'=>['required'],
            // 'area'  =>['required'],
            // 'city'  =>['required'],
            'postcode'=>['required'],
        ]);
    //    dd($request->all());
        
        //  $recaptcha = $request['g-recaptcha-response'];
        // $res = $this->reCaptcha($recaptcha);
        
        // if(!$res['success']){
            
        //        return back()->with('error', 'Please check the recaptcha');
        //        exit;
        //   // Error
        // }

        // $data = $request->all();

        $user_data = [
            'name'=> $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'status' => 'active',
            'role_id'=> 3
            // 'building'=> $request->building,
            // 'address1' => $request->address1,
            // 'area'  =>$request->area,
            // 'city'  =>$request->city,         
        ];

        $user = User::create($user_data);
        $user_address = [
            'type' => 1,
            'store_or_user_id' => $user->id,
            'postcode' => $request->postcode,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'address1' => $request->address1,
            'address2' => $request->address2
        ];
        $user_address = Address::create($user_address);
        Session::put('user',$user_data['email']);
        if($user){
            \Illuminate\Support\Facades\Auth::LoginUsingId($user->id);
            request()->session()->flash('success','Successfully registered');
            return redirect()->route('customer.index');
            // return redirect()->back();

        }
        else{
            request()->session()->flash('error','Please try again!');
            return back();
        }
    }
    public function registerCheckout(){
        return view('frontend.pages.registercheckout');
    }
    public function registerCheckoutSubmit(Request $request){
        // return $request->all();
        $this->validate($request,[
            'name'=>'string|required|min:2',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'confirmed'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'building'=>['required'],
            'address1' =>['required'],
            'area'  =>['required'],
            'city'  =>['required'],
            'postcode'=>['required'],
        ]);

            $recaptcha = $request['g-recaptcha-response'];
        $res = $this->reCaptcha($recaptcha);
        
        if(!$res['success']){
            
               return back()->with('error', 'Please check the recaptcha');
               exit;
          // Error
        }
        $data=$request->all();
        // dd($data);
        $check= User::insert($data);
        Session::put('user',$data['email']);
        if($check){
            request()->session()->flash('success','Successfully registered');
            return redirect()->route('cart',['k'=> $request->store_id]);
        }
        else{
            request()->session()->flash('error','Please try again!');
            return back();
        }
    }
    // public function create(array $data){
    //      return User::create([
    //          'name'=>$data['name'],
    //         'postcode'=>$data['postcode'],
    //         'email'=>$data['email'],
    //         'address'=>$data['address1'],
    //         'address1'=>$data['address2'],
    //         'area'=>$data['area'],
    //         'city'=>$data['city'], 
    //         'building'=>$data['building'],
    //         'postcode'=>$data['postcode'],
    //         'password'=>Hash::make($data['password']),
    //         'status'=>'active',

    //         ]);
    // }
    // Reset password
    public function showResetForm(){
        return view('auth.passwords.old-reset');
    }

    public function subscribe(Request $request){
        if(! Newsletter::isSubscribed($request->email)){
                Newsletter::subscribePending($request->email);
                if(Newsletter::lastActionSucceeded()){
                    request()->session()->flash('success','Subscribed! Please check your email');
                    return redirect()->route('home');
                }
                else{
                    Newsletter::getLastError();
                    return back()->with('error','Something went wrong! please try again');
                }
            }
            else{
                request()->session()->flash('error','Already Subscribed');
                return back();
            }
    }
    
}
