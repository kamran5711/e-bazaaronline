<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Coupon;
use App\StoreModal;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippings = Shipping::with(['country', 'state', 'city'])->where('store_id', auth()->user()->store_id)->orderBy('id','ASC')->orderBy('id','DESC')->paginate(10);
        return view('backend.shipping.index', compact('shippings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $store = StoreModal::with('address')->where('id', auth()->user()->store_id)->first();
        $store_country_id = $store->address->country_id;
        $store_state_id = $store->address->state_id;
        $store_city_id = $store->address->city_id;
        $countries = Country::get(['id', 'name']);
        $states = State::where('country_id', $store_country_id)->get(['id', 'name']);
        $cities = City::where('state_id', $store_state_id)->get(['id', 'name']);
        return view('backend.shipping.create', compact('countries', 'states', 'cities', 'store_country_id', 'store_state_id', 'store_city_id'));
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
            'country_id' =>  'required',
            'state_id' =>  'required',
            'city_id' =>  'required',
            'price'=>'nullable|numeric',
            'status'=>'required|in:active,inactive'
        ]);
        $data = $request->except('_token');
        $data['store_id'] = auth()->user()->store_id;
        // return $data;
        $status = Shipping::create($data);
        if($status){
            request()->session()->flash('success','Shipping successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('shipping.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // with(['country', 'state', 'city'])->
        $shipping = Shipping::find($id);
        $country_id = $shipping->country_id;
        $state_id = $shipping->state_id;
        $city_id = $shipping->city_id;
        $countries = Country::get(['id', 'name']);
        $states = State::where('country_id', $country_id)->get(['id', 'name']);
        $cities = City::where('state_id', $state_id)->get(['id', 'name']);
        if(!$shipping){
            request()->session()->flash('error','Shipping not found');
        }
        return view('backend.shipping.edit', compact('shipping', 'countries', 'states', 'cities'));
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
        $shipping = Shipping::find($id);
        $this->validate($request, [
            'country_id' =>  'required',
            'state_id' =>  'required',
            'city_id' =>  'required',
            'price'=>'nullable|numeric',
            'status'=>'required|in:active,inactive'
        ]);
        $data = $request->all();
        $data['store_id'] = auth()->user()->store_id;
        // return $data;
        $status=$shipping->fill($data)->save();
        if($status){
            request()->session()->flash('success','Shipping successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('shipping.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipping=Shipping::find($id);
        if($shipping){
            $status=$shipping->delete();
            if($status){
                request()->session()->flash('success','Shipping successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('shipping.index');
        }
        else{
            request()->session()->flash('error','Shipping not found');
            return redirect()->back();
        }
    }
}
