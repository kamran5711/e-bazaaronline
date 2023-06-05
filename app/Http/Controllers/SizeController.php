<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $sizes = Size::orderBy('id','DESC')->where('store_id', auth()->user()->store_id)->get();
       return view('backend.sizes.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.sizes.create');
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
            'title' =>  'required',
            'status' => 'required',
        ]);
        $data = $request->all();
        $data['store_id'] = auth()->user()->store_id;
        $size = Size::create($data);
        if($size){
            request()->session()->flash('success','Size Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('size.index');
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
        $size = Size::where('id', $id)->first();
        return view('backend.sizes.edit', compact('size'));
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
            'title' =>  'required',
        ]);
        $size = Size::findOrFail($id);
        $data = $request->all();
        // $data['store_id'] = auth()->user()->store_id;
        $status = $size->fill($data)->update();
        if($size){
            request()->session()->flash('success','Size Successfully updated.');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('size.index');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Size::findorFail($id);
        $status = $delete->delete();
        if($status){
            request()->session()->flash('success','Size Successfully deleted');
        }
        else{
            request()->session()->flash('error','There is an error while deleting size');
        }
        return redirect()->route('size.index');
    }
}
