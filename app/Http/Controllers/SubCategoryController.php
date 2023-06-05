<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $category = Category::findOrFail($id);
        $categories = SubCategory::with('category')->where('category_id', $id)->get();
        return view('backend.sub_category.subcategories', compact('categories', 'id', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.sub_category.create-sub', compact('category'));

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
            'status'=>'required|in:active,inactive',
            'category_id'=>'required'
        ]);
        $data= $request->all();
        $status= SubCategory::create($data);
        if($status){
            request()->session()->flash('success','Sub category successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('category.sub', ['id'=> $status->category_id ]);


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
        $categories = Category::where('store_id', auth()->user()->store_id)->get();
        $category = SubCategory::findOrFail($id);
        return view('backend.sub_category.edit', compact('category', 'categories'));
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
        $category = SubCategory::findOrFail($id);
        $this->validate($request, [
            'title' => 'string|required',
            'category_id' => 'required',
            'status'=>'required|in:active,inactive'
        ]);
        $data= $request->all();
        $status = $category->fill($data)->update();

        if($status){
            request()->session()->flash('success','Sub category successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('category.sub', ['id'=> $category->category_id ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = SubCategory::findOrFail($id);
        $status = $category->delete();
        if($status){
            request()->session()->flash('success','Category successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting category');
        }
        return back()->with('success','Category successfully deleted');
    }

    public function get_categories_by_category_id(Request $request){
        $subCategories = SubCategory::where('category_id', $request->id)->get();
        return $subCategories;
        if(count($subCategories)<=0){
            return response()->json(['status'=>false,'msg'=>'','data'=>null]);
        }
        else{
            return response()->json(['status'=>true,'msg'=>'','data'=>$subCategories]);
        }
    }
}
