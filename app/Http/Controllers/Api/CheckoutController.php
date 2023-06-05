<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\SendResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\StatusNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class CheckoutController extends Controller
{
    use SendResponseTrait;

    public function promo_code(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'promo_code' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->first('promo_code');
                return $this->SendResponse(false,$errors, []);
            }
            $coupon = Coupon::where('code', $request->promo_code)
                ->select('code','type','value')
                ->first();
            if ($coupon) {
                return $this->SendResponse(true, 'coupon found', ['coupon' => $coupon]);
            } else {
                return $this->SendResponse(false, 'coupon not found', []);
            }
        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }
    public function place_order(Request $request)
    {
      
        try {
            $validator = Validator::make($request->all(), [
                'name'=>'required',
                'email'=>'required',
                'building'=>'required',
                'address1'=>'string|required',
                'area'=>'required',
                'city'=>'required',
                'postcode'=>'required',
                'phone' => 'required',
                'order_notes'=>'string|nullable'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errors = implode('\n', $errors);
                return $this->SendResponse(false,$errors, []);
            }
  

            $cart = Cart::where('user_id',auth('sanctum')->user()->id)
                ->select(DB::raw('distinct(store_id) as store_id'));
            if($cart->count() < 1):
                return $this->SendResponse(false, 'cart is empty', []);
            endif;
            $order= new Order();
            $store_ids = $cart->pluck('store_id')->toArray();
            set_time_limit(300);
            
            foreach ($store_ids as $store_id) {
                    
                     $cartdata = Cart::where('store_id',$store_id)
                    ->where('user_id',auth('sanctum')->user()->id);
                    $discount = 0;
                    if($request->has('coupon')):
                        $value = Coupon::where('code',$request->coupon);
                        if($value->count()>0):
                            $coupon = $value->first();
                            if(!$coupon->percent_off == '' && $coupon->percent_off != null):
                                $discount = $cartdata->sum('selling_gross') * $coupon->value / 100;
                            else:
                                $discount = $coupon->value;
                            endif;
                        endif;
                    endif;
                    $orderData = [
                        'order_number' => 'FBR-'.strtoupper(Str::random(10)),
                        'user_id' =>  auth('sanctum')->user()->id,
                        'quantity' =>  $cartdata->sum('quantity'),
                        'coupon'   => $discount,
                        'total_amount' =>  $cartdata->sum('amount'),
                        'payment_id' => $request->payment_id ? : 6,
                        'delivery_date' =>  $request->delivery_date ? : null,
                        'name' =>   $request->name,
                        'email' =>  $request->email,
                        'building' => $request->building,
                        'address1' =>  $request->address1,
                        'address2' =>  $request->address2,
                        'area' =>  $request->area,
                        'city' =>  $request->city,
                        'postcode' => $request->postcode,
                        'phone' => $request->phone,
                        'cnic' => $request->cnic,
                        'shipping_id'  => $request->shipping,
                        'store_id' =>  $store_id,
                        'shipping_id' =>  $request->shipping_id,
                        'sale' =>  'app',
                    ];
                    $order = Order::create($orderData);
                        foreach($cartdata->get() as $key=> $val){
                            $product = Product::find($val->product_id);
                            $orderDetails = [
                                    "order_id"=> $order->id,
                                    "product_id"=>$val->product_id,
                                    "sale_price"=>$product->price,
                                    "sale_discount"=>$product->discount,
                                    "sale_quantity"=> $val->quantity,
                                    "choice_id"=>$val->choice_id,
                                    "size_id"=>$val->size_id,
                                    'store_id'=>$val->store_id,
                                ];
                            $order_details=OrderDetail::create($orderDetails);
                        }

                        Cart::where('store_id',$store_id)
                        ->where('user_id',auth('sanctum')->user()->id)
                        ->delete();
                    $t_mail =$request->email;
                    $user=[
                        'name'=> $request->name,
                        'phone' =>$request->phone,
                        'home' =>$request->home,
                        'street' =>$request->street,
                        'city'=>$request->city,
                        'order_number'=>$order->order_number,
                        'created_at'=>$order->delivery_date,
                        'address1'=>$order->address1,
                    ];
                    $coupon = $request->coupon ? : 0;
                    $quantity=$order->quantity ? : 0;
                    $total_amount= $order->total_amount;
                    $orderDetail=OrderDetail::with('product')->where('order_id',$order->id)->get();
                    Mail::send('email.user-order',['coupon'=>$coupon,'store_id' => $store_id,'orderDetail'=>$orderDetail,'total_amount'=>$total_amount,'product'=>$product,'user'=>$user,'order_details'=>$order_details], function ($message) use ($t_mail, $user ) {
                        $message->to($t_mail);
                        $message->subject('E-bazar Your Order ('.$user['order_number'] .')');
                    });
            
                    $t_mails= User::where('store_id',$store_id)->get();
                    foreach($t_mails as $t_mail){
                        Mail::send('email.user-order',['coupon'=>$coupon,'store_id'=> $store_id,'orderDetail'=>$orderDetail,'total_amount'=>$total_amount,'product'=>$product,'user'=>$user,'order_details'=>$order_details], function ($message) use ($t_mail, $user ) {
                            $message->to($t_mail->email);
                            $message->subject('E-bazar New Order ('.$user['order_number'] .') From App');
                        });
            
                    }
            
                    $users=User::where('store_id',$store_id)->first();
                    $details=[
                        'title'=>'New order created',
                        'actionURL'=> route('order.show',$order->id),
                        'fas'=>'fa-file-alt',
                        'store_id' => $store_id,
                    ];
                    // dd($details);
                    Notification::send($users, new StatusNotification($details));
                
            } 
              
           
            return $this->SendResponse(true, 'order placed success');
        } catch (\Throwable $e) {
            // return $this->SendResponse(false, $e->getMessage(), []);
            throw $e;
        }
    }

    public function payment_methods_shippings(){
        try {
            $payment_methods = \App\Payment::all();
            $shippings = \App\Models\Shipping::all();
            return $this->SendResponse(true, '', ['payment_methods'=>$payment_methods,'shippings'=>$shippings]);    

        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }
}
