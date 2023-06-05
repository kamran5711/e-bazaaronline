<?php

namespace App\Http\Controllers; 

use App\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $taxs=Tax::where('store_id',auth()->user()->store_id)->orderBy('id','ASC')->paginate(7);
       return view('backend.tax.index', compact('taxs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.tax.create');
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
            'tax' =>  'required|numeric',
        ]);
    $data=$request->all();
    $data['store_id'] = auth()->user()->store_id;
    $tax=Tax::create($data);
    if($tax){
        request()->session()->flash('success','Product Successfully added');
    }
    else{
        request()->session()->flash('error','Please try again!!');
    }
    return redirect()->route('taxs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
   
    public function edit($id)
    {
        $tax=Tax::findOrFail($id);
        $tax=Tax::where('id',$id)->first();
        return view('backend.tax.edit',compact('tax'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'tax' =>  'required',
        ]);
        $tax=Tax::findOrFail($id);
        $data=$request->all();
        $data['store_id'] = auth()->user()->store_id;
        $status=$tax->fill($data)->update();
        if($tax){
            request()->session()->flash('success','Product Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('taxs.index');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete=Tax::findorFail($id);
        $status=$delete->delete();
        if($status){
            request()->session()->flash('success','User Successfully deleted');
        }
        else{
            request()->session()->flash('error','There is an error while deleting users');
        }
        return redirect()->route('taxs.index');
    }
}
