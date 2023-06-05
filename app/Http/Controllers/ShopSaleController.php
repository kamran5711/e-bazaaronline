<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\StatusNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class ShopSaleController extends Controller
{
    public function sale()
    {
        $store_id = auth()->user()->store_id;
        $user = User::with(['address' => function($query) {
            $query->with(['country', 'state', 'city']);
        }])->findOrFail(auth()->user()->id);
        $shipping = [];// Shipping::where('status', 'active')->where('store_id', $store_id)->get();
        $payments = [];//Payment::where('status', 'active')->where('store_id', $store_id)->get();
        $countries = Country::get(["id", "name"]);
        return view('backend.shop.pos', compact('shipping', 'payments', 'countries'));
    }

    public function search_product_ajax(Request $request){

        $products = Product::query()->with(['productStock' => function ($query) {
                            $query->with(['color', 'size']);
                        }, 'category', 'sub_category', 'brand', 'images']);
                    $products->where(array('status'=> 'active', 'store_id' => auth()->user()->store_id));
                    $products = $products->where('title','like','%'.$request->search.'%');
                    $products = $products->orderBy('id','desc')->get();
                    // return response()->json($products);
        return view('backend.shop.searched-products')->with('products',$products);
    }

    public function add_to_cart_process(Request $request){
        $status_code = 400;
        $toReturn = [
            'error' => true,
            'message' => 'Insufficient stock in inventory for a product.',
            "data" => [],
            "directory_path" => '',
        ];
        $size_id = $request->size_id;
        $color_id = $request->choice_id;
        $product = Product::with(['productStock'=> function($query) use ($size_id, $color_id) {
            $query->where('color_id', $color_id)->where('size_id', $size_id);
        }])->where('id', $request->product_id)->first();
        $cart = $request->session()->get('cart', []);
        $index = $request->product_id."_".$request->size_id."_".$request->choice_id;
        if(isset($cart[$index])){
            if($product->productStock->sum('stock') < ( $cart[$index]['quantity'] + 1 ) || $product->productStock->sum('stock') <= 0){
                return response()->json($toReturn, $status_code);
            }else{
                $cart[$index]['quantity'] = $request->quantity;
            } 
        }else{
            $cart[$index] = [
                'id' => $request->product_id,
                'size_id' => $request->size_id,
                'choice_id' => $request->choice_id,
                'quantity' => $request->quantity,
            ];
        }
        $total_cart_amount = 0;
        foreach($cart as $key => $val){
            $get_product = explode('_',$key);
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
        $status_code = 200;
        $toReturn['error'] = false;
        $toReturn['message'] = "Product successfully added to cart";
        return response()->json($toReturn, $status_code);
    }

    public function get_cart_items_view(){
        return view('backend.shop.get_cart_items_view');
    }

    public function remove_cart_item(Request $request){
        $status_code = 404;
        $toReturn = [
            'error' => true,
            'message' => 'Error! Please try again.',
            "data" => [],
            "directory_path" => '',
        ];
        $cart = $request->session()->get('cart');
        if(isset($cart[$request->id])){
            unset($cart[$request->id]);
            $total_cart_amount = 0;
            foreach($cart as $key => $val){
                $get_product = explode('_', $key);
                $product = Product::where('id', $get_product[0])->first();
                $sale_price = $product->price;
                $sale_quantity = $val['quantity'];
                $sale_discount = $product->discount;
                if( $sale_discount > 0 ){
                    $sale_price = ($sale_price - ( $sale_price * ($sale_discount) / 100 ));
                }
                $total_cart_amount += ( $sale_price * $val['quantity'] );
            }
            session()->put('cart_total', $total_cart_amount);
            session()->put('cart', $cart);
            $status_code = 200;
            $toReturn['error'] = false;
            $toReturn['message'] = "Product successfully removed from Cart";
            return response()->json($toReturn, $status_code);  
        }
        return response()->json($toReturn, $status_code);
    }

    public function update_items_in_cart(Request $request){
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

    public function place_order_(Request $request){
        $status_code = 405;
        $toReturn = [
            'error' => true,
            'message' => 'Your cart is Empty !',
            "data" => [],
            "directory_path" => '',
        ];

        $cart = $request->session()->get('cart');
        if(empty($cart)){
            return response()->json($toReturn, $status_code);
        }
        $order = new Order();
        $order_data = $request->except(['g-recaptcha-response', '_token', 'add_customer_data', 'paid_amount']);
        //$order_data['order_number']='ORD-'.strtoupper(Str::random(10));
        $order_data['order_number'] = 'FBR-'.strtoupper(Str::random(10));
        $total_quantity = 0;
        foreach($cart as $cart_item){
            $total_quantity = $total_quantity + $cart_item['quantity'];
        }
        // $order_data['paid_amount'] = $request->paid_amount;
        if($request->has('add_customer_data')){

            $this->validate($request,[
                'name'=>'required',
                'email'=>'required',
                'country_id'=>'required',
                'state_id'=>'required',
                'city_id'=>'required',
                'address1'=>'string|required',
                'address2'=>'string|nullable',
                'postcode'=>'required',
                'phone' => 'required',
                'order_notes'=>'string|nullable'
            ]);

            $order_data['name'] = $request->name;
            $order_data['email'] = $request->email;
            $order_data['phone'] = $request->phone;
            $order_data['country_id'] = $request->country_id;
            $order_data['state_id'] = $request->state_id;
            $order_data['city_id'] = $request->city_id;
            $order_data['address1'] = $request->address1;
            if($request->has('address2'))
                $order_data['address2'] = $request->address2;
            if($request->has('postcode'))
                $order_data['postcode'] = $request->postcode;
            if($request->has('order_notes'))
                $order_data['order_notes'] = $request->order_notes;
        }
        // `shipping_id`, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, `billing_address`, `cancelled_by`, `cancelled_date`, `payment_id`, ``, ``, ``, `total_amount`, 
        $order_data['payment_status'] = 'paid';
        $order_data['quantity'] = $total_quantity;
        $order_data['total_amount'] = 0;
        $order_data['sale'] = "shop";
        $order_data['status'] = "Delivered";
        // dd($order_data);
        $order->fill($order_data);
        $status = $order->save();

        if($order)
            $order_id = $order->id;
            $total_amount = 0;
            $counter = 0;
            foreach($cart as $key => $val){
                
                $get_product = explode('_', $key);
                $product = Product::where('id', $get_product[0])->first();
                $sale_price = $product->price;
                $sale_quantity = $val['quantity'];
                $sale_discount = $product->discount;
                $size_id = $get_product[1];
                $choice_id = $get_product[2];
                if($sale_discount)
                    $sale_price = ($sale_discount/$sale_price) * 100;
                // paid_amount
                $total_amount += ( $sale_price * $sale_quantity );
                $order_details = OrderDetail::create([
                    "order_id" => $order_id,
                    "store_id" => $request->store_id,
                    "product_id" => $get_product[0],
                    "sale_price" => $sale_price,
                    "sale_discount" => $sale_discount,
                    "sale_quantity" => $sale_quantity,
                    "choice_id" => $get_product[2],
                    "paid_amount" => $request->paid_amount[$counter],
                    "size_id" => $get_product[1],
                    "delivery_status" => 1,
                    "paid_date" => date("Y-m-d h:i:s"),
                    "delivery_date" => date("Y-m-d h:i:s"), 
                    "status" => "Delivered",

                ]);
                $counter++;
            }
        $user = [
            'name' => $request->name,
            'phone' => $request->phone,
            'order_number' => $order_data['order_number'],
            'created_at' => $order->created_at,
            'address1' => $order_data['address1'],
        ];


        $quantity = count($cart);
        $total_coupons_price = 0;
        if(session()->has('coupons')){
            foreach(session()->get('coupons') as $coupon){
                $total_coupons_price += $coupon['value'];
                CouponUser::create([
                    'store_id' => $coupon['store_id'],
                    'order_id' => $order->id,
                    'coupon_id' => $coupon['id'],
                    'value'=> $coupon['value'],
                    'user_id' => auth()->user()->id
                ]);
            }
            $total_amount = $total_amount - $total_coupons_price;
        }
        Order::find($order->id)->update(array("total_amount" => $total_amount));

        $details = [
            'title'=>'New order created',
            'actionURL'=> route('order.show', $order->id),
            'fas'=> 'fa-file-alt',
            'store_id' => $request->store_id
        ];
        Session::forget('coupons');
        Session::forget('cart');
        unset($cart);
        Session::put('cart', []);
        $status_code = 200;
        $toReturn['error'] = false;
        $toReturn['message'] = "Order has been placed successfully";
        return response()->json($toReturn, $status_code);
    }
}
