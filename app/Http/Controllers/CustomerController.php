<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use App\Models\Order;
use App\Models\ReturnOrders;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $orders = Order::with(['order_details' => function ($query){
            $query->with([
                // 'color', 'size', 
                'product']);
        }])->where('user_id', auth()->user()->id)->orderBy('id','DESC')->paginate(25);
        return view('user.new_index', compact('orders'));
    }

    public function return_order_update(Request $request){
        $data = $request->except(['return_id']);
        if($request->return_id == "null"){
            $status = ReturnOrders::create($data);
        }else{
            $order = ReturnOrders::find($request->return_id);
            $status = $order->update($data);
        }
        if($status){
            request()->session()->flash('success', 'Return order successfully updated');
        }
        else{
            request()->session()->flash('error', 'Return order can not updated');
        }
        return redirect()->back();//('customer.ordershow', $request->order_id);
    }

    public function profile()
    {
        $profile = Auth()->user();
        return view('user.users.new_profile',compact('profile'));
    }

    public function reviews()
    {
        $reviews=\App\Models\ProductReview::getAllUserReview();
        return View('user.review.new_index',compact('reviews'));
    }

    public function review_edit($id)
    {
        $review=\App\Models\ProductReview::findOrFail($id);
        return view('user.review.new_edit',compact('review'));
    }

    public function review_update(Request $request,$id)
    {
        $review = \App\Models\ProductReview::findOrFail($id);
        $review->update($request->all());
        return back()->with('success','Review Updated Successfully');
    }

    public function comments()
    {
        $comments = PostComment::getAllUserComments();
        return View('user.comment.new_index',compact('comments'));
    }

    public function comments_edit($id)
    {
        $comment = PostComment::findOrFail($id);
        return View('user.comment.new_edit',compact('comment'));
    }

    public function comments_update(Request $request,$id)
    {
        // dd($request->all());
        $comment=PostComment::findOrFail($id);
        $comment->update($request->all());
        return back()->with('success','Comment Updated Successfully');
    }

    public function showOrder($id){
        $order = Order::with(['country', 'state', 'city', 'payment', 'shippings', 'coupons' => function($query){
                    $query->with('store');
                },'order_details' => function ($query1){
                    $query1->with(['color', 'size', 'return_order', 'product' => function($query2) {
                        $query2->with(['store' => function ($query3){
                            $query3->with(['type', 'address' => function ($query4){
                                $query4->with(['country', 'state', 'city']);
                            }]);
                        }]);
                    }]);
                }])->where('id', $id)->first();
                // dd($order);
        return View('user.order.new_show',compact('order'));
    }
}
