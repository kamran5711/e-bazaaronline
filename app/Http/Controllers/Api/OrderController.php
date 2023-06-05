<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\SendResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Product;
use App\ReturnOrder;
use Carbon\Carbon;

class OrderController extends Controller
{
    use SendResponseTrait;


    public function index()
    {
        if(!auth('sanctum')->check()):
            return response(['success' => false,'message' => 'please login to procceed','status' => 401],401);
        endif;
        
       try {
            $orders = Order::where('user_id',auth('sanctum')->id())
                ->with(['order_details' => function($query){
                    $query->with(['product' => function($query){
                        $query->with(['images' => function($query){
                            $query->select('*',DB::raw('CONCAT("'.asset('products/images/products').'/",images) as photo'));
                        }]);
                    }]);
                }])    
                ->get();
            return $this->SendResponse(true, 'orders list', ['orders' => $orders]);
        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }

    public function details(Request $request)
    {
        if(!auth('sanctum')->check()):
            return response(['success' => false,'message' => 'please login to procceed','status' => 401],401);
        endif;
        try {
            $order = Order::with(['order_details' => function($query){
                        $query->with(['product','choice_or_color','size']);
                }])
                ->find($request->order_id);
            $returnOrdersIds = ReturnOrder::where('order_id',$request->order_id)->where('user_id',auth('sanctum')->user()->id)->pluck('product_id')->toArray();
            $purchasing_date = $order->created_at;
                foreach($order->order_details as $key => $value):
                    $remainig_return_days = $purchasing_date->addDays($value->product->return_days);
                    // $value->product->purchasingDate = $purchasing_date;
                    // $value->product->remainig_return_days = $remainig_return_days;
                    // $value->product->today = Carbon::now();
                    $value->product->is_return = ($remainig_return_days >= now() || !in_array($value->product->id,$returnOrdersIds)) ? true : false;
                endforeach;
            return $this->SendResponse(true, 'order details', ['order' => $order]);
        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }

    public function cancel(Request $request)
    {
        if(!auth('sanctum')->check()):
            return response(['success' => false,'message' => 'please login to procceed','status' => 401],401);
        endif;
        try {
            $order = Order::where('id',$request->order_id)->first();
            $order->status = 'cancelled';
            $order->save();
            return $this->SendResponse(true, 'order cancelled', []);
        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }

    public function return_order(Request $request)
    {
        if(!auth('sanctum')->check()):
            return response(['success' => false,'message' => 'please login to procceed','status' => 401],401);
        endif;
        try {
          
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'order_id' => 'required',
                'reason' => 'required',
                'product_id' => 'required',
                'order_detail_id' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->first('order_id').''.$validator->errors()->first('order_detail_id').''.$validator->errors()->first('product_id').''.$validator->errors()->first('reason');
                return $this->SendResponse(false, $errors, []);
            }
            $data = [
                'order_id' => $request->order_id,
                'user_id' => auth('sanctum')->user()->id,
                'status' => 'pending',
                'reason' => $request->reason,
                'order_detail_id' => $request->order_detail_id,
                'product_id' => $request->product_id,
            ];
            $check = [
                'order_id' => $request->order_id,
                'order_detail_id' => $request->order_detail_id,
                'product_id' => $request->product_id,
            ];
            $return_order = ReturnOrder::updateOrCreate($check,$data);
            return $this->SendResponse(true, 'order returned', []);
        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }

    public function my_return_orders()
    {
        if(!auth('sanctum')->check()):
            return response(['success' => false,'message' => 'please login to procceed','status' => 401],401);
        endif;
        try {
            $return_orders = ReturnOrder::where('user_id',auth('sanctum')->user()->id)
                ->with(['product'=>function($query){
                    $query->select('id','title',DB::raw('selling_gross as price'),DB::raw('CONCAT("'.asset('products/images/products').'/",photo) as photo'));
                    
                }])
                ->with(['order' => function($query){
                  $query->select('id','order_number');
                  $query->with(['order_details' => function($query){
                    $query->select('id','sale_quantity');
                  }]);
                }])
                // ->with(['order_details' => function($query){
                //     $query->select('id','sale_quantity');
                // }])
                ->get();

            return $this->SendResponse(true, 'return orders list', ['return_orders' => $return_orders]);
        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }
}
