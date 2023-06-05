<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Helper;
use Session;
use App\User;
use App\Payment;
use App\StoreModal;
use App\Models\Cart;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Wishlist;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CartController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }
    
    public function addToCart(Request $request){

        //session()->put('cart',[]);
        // dd($request->all());
        if (empty($request->product_id)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }        
        $product = Product::where('id', $request->product_id)->first();
        $cart = $request->session()->get('cart', []);
        // dd($cart);
        $index = $request->product_id."_".$request->size_id."_".$request->choice_id;
        if( ($product->productStock->sum('stock') < $request->quant[1]) && $product->productStock->sum('stock') != 0 ){
            return back()->with('error','Stock not sufficient!.');
        }

        if(isset($cart[$index])){
            if($product->productStock->sum('stock') < ( ($cart[$index]['quantity'] + $request->quant[1]) ) || $product->productStock->sum('stock') <= 0){
                return back()->with('error','Stock not sufficient!.');
            }else{
                $cart[$index]['quantity'] =  $request->has('quant') ? $cart[$index]['quantity'] + $request->quant[1] : $cart[$index]['quantity']++;
            } 
        }else{
            $cart[$index]=[
                'id'=>$request->product_id,
                'size_id'=>$request->size_id,
                'choice_id'=>$request->choice_id,
                'quantity'=> $request->has('quant') ? $request->quant[1] : 1,
            ];
        }
        $total_cart_amount=0;
        foreach($cart as $key=>$val){
            $get_product = explode('_', $key);
            $product = Product::where('id', $get_product[0])->first();
            $sale_price = $product->price;
            $sale_quantity = $val['quantity'];
            $sale_discount = $product->discount;
            if($sale_discount > 0){
                $sale_price = ($sale_price - ($sale_price * ($sale_discount) / 100));
            }
            $total_cart_amount += ($sale_price * $val['quantity']);
        }
        session()->put('cart_total', $total_cart_amount);
        session()->put('cart', $cart);
        if (empty($product)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }

        // $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',$request->order_id)->where('product_id', $request->product_id)->where('choice_id', $request->choice_id)->where('size_id', $request->size_id)->first();
        // // return $already_cart;
        // if($already_cart) {
        //     $product->price=($product->price-($product->price*$product->discount)/100);
        //     $already_cart->quantity = $already_cart->quantity + 1;
        //     $already_cart->amount = $product->price+ $already_cart->amount;
        //     // return $already_cart->quantity;
        //    if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
        //     $already_cart->save();
            
        // }else{
            
        //     $cart = new Cart;
        //     $cart->user_id = auth()->user()->id;
        //     $cart->product_id = $request->product_id;
        //      $cart->size_id = $request->size_id;
        //     $cart->choice_id = $request->choice_id;
        //     $cart->price = ($product->price-($product->price*$product->discount)/100);
        //     $cart->quantity = 1;
        //     $cart->amount=$cart->price*$cart->quantity;
        //    // dd($cart);
        //     if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
        //     $cart->save();
        //     $wishlist=Wishlist::where('user_id',auth()->user()->id)->where('cart_id',null)->update(['cart_id'=>$cart->id]);
        // }
        request()->session()->flash('success','Product successfully added to cart');
        return back();
    }

    public function add_to_cart_ajax(Request $request){
        $status_code = 404;
        $toReturn = [
            'error' => true,
            'message' => 'Stock not sufficient!',
            "data" => [],
            "directory_path" => '',
        ];
        // if (empty($request->product_id)) {
        //     request()->session()->flash('error','Invalid Products');
        //     return back();
        // }
        $size_id = $request->size_id;
        $color_id = $request->choice_id;
        $product = Product::with(['productStock'=> function($query) use ($size_id, $color_id) {
            $query->where('color_id', $color_id)->where('size_id', $size_id);
        }])->where('id', $request->product_id)->first();
        $cart = $request->session()->get('cart', []);
        $index = $request->product_id."_".$request->size_id."_".$request->choice_id;

        if( ($product->productStock->sum('stock') < $request->quant[1]) && $product->productStock->sum('stock') != 0 ){
            return response()->json($toReturn, $status_code);
        }


        if(isset($cart[$index])){
            if($product->productStock->sum('stock') < ( $cart[$index]['quantity'] + $request->quant[1] ) || $product->productStock->sum('stock') <= 0){
                // request()->session()->flash('error','Stock not sufficient!');
                return response()->json($toReturn, $status_code);
            }else{
                $cart[$index]['quantity'] = $request->quantity;
            } 
        }else{
            $cart[$index] = [
                'id' => $request->product_id,
                'size_id' => $request->size_id,
                'choice_id' => $request->choice_id,
                'quantity' => $request->has('quant') ? $request->quant[1] : 1,
                'store_id' => $request->store_id,
            ];
        }
        $total_cart_amount=0;
        foreach($cart as $key => $val){
            $get_product = explode('_', $key);
            $product = Product::where('id', $get_product[0])->first();
            // if (empty($product)) {
            //     request()->session()->flash('error','Invalid Products');
            //     return back();
            // }            
            $sale_price = $product->price;
            $sale_quantity = $val['quantity'];
            $sale_discount = $product->discount;
            if($sale_discount > 0){
                $sale_price = ($sale_price - ($sale_price * ($sale_discount) / 100));
            }
            $total_cart_amount += ($sale_price * $val['quantity']);
        }
        session()->put('cart_total', $total_cart_amount);
        session()->put('cart', $cart);
        $status_code = 200;
        $toReturn['error'] = false;
        $toReturn['message'] = "Product successfully added to cart";
        // request()->session()->flash('success','Product successfully added to cart');
        return response()->json($toReturn, $status_code);
    }

    public function load_cart_info_view(Request $request){
        return view('frontend.layouts.cart-info-view');
    }

    public function cart_delete_ajax(Request $request){
        $status_code = 400;
        $toReturn = [
            'error' => true,
            'message' => 'Error please try again',
            "data" => [],
            "directory_path" => '',
        ];
        $cart = $request->session()->get('cart');
        if(isset($cart[$request->id])){
            unset($cart[$request->id]);
            $total_cart_amount=0;
            foreach($cart as $key=>$val){
                $get_product=explode('_',$key);
                $product = Product::where('id', $get_product[0])->first();
                $sale_price=$product->price;
                $sale_quantity=$val['quantity'];
                $sale_discount=$product->discount;
                if($sale_discount>0){
                    $sale_price=($sale_price-($sale_price*($sale_discount)/100));
                }
                $total_cart_amount+=($sale_price*$val['quantity']);
            }
            session()->put('cart_total',$total_cart_amount);
            session()->put('cart',$cart);
            $status_code = 200;
            $toReturn['error'] = false;
            $toReturn['message'] = "Product successfully removed from Cart";
        }
        return response()->json($toReturn, $status_code);
    }

    public function singleAddToCart(Request $request){
        
        $request->validate([
            'slug'      =>  'required',
            'quant'      =>  'required',
        ]);
        // dd($request->quant[1]);


        $product = Product::where('slug', $request->slug)->first();
        if($product->stock <$request->quant[1]){
            return back()->with('error','Out of stock, You can add other products.');
        }
        if ( ($request->quant[1] < 1) || empty($product) ) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }    

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('product_id', $product->id)->first();

        // return $already_cart;

        if($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            // $already_cart->price = ($product->price * $request->quant[1]) + $already_cart->price ;
            $already_cart->amount = ($product->price * $request->quant[1])+ $already_cart->amount;

            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');

            $already_cart->save();
            
        }else{
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price-($product->price*$product->discount)/100);
            $cart->quantity = $request->quant[1];
            $cart->amount=($product->price * $request->quant[1]);
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            // return $cart;
            $cart->save();
        }
        request()->session()->flash('success','Product successfully added to cart.');
        return back();       
    } 
    
    public function cartDelete(Request $request){
        $cart = $request->session()->get('cart');
        if(isset($cart[$request->id])){
            unset($cart[$request->id]);
            $total_cart_amount=0;
            foreach($cart as $key=>$val){
                $get_product=explode('_',$key);
                $product = Product::where('id', $get_product[0])->first();
                $sale_price=$product->price;
                $sale_quantity=$val['quantity'];
                $sale_discount=$product->discount;
                if($sale_discount>0){
                    $sale_price=($sale_price-($sale_price*($sale_discount)/100));
                }
                $total_cart_amount += ($sale_price*$val['quantity']);
            }
            session()->put('cart_total', $total_cart_amount);
            session()->put('cart', $cart);
            if( empty( session()->get('cart') ) ){
                session()->put('coupons', []);
            }
            request()->session()->flash('success','Product successfully removed from Cart');
            return back();  
        }
        request()->session()->flash('error','Error please try again');
        return back();       
    }

    public function cartUpdate(Request $request){
        // dd($request->all());
        $cart=$request->session()->get('cart');
        if($request->quant){
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k => $quant) {
                // return $k;
                $id = $k;
                $get_product = explode('_', $id);
                $product_id = $get_product[0];
                $size_id = $get_product[1];
                $color_id = $get_product[2];
                
                // dd($request->quant, $cart, $size_id, $color_id, $get_product[0]);
                $product = Product::with(['productStock' => function($query) use ($product_id, $size_id, $color_id){
                    // $query->with('color', 'size');
                    $query->where(['product_id' => $product_id, 'size_id' => $size_id, 'color_id'=> $color_id]);

                }])->where('id', $product_id)->first();
                $size_title = Size::where('id', $size_id)->pluck('title')->first();
                $color_title = Color::where('id', $color_id)->pluck('title')->first();
                if($quant > 0 && $cart) {
                    if(!isset($product->productStock[0])){
                        request()->session()->flash('error', 'The Product named ' . $product->title . ' with color '. $color_title .' and size ' . $size_title . ' is out of stock');
                        return back();
                    }
                    if($product->productStock[0]->stock < $quant){
                        request()->session()->flash('error', 'The Product named ' . $product->title . ' with color '. $color_title .' and size ' . $size_title . ' is out of stock');
                        return back();
                    }
                    $cart[$id]['quantity'] = ($product->productStock[0]->stock > $quant) ? $quant  : $product->productStock[0]->stock;
                    if ($product->productStock[0]->stock <= 0 ) continue;
                    $total_cart_amount = 0;
                    foreach($cart as $key => $val){
                        $get_product = explode('_',$key);
                        $product = Product::where('id', $get_product[0])->first();
                        $sale_price = $product->price;
                        $sale_quantity = $val['quantity'];
                        $sale_discount = $product->discount;
                        if($sale_discount > 0){
                            $sale_price = ($sale_price-($sale_price*($sale_discount)/100));
                        }
                        $total_cart_amount += ($sale_price*$val['quantity']);
                    }
                    session()->put('cart_total', $total_cart_amount);
                    session()->put('cart', $cart);
                    $success = 'Cart successfully updated!';
                }else{
                    $error[] = 'Cart Invalid!';
                }
            }
            return back()->with($error)->with('success', $success);
        }else{
            return back()->with('Cart Invalid!');
        }    
    }

    // public function addToCart(Request $request){
    //     // return $request->all();
    //     if(Auth::check()){
    //         $qty=$request->quantity;
    //         $this->product=$this->product->find($request->pro_id);
    //         if($this->product->stock < $qty){
    //             return response(['status'=>false,'msg'=>'Out of stock','data'=>null]);
    //         }
    //         if(!$this->product){
    //             return response(['status'=>false,'msg'=>'Product not found','data'=>null]);
    //         }
    //         // $session_id=session('cart')['session_id'];
    //         // if(empty($session_id)){
    //         //     $session_id=Str::random(30);
    //         //     // dd($session_id);
    //         //     session()->put('session_id',$session_id);
    //         // }
    //         $current_item=array(
    //             'user_id'=>auth()->user()->id,
    //             'id'=>$this->product->id,
    //             // 'session_id'=>$session_id,
    //             'title'=>$this->product->title,
    //             'summary'=>$this->product->summary,
    //             'link'=>route('product-detail',$this->product->slug),
    //             'price'=>$this->product->price,
    //             'photo'=>$this->product->photo,
    //         );
            
    //         $price=$this->product->price;
    //         if($this->product->discount){
    //             $price=($price-($price*$this->product->discount)/100);
    //         }
    //         $current_item['price']=$price;

    //         $cart=session('cart') ? session('cart') : null;

    //         if($cart){
    //             // if anyone alreay order products
    //             $index=null;
    //             foreach($cart as $key=>$value){
    //                 if($value['id']==$this->product->id){
    //                     $index=$key;
    //                 break;
    //                 }
    //             }
    //             if($index!==null){
    //                 $cart[$index]['quantity']=$qty;
    //                 $cart[$index]['amount']=ceil($qty*$price);
    //                 if($cart[$index]['quantity']<=0){
    //                     unset($cart[$index]);
    //                 }
    //             }
    //             else{
    //                 $current_item['quantity']=$qty;
    //                 $current_item['amount']=ceil($qty*$price);
    //                 $cart[]=$current_item;
    //             }
    //         }
    //         else{
    //             $current_item['quantity']=$qty;
    //             $current_item['amount']=ceil($qty*$price);
    //             $cart[]=$current_item;
    //         }

    //         session()->put('cart',$cart);
    //         return response(['status'=>true,'msg'=>'Cart successfully updated','data'=>$cart]);
    //     }
    //     else{
    //         return response(['status'=>false,'msg'=>'You need to login first','data'=>null]);
    //     }
    // }

    // public function removeCart(Request $request){
    //     $index=$request->index;
    //     // return $index;
    //     $cart=session('cart');
    //     unset($cart[$index]);
    //     session()->put('cart',$cart);
    //     return redirect()->back()->with('success','Successfully remove item');
    // }

    public function checkout(Request $request){
    
        $storeAndUrl = Helper::getStoreAndUrlBySlug();
        $store = $storeAndUrl['store'];
        $store_id = $store->id;
        $user = User::with(['address' => function($query) {
            $query->with(['country', 'state', 'city']);
        }])->findOrFail(auth()->user()->id);
        $delivery_func_return_data = $this->get_delivery_charges_func($user->address->city_id);
        $shippings = $delivery_func_return_data['shippings'];
        $store_ids = $delivery_func_return_data['store_ids'];
        $payments = Payment::where('store_id', $store_id)->where('status', 'active')->get();
        $countries = Country::get(["id", "name"]);
        $states = State::where('country_id', $user->address->country_id)->get(['id', 'name']);
        $cities = City::where('state_id', $user->address->state_id)->get(['id', 'name']);
        return view('frontend.pages.checkout', compact('shippings', 'store_ids', 'payments', 'user', 'storeAndUrl', 'countries', 'states', 'cities'));
    }

    public function get_delivery_charges(Request $request){
        return response()->json($this->get_delivery_charges_func($request->city_id)['shippings']);
    }

    public function get_delivery_charges_func($city_id){
        $shippings = [];
        $store_ids = [];
        foreach (session('cart') as $key => $item) {
            if(!in_array($item['store_id'], $store_ids)){
                array_push($store_ids, $item['store_id']);
                $__shipping = Shipping::where('status', 'active')->where(['store_id' => $item['store_id'], 'city_id' => $city_id])->first();
                $__store = StoreModal::where('id', $item['store_id'])->get(['id', 'name'])->first();
                $combine_shipping_data = [];
                if($__shipping){
                    $combine_shipping_data['shipping_id'] = $__shipping->id;
                    $combine_shipping_data['price'] = $__shipping->price;
                }
                if($__store){
                    $combine_shipping_data['store_id'] = $__store->id;
                    $combine_shipping_data['store'] = $__store->name;
                }
                $combine_shipping_data = (object) $combine_shipping_data;
                array_push($shippings , $combine_shipping_data);
            }   
        }
        return ['shippings'=> $shippings, 'store_ids'=> $store_ids];
    }
 

}
