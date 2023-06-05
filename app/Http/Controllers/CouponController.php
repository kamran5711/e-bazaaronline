<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupon=Coupon::where('store_id',auth()->user()->store_id)->orderBy('id','DESC')->paginate('10');
        return view('backend.coupon.index')->with('coupons',$coupon);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            
            'code' =>  Rule::unique('coupons','code')->where(function ($query) {
                return $query->where('store_id', auth()->user()->store_id);}),
            // 'type'=>'required|in:fixed,percent',
            'value'=>'required|numeric',
            'status'=>'required|in:active,inactive'
        ]);
        $data = $request->all();
        $data['store_id'] = auth()->user()->store_id;
        $status = Coupon::create($data);
        if($status){
            request()->session()->flash('success','Coupon Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('coupon.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon=Coupon::find($id);
        if($coupon){
            return view('backend.coupon.edit')->with('coupon',$coupon);
        }
        else{
            return view('backend.coupon.index')->with('error','Coupon not found');
        }
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
        $coupon=Coupon::find($id);
        $this->validate($request,[
             'code' =>  'required',
            // 'type'=>'required|in:fixed,percent',
            'value'=>'required|numeric',
            'status'=>'required|in:active,inactive'
        ]);
        $data = $request->all();
        
        $status = $coupon->fill($data)->update();
        if($status){
            request()->session()->flash('success','Coupon Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('coupon.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon=Coupon::find($id);
        if($coupon){
            $status=$coupon->delete();
            if($status){
                request()->session()->flash('success','Coupon successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('coupon.index');
        }
        else{
            request()->session()->flash('error','Coupon not found');
            return redirect()->back();
        }
    }

    public function couponStore(Request $request){
        if(! auth()->check() ){
            request()->session()->flash('error','You need to logged in first for using coupon.');
            return back();
        }

        if( empty( session()->get('cart') ) ){
            request()->session()->flash('error','Please add some productst to your cart.');
            return back();
        }
        $coupon = Coupon::with('store')->where(['status'=> 'active', 'code' => $request->code])->first();
        if(!$coupon){
            request()->session()->flash('error','Invalid coupon code, Please try again.');
            return back();
        }
        if( $request->has('onlyStoreId') && $request->get('onlyStoreId') != $coupon->store_id ){
            request()->session()->flash('error','You can not use other shop coupon here.');
            return back();
        }
        // dd(auth()->user());
        if(!$request->has('onlyStoreId')){
            $alreadyUsed = CouponUser::where(['user_id' => auth()->user()->id, 'coupon_id' => $coupon->id])->first();
            if($alreadyUsed){
                request()->session()->flash('error','You can not use this coupon twice.');
                return back();
            }
        }
        // expiry coupon setting may be in future applied
        if($coupon->expiry_date){
            $newDateFormat2 = date('Y-m-d', strtotime(now()));
            if($coupon->expiry_date < $newDateFormat2){
                request()->session()->flash('error','Coupon code is expired at ' . $coupon->expiry_date);
                return back();
            }
        }
        $coupons = $request->session()->get('coupons', []);
        $index = "store_id-" . $coupon->store_id . "-coupon_id-" . $coupon->id;
        if(!isset($coupons[$index])){
            $coupons[$index] = [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'value' => $coupon->value,
                'store_id' => $coupon->store->id,
                'store_name' => $coupon->store->name

            ];
            session()->put('coupons', $coupons);
        }
        request()->session()->flash('success','Coupon successfully applied');
        return redirect()->back();
    }
}
