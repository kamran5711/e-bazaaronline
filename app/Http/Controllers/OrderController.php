<?php
namespace App\Http\Controllers;
use PDF;
use Mail;
use Helper;
use App\User;
use App\StoreModal;
use Notification;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ReturnOrders;
use App\Models\Product;
use App\Models\EmailTemplate;
use App\Models\ProductStock;
use App\Models\Shipping;
use App\Models\OrderDetail;
use App\Models\OrderShipping;
use App\Models\CouponUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\StatusNotification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['order_details' => function($query){
            $query->with('product');
        }])->where('store_id',auth()->user()->store_id)->orderBy('id','DESC')->paginate(15);
        // dd($orders);
        return view('backend.order.index')->with('orders',$orders);
    }


    public function return_orders(){
        $return_orders = ReturnOrders::orderBy('id', 'desc')->whereHas('order', function($query) {
            return $query->select(['id', 'order_number'])->where('store_id',auth()->user()->store_id);
        })->paginate(15);
        return view('backend.order.return-orders', compact('return_orders'));
    }

    public function return_order_delete($id){
        $order = ReturnOrders::find($id);
        if($order){
            $status = $order->delete();
            if($status){
                request()->session()->flash('success', 'Return order successfully deleted');
            }
            else{
                request()->session()->flash('error', 'Return order can not deleted');
            }
            return redirect()->route('order.return');
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function return_order_update(Request $request){
        $data = [];
        // dd($request->all());
        if($request->has('status'))
        $data['status'] = $request->status;
        if($request->has('store_remarks'))
        $data['store_remarks'] = $request->store_remarks;

        $order = ReturnOrders::find($request->return_id);
        $status = $order->update($data);
        if($status){
            request()->session()->flash('success', 'Return order successfully updated');
        }
        else{
            request()->session()->flash('error', 'Return order can not updated');
        }
        return redirect()->route('order.return');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
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


    public function store(Request $request)
    {
        // dd($request->all(), session()->all());
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
        
        //   $recaptcha = $request['g-recaptcha-response'];
        //  $res = $this->reCaptcha($recaptcha);
        
        //  if(!$res['success']){
            
        //         return redirect()->to('checkout?k='.$request->store_id)->with('error', 'Please check the recaptcha');
        //         exit;
        // //   // Error
        //  }

        // dd($request->all());
        $cart = $request->session()->get('cart');
        if(empty($cart)){
            request()->session()->flash('error','Your cart is Empty !');
            return back();
        }
        $order = new Order();

        $order_data['order_number'] = 'FBR-'.strtoupper(Str::random(10));
        $order_data['store_id'] = implode(',', $request->hidden_store_ids);
        $order_data['user_id'] = auth()->user()->id;
        $order_data['name'] = $request->name;
        $order_data['email'] = $request->email;
        $order_data['phone'] = $request->phone;
        $order_data["country_id"] = $request->country_id;
        $order_data["state_id"] = $request->state_id;
        $order_data["city_id"] = $request->city_id;
        $order_data["address1"] = $request->address1;
        if($request->has('address2'))
            $order_data['address2'] = $request->address2;
        $total_quantity = 0;
        foreach($cart as $cart_item){
            $total_quantity = $total_quantity + $cart_item['quantity'];
        }
        $order_data['quantity'] = $total_quantity;
        $order_data['total_amount'] = 0;
        $order_data['phone'] = $request->phone;

        if($request->has('postcode'))
            $order_data['postcode'] = $request->postcode;
        if($request->has('payment_id'))
            $order_data['payment_id'] = $request->payment_id;
        if($request->has('order_notes'))
            $order_data['order_notes'] = $request->order_notes;
       
        $order->fill($order_data);
        $status = $order->save();
        if($order)
        $order_id = $order->id;
        $total_amount = 0;
        foreach($cart as $key => $val){
            $get_product = explode('_', $key);
            $product = Product::where('id', $get_product[0])->first();
            $quantity = $val['quantity'];
            $total_amount += ($product->price * $quantity);
            $order_details_arr = [
                "order_id" => $order_id,
                "product_id" => $product->id,
                "sale_price" => $product->price,
                "sale_discount" => $product->discount,
                "sale_quantity" => $quantity,
                "choice_id" => $get_product[2],
                "size_id" => $get_product[1],
                "store_id" => $product->store_id,
            ];
            $order_details = OrderDetail::create($order_details_arr);
        }
        $t_mail = $request->user()->email;
        $user = [
            'name' => $request->name,
            'phone' => $request->phone,
            'order_number' => $order_data['order_number'],
            'created_at' => $order->created_at,
            'address1' => $order_data['address1'],
        ];

        $total_coupons_price = 0;
        $total_amount = session('cart_total');
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
        $quantity = count($cart);

        Order::find($order->id)->update(array("total_amount" => $total_amount));
        $counter = 0;
        foreach ($request->hidden_store_ids as $s_i) {
            // $shipping_id = ($request->shipping_id[$counter]) ? $request->shipping_id[$counter]: 0;
            $price = ($request->price[$counter]) ? $request->price[$counter]: 'To Be Advised';
            OrderShipping::create([
                'order_id' => $order->id,
                'shipping_id' => $request->shipping_id[$counter],
                'store_id' => $s_i,
                'store' => $request->store[$counter],
                'price' => $price,
            ]);
            $counter++;
        }

        $orderDetail = OrderDetail::with('product')->where('order_id', $order_id)->get();

        $t_mail = $request->email;
        $template_data = EmailTemplate::find(3);
        try {
          Mail::send('email.user-order', ['name'=> $request->name, 'order'=> $order, 'template_data'=> $template_data, 'order_details' => $order_details], function ($message) use ($t_mail , $template_data) {
            $message->to($t_mail);
            $message->subject($template_data->subject);
           });
        } catch (\Throwable $th) {
            throw $th;
        }
        // try{
        //     Mail::send('email.user-order',['coupon' => $coupon, 'orderDetail' => $orderDetail,'total_amount' => $total_amount,'product' => $product,'user' => $user,'order_details' => $order_details], function ($message) use ($t_mail, $user ) {
        //         $message->to($t_mail);
        //         $message->subject('E-bazar Your Order ('.$user['order_number'] .')');
        //       });
        // }catch(\Throwable $th){
        //     throw $th;
        // }


        //  $t_mails = User::where('role','admin')->where('store_id',auth()->user()->store_id)->get();
        //   foreach($t_mails as $t_mail){
        //       try{
        //         Mail::send('email.user-order',['coupon' => $coupon,'orderDetail' => $orderDetail,'total_amount' => $total_amount,'product' => $product,'user' => $user,'order_details' => $order_details], function ($message) use ($t_mail, $user ) {
        //             $message->to($t_mail->email);
        //             $message->subject('E-bazar New Order ('.$user['order_number'] .')');
        //           });
        //       }catch(\Throwable $th){
                  
        //       }


        // }
        $users = User::where('role','admin')->first();
        $details=[
            'title'=>'New order created',
            'actionURL'=> route('order.show',$order->id),
            'fas'=>'fa-file-alt',
            'store_id' => $request->store_id
        ];
        Notification::send($users, new StatusNotification($details));
        request()->session()->forget('coupons');
        request()->session()->forget('cart');
        unset($cart);
        request()->session()->put('cart', []);
        request()->session()->flash('success','Your order has been placed successfully. Thank you');
        $slug = StoreModal::where('id', $request->store_id)->pluck('slug')->first();
        return redirect()->to("store/".$slug);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with(['country', 'state', 'city', 'payment', 'shippings'=> function($shippingQuery){
            $shippingQuery->where('store_id', auth()->user()->store_id);
        }, 'coupons'=> function($couponQuery){
            $couponQuery->where('store_id', auth()->user()->store_id);
        }, 'order_details' => function ($query){
            $query->with(['color', 'size', 'return_order', 'product'])->where('store_id', auth()->user()->store_id);
        }])->where('id', $id)->first();
        return view('backend.order.show')->with('order',$order);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return view('backend.order.edit')->with('order',$order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        // $this->validate($request,[
        //     'status'=>'required|in:New,Processed,Delivered,Cancelled'
        // ]); 
        $data=$request->all();
        // return $request->status;
        if($request->status=='Delivered'){
            foreach($order->cart as $cart){
                $product=$cart->product;
                // return $product;
                $product->stock -=$cart->quantity;
                $product->save();
            }
        }
        $status=$order->update($data);
        if($status){
            request()->session()->flash('success','Successfully updated order');
        }
        else{
            request()->session()->flash('error','Error while updating order');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if($order){
            $status = $order->delete();
            if($status){
                request()->session()->flash('success','Order Successfully deleted');
            }
            else{
                request()->session()->flash('error','Order can not deleted');
            }
            return redirect()->route('order.index');
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }
    public function orderTrack(){
        return view('frontend.pages.order-track');
    }
    public function track_order_process(Request $request){
        $orders = null;
        $store_slug = $request->store_slug;
        if($request->order_type == 'order_number'){
            $orders = Order::where('order_number', $request->order_number_or_email)->orderBy('id', 'DESC')->get();
        }else{
            $user_id = User::where('email', $request->order_number_or_email)->first()->id;
            $orders = Order::where('user_id', $user_id)->orderBy('id', 'DESC')->get();
        }
        return view('user.orders_list_by_number_or_email', compact('orders', 'store_slug'));
    }

    public function order_details($store_slug, $id){
        $order = Order::with(['country', 'state', 'city', 'payment', 'shippings', 'order_details' => function ($query){
            $query->with(['color', 'size', 'return_order', 'product' => function ($productQuery){
                $productQuery->with(['store'=> function ($query2){
                    $query2->with(['type', 'address' => function ($query3){
                        $query3->with(['country', 'state', 'city']);
                    }]);
                }]);
            }]);
            }])->where('id', $id)->first();
        return View('user.order_details', compact('order'));
    }

    // PDF generate
    public function pdf(Request $request){
        $order=Order::getAllOrder($request->id);
        $file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        $pdf=PDF::loadview('backend.order.pdf',compact('order'));
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        // dd($year);
        $items=Order::with(['cart_info'])->where('store_id',auth()->user()->store_id)->whereYear('created_at',$year)->where('status','Delivered')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
            // dd($items);
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->cart_info->sum('amount');
                // dd($amount);
                $m=intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
    public function update_order_status(Request $request){
      
        $today = date("Y-m-d h:i:s");
        $status = $request->status;
        $data= array("status" => $status, "updated_at" => $today);
        $append_delivery_label="";
        $order = Order::with('order_details')->find($request->order_id);
        // dd($order);
        if($status=="Processed"){
          $data['delivery_status'] = 1;
        //   $data['product_delivery'] = $request->product_delivery ? : 0;
          $data['verified_date'] = $today;
        //   $append_delivery_label = $request->product_delivery > 0 ? "\nDelivery charges are Rs.".$request->product_delivery:"\nThere are no delivery charges.";
        }
        if($status=="Dispatched"){
            $data['dispatched_date'] = $today;
            foreach($order->order_details as $o_d){
                // dd($o_d);
                $stock_query = ProductStock::where(['product_id' => $o_d->product_id, 'size_id' => $o_d->size_id, 'color_id'=> $o_d->choice_id]);
                $stock = $stock_query->first()->stock;
                $stock_query->update(['stock' => $stock - $o_d->sale_quantity]);
            }
        }
        if($status == "Delivered"){
        //   $data['is_paid']=1;
          $data['paid_amount'] = $request->paid_amount ? : 0;
          $data['paid_date'] = $today;
        }
        if($status=="Cancelled"){
          if(isset($request->cancelled_by)){
            $data['cancelled_by']= 1;  
          }
          $data['cancelled_date'] = $today;
        }
        $array_subjects = array("Processed"=>"Your Order # ".$request->order_id." has been Processed","Dispatched"=>"Your Order # ".$request->order_id." has been Dispatched","Delivered"=>"Your Order # ".$request->order_id." has been delivered & completed successfully.","Cancelled"=>"Your Order # ".$request->order_id." has been cancelled");
        $array_details = array("Processed"=>"Order # ".$request->order_id." is now Processed & will be dispatched shortly.".$append_delivery_label."\nThank you","Dispatched"=>"Order # ".$request->order_id." is now dispatched & will be delivered to your address soon.\nThank you","Delivered"=>"Your Order # ".$request->order_id." has been delivered to your address successfully & marked as completed.\nThank you.","Cancelled"=>"Oops!\nOrder # ".$request->order_id." has been cancelled now.\n Let us know if there is anything to discuss about that.\nThank you");
        $done = $order->update($data);
        if($done){
          $response['status'] = 1;
          $response['msg']="Order # ".$request->order_id." has been updated.";
          if($status != "Received"){
            $customer_email = User::where('id', $order->user_id)->first()->email;
            $message_subject = $array_subjects[$status];
            $message_body = $array_details[$status];
            //Send Email notification to customer
            if(!empty($customer_email)){
                // try{
                //     Mail::send('email.user-order',['array_subjects' => $array_subjects, 'array_details' => $array_details,'status' => $status,'order' => $order], function ($message) use ($customer_email, $order ) {
                //         $message->to($customer_email);
                //         $message->subject("E-bazar Your Order's (".$user['order_number'] .') is in '. $status . ' state');
                //       });
                // }catch(\Throwable $th){
                //     throw $th;
                // }
            }
          }
        }else{
          $response['status'] = 0;
          $response['msg'] = "Failed to update Order # ".$_POST['order_id'];
        }
        return json_encode($response);
    }

    public function get_next_status($status){
        $today = date("Y-m-d h:i:s");
        // $data['status'] = "Cancelled";
        $data["updated_at"] = $today;
        switch ($status) {
            case 'Received':
                $data['delivery_status'] = 1;
                $data['verified_date'] = $today;
                $data['status'] = "Processed";
                break;
            case 'Processed':
                $data['dispatched_date'] = $today;
                $data['status'] = "Dispatched";
                break;
            case 'Dispatched':
                $data['paid_date'] = $today;
                $data['status'] = "Delivered";
                break;
            default:
                // $data['status'] = "Cancelled";
                // $data['cancelled_date'] = $today;
                break;
        }
        return $data;
    }
    public function proceed_to_cancel(Request $request){
        $today = date("Y-m-d h:i:s");
        $status = "Cancelled";
        $data = array("status" => $status, "updated_at" => $today);
        $data['cancelled_by'] = 1;
        $data['cancelled_date'] = $today;
        OrderDetail::whereIn("id", $request->order_detail_id)->update($data);
        
        $response['status'] = 1;
        $response['msg'] = "Order # ".$request->order_number." has been updated.";
        request()->session()->flash('success', $response['msg']);
        return json_encode($response);
    }

    public function proceed_order_status(Request $request){
        $order_detail_ids = $request->order_detail_id;
        $order_id;
        foreach ($order_detail_ids as $o_d_i) {
            $order_details = OrderDetail::find($o_d_i);
            $updateData = $this->get_next_status($order_details->status);
            $order_id = $order_details->order_id;
            //reduce quantity from availible stock whenever its dispatched
            if($updateData["status"] == "Dispatched"){
                $stock_query = ProductStock::where(['product_id' => $order_details->product_id, 'size_id' => $order_details->size_id, 'color_id'=> $order_details->choice_id]);
                $stock = $stock_query->first()->stock;
                $stock_query->update(['stock' => $stock - $order_details->sale_quantity]);
            }
            if($updateData["status"] == "Delivered"){
                $data['paid_amount'] = $request->paid_amount;
            }
            $order_details->update($updateData);
        }
        $order = Order::with(['country', 'state', 'city', 'payment', 'shippings', 'order_details' => function ($query){
                    $query->with(['color', 'size', 'return_order', 'product' => function ($productQuery){
                        $productQuery->with(['store'=> function ($query2){
                            $query2->with(['type', 'address' => function ($query3){
                                $query3->with(['country', 'state', 'city']);
                            }]);
                        }]);
                    }]);
                }])->where('id', $order_id)->first();
        $order_number = $order->order_number;
        $response['status'] = 1;
        $response['msg'] = "Order # ".$order_number." has been updated.";
        
        $t_mail = $order->email;
        $template_data = EmailTemplate::find(4);
        try {
          Mail::send('email.user-order', ['name'=> $order->name, 'template_data'=> $template_data], function ($message) use ($t_mail , $template_data) {
            $message->to($t_mail);
            $message->subject($template_data->subject);
        });
        } catch (\Throwable $th) {
            throw $th;
        }
        
        // $customer_email = $order->email;
        // try{
        //     Mail::send('email.user-order',['order' => $order], function ($message) use ($order ) {
        //         $message->to($order->email);
        //         $message->subject("E-bazar Your Order's (". $order->order_number .') is moved to next state');
        //         });
        // }catch(\Throwable $th){
        //     throw $th;
        // }
        request()->session()->flash('success', $response['msg']);
        return json_encode($response);
    }


    public function user_order_status(Request $request){
        //dd($request->all());
        $today = date("Y-m-d h:i:s");$status=$request->status;
        $data=array("status"=>$status,"updated_at"=>$today);
        $append_delivery_label="";
        if($status=="Processed"){
          $data['delivery_status']=1;
          $data['product_delivery']=$request->product_delivery?:0;
          $data['verified_date']=$today;
          $append_delivery_label=$request->product_delivery>0?"\nDelivery charges are Rs.".$request->product_delivery:"\nThere are no delivery charges.";
        }
        if($status=="Dispatched"){
          $data['dispatched_date']=$today;
        }
        if($status=="Delivered"){
          $data['is_paid']=1;
          $data['paid_amount']=$request->paid_amount?:0;
          $data['paid_date']=$today;
        }
        if($status=="Cancelled"){
          if(isset($request->cancelled_by)){
            $data['cancelled_by']=1;  
          }
          $data['cancelled_date']=$today;
        }
        $array_subjects=array("Processed"=>"Your Order # ".$request->order_id." has been Processed","Dispatched"=>"Your Order # ".$request->order_id." has been Dispatched","Delivered"=>"Your Order # ".$request->order_id." has been delivered & completed successfully.","Cancelled"=>"Your Order # ".$request->order_id." has been cancelled");
        $array_details=array("Processed"=>"Order # ".$request->order_id." is now Processed & will be dispatched shortly.".$append_delivery_label."\nThank you","Dispatched"=>"Order # ".$request->order_id." is now dispatched & will be delivered to your address soon.\nThank you","Delivered"=>"Your Order # ".$request->order_id." has been delivered to your address successfully & marked as completed.\nThank you.","Cancelled"=>"Oops!\nOrder # ".$request->order_id." has been cancelled now.\n Let us know if there is anything to discuss about that.\nThank you");
        $order=Order::find($request->order_id);
        if($request->status=='Delivered'){
            foreach($order->cart as $cart){
                $product=$cart->product;
                // return $product;
                $product->stock -=$cart->quantity;
                $product->save();
            }
        }
        $done=$order->update($data);
        if($done){
          $response['status']=1;
          $response['msg']="Order # ".$request->order_id." has been updated.";
          if($status!="Received"){
            //$customer_email=User::where('id',$request->user_id)->first()->email;
            $message_subject=$array_subjects[$status];
            $message_body=$array_details[$status];
            //Send Email notification to customer
            if(!empty($customer_email)){
                //Send email code here
            }
          }
        }else{
          $response['status']=0;
          $response['msg']="Failed to update Order # ".$_POST['order_id'];
        }
        return json_encode($response);
    }



    
 public function shopSale(Request $request){
    $orders = Order::with(['order_details' => function ($query){
        $query->with(['product'])->where('store_id', auth()->user()->store_id);
    }])->where('sale', 'shop')->where('store_id', auth()->user()->store_id)->orderBy('id','DESC')->paginate(15);
    $page_title__ = "Shop Sale";
    return view('backend.for_sale.shop_sale', compact('orders', 'page_title__'));
 }

public function webSale(Request $request){
    $orders = Order::with(['order_details' => function ($query){
        $query->with([
            // 'color', 'size', 
            'product'])->where('store_id', auth()->user()->store_id);
    }])->where('sale','web')->where('store_id', auth()->user()->store_id)->orderBy('id','DESC')->paginate(15);
    // dd($orders);
    $page_title__ = "Web Sale";
    return view('backend.for_sale.web_sale', compact('orders', 'page_title__'));
 }

 public function appSale(Request $request){
    $orders = Order::with(['order_details' => function ($query){
        $query->with(['product'])->where('store_id', auth()->user()->store_id);
    }])->where('sale', 'app')->where('store_id', auth()->user()->store_id)->orderBy('id','DESC')->paginate(15);
    $page_title__ = "App Sale";
    return view('backend.for_sale.web_sale', compact('orders', 'page_title__'));
 }

}