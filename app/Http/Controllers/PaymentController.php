<?php
namespace App\Http\Controllers;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments=Payment::where('store_id',auth()->user()->store_id)->orderBy('id','DESC')->paginate(5);
        // dd( $payments);
        return view('backend.payment.index',compact('payments'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.payment.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required',
          //  'details'=>'required',
        ]);
        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Payment::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['store_id']=auth()->user()->store_id;
        // return $data;
        $status=Payment::create($data);
        if($status){
            request()->session()->flash('success','Payment successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('payments.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $payment=Payment::find($id);
        if(!$payment)
        {
            request()->session()->flash('error','Payment not found');
        }
        return view('backend.payment.edit',compact('payment'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
  
    public function update(Request $request, $id)
    {
        $payment=Payment::find($id);
        $this->validate($request,[
            'title'=>'string|required',
           // 'details'=>'required',
        ]);
        $data=$request->all();
        $status=$payment->fill($data)->save();
        if($status){
            request()->session()->flash('success','Payment successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('payments.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment, $id)
    {
        $payment=Payment::find($id);
        if($payment){
            $status=$payment->delete();
            if($status){
                request()->session()->flash('success','Payment successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('payments.index');
        }
        else{
            request()->session()->flash('error','Payment not found');
            return redirect()->back();
        }
    }
}