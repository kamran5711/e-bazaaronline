<?php

namespace App\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts=Discount::where('store_id',auth()->user()->store_id)->orderBy('id','ASC')->paginate(7);
        return view('backend.discount.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.discount.create');
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
            'discount' =>  'required',
        ]);
    $data=$request->all();
    $data['store_id'] = auth()->user()->store_id;
    $discounts=Discount::create($data);
    if($discounts){
        request()->session()->flash('success','Product Discount Successfully added');
    }
    else{
        request()->session()->flash('error','Please try again!!');
    }
    return redirect()->route('discounts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discount=Discount::findOrFail($id);
        $discount=Discount::where('id',$id)->first();
        return view('backend.discount.edit',compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'discount' =>  'required',
        ]);
        $discount=Discount::findOrFail($id);
        $data=$request->all();
        $data['store_id'] = auth()->user()->store_id;
        $status=$discount->fill($data)->update();
        if($discount){
            request()->session()->flash('success','Product Discount Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('discounts.index');
        }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete=Discount::findorFail($id);
        $status=$delete->delete();
        if($status){
            request()->session()->flash('success','Discount Successfully deleted');
        }
        else{
            request()->session()->flash('error','There is an error while deleting Discount');
        }
        return redirect()->route('discounts.index');
    }
}
