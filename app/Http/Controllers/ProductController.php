<?php
namespace App\Http\Controllers;
use DB;
use App\Tax;
use App\User;
use App\Discount;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Choice;
use App\Models\Color;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\ColorSizeStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index()
    {
        $products = Product::with(['productStock' => function($query){
            $query->with(['color', 'size']);
        } , 'category', 'sub_category', 'brand', 'images'])
            ->where('store_id',auth()->user()->store_id)
            ->orderBy('id','desc')
            ->paginate(15);

            // dd($products[0]);
        return view('backend.product.index')->with('products',$products);
    }
    public function shopOrder()
    {
        $products= Product::where('status','active')->orderBy('price','DESC')->paginate(10);
        // $featured=Product::where('status','active')->orderBy('price','DESC')->limit(2)->get();
        return view('backend.shop.order')->with('products',$products);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colors = Color::all();
        $brands = Brand::where('store_id', auth()->user()->store_id)->get();
        $sizes = Size::where('store_id', auth()->user()->store_id)->get();
        $taxs = Tax::where('store_id', auth()->user()->store_id)->get();
        $discounts = Discount::where('store_id', auth()->user()->store_id)->get();
        $categories  = Category::where('store_id', auth()->user()->store_id)->get();
        // dd($categories, auth()->user()->store_id);
        return view('backend.product.create', compact('categories', 'brands', 'taxs', 'discounts', 'colors', 'sizes'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'=>'string|required',
            'description'=>'string|nullable',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'category_id'=>'required|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'is_featured'=>'sometimes|in:1',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric'
        ]);

        $data = [];
        $user_image = $request->file('photo');
        $extension = $user_image->getClientOriginalExtension();
        $fileName = uniqid() . '.' . $extension;
        $user_image->move('images/products', $fileName);
        $data['photo'] = $fileName;
        $data['store_id'] = auth()->user()->store_id;
        $slug = Str::slug($request->title);
        $count = Product::where('slug',$slug)->count();
        if( $count > 0 ) {
            $slug = $slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug'] = $slug;
        $data['return_policy'] = $request->return;
        $data['is_featured'] = $request->input('is_featured', 0);
        $choice_option = $request->input('choice_option') == 1 ? : 0;
        $size_option = $request->input('size_option') == 1 ? : 0;
        $data["title"] = $request->title;
        $data["brand_id"] = $request->brand_id;
        $data["category_id"] = $request->category_id;
        $data["sub_category_id"] = $request->sub_category_id;
        $data["description"] = $request->description;
        $data["purchasing_price"] = $request->purchasing_price;
        $data["purchasing_tax"] = $request->purchasing_tax;
        $data["purchasing_gross"] = $request->purchasing_gross;
        $data["price"] = $request->price;
        $data["discount"] = $request->discount;
        $data["selling_gross"] = $request->selling_gross;
        $data["condition"] = $request->condition;
        $data["status"] = $request->status;
        
        
        $product = Product::create($data);
        $productStockArr = [];
        $data['colors'] = $request->colors;
        $data['sizes'] = $request->sizes;
        $data['stock'] = $request->stock;

        foreach($data['stock'] as $key => $stock){
            $productStockArr[] = array('stock'=> $stock, 'color_id'=> $data['colors'][$key], 'size_id'=> $data['sizes'][$key]);
        }
        $product->productStock()->createMany($productStockArr);

        $images_arr = [];
        if($request->hasfile('images')){

           foreach($request->file('images') as $file){
               $name = uniqid().'.'.$file->extension();
               $file->move('images/products', $name);  
               $images_arr[] = array('image'=> $name);
            }
            $product->images()->createMany($images_arr);
        }
        if($data){
            request()->session()->flash('success','Product Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product.index');
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
        $data['colors'] = Color::all();
        $data['sizes'] = Size::where('store_id', auth()->user()->store_id)->get();
        $data['brands'] = Brand::where('store_id', auth()->user()->store_id)->get();
        $data['taxs'] = Tax::where('store_id', auth()->user()->store_id)->get();
        $data['product'] = app('App\Http\Controllers\FrontendController')->getProducts(array('id' => $id), 1)->first();
        $data['discounts'] = Discount::where('store_id', auth()->user()->store_id)->get();
        $data['categories'] = Category::where('store_id',auth()->user()->store_id)->get();
        $data['sub_categories'] = SubCategory::where('category_id', $data['product']->category_id)->get();
        return view('backend.product.edit')->with($data);
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
        $product = Product::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'mimes:jpeg,png,jpg,gif,svg',
            'category_id'=>'required|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            'brand_id'=>'nullable|exists:brands,id',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'price'=>'required|numeric',
            'purchasing_price' => 'required|numeric',
            'discount'=>'nullable|numeric',
            'images.*'=>'mimes:jpeg,png,jpg,gif,svg',
        ]);

        $data = array();
        $data['return_policy'] = $request->return;
        $data['is_featured'] = $request->input('is_featured', 0);
        $data["title"] = $request->title;
        $data["brand_id"] = $request->brand_id;
        $data["category_id"] = $request->category_id;
        $data["sub_category_id"] = $request->sub_category_id;
        $data["description"] = $request->description;
        $data["purchasing_price"] = $request->purchasing_price;
        $data["purchasing_tax"] = $request->purchasing_tax;
        $data["purchasing_gross"] = $request->purchasing_gross;
        $data["price"] = $request->price;
        $data["discount"] = $request->discount;
        $data["selling_gross"] = $request->selling_gross;
        $data["condition"] = $request->condition;
        $data["status"] = $request->status;


        if($request->hasFile('photo')){
          $user_image = $request->file('photo');
          $extension = $user_image->getClientOriginalExtension();
          $fileName = uniqid() . '.' . $extension;
          $old_file='images/products'.$fileName;
          if(file_exists($old_file) && $fileName!="default.png"){
              unlink($old_file);
          }
          $user_image->move('images/products', $fileName);
          $data['photo']= $fileName;
        }else {
            $photo = '';
        }

        $images_arr = [];
        if($request->hasfile('images')){
            foreach($request->file('images') as $file){
                $name = uniqid().'.'.$file->extension();
                $file->move('images/products', $name);  
                $images_arr[] = array('image'=> $name);
            }
            $product->images()->createMany($images_arr);
        }
        $status = $product->fill($data)->save();

        $productStockArr = [];
        $data['colors'] = $request->colors;
        $data['sizes'] = $request->sizes;
        $data['stock'] = $request->stock;
        $data['productStockIds'] = $request->productStockIds;
        $product->productStock()->whereNotIn('id', $data['productStockIds'])->delete();
        
        foreach($data['stock'] as $key => $stock){
            if (array_key_exists($key , $data['productStockIds'])){
                $product->productStock()->where('id', $data['productStockIds'][$key])->update(['stock'=> $stock, 'color_id'=> $data['colors'][$key], 'size_id'=> $data['sizes'][$key]]);
                continue;
            }
            if($data['stock'][$key] == '' || $data['colors'][$key] == '' || $data['sizes'][$key] == '')
            continue;
            $productStockArr[] = array('stock'=> $stock, 'color_id'=> $data['colors'][$key], 'size_id'=> $data['sizes'][$key]);
        }
        $product->productStock()->createMany($productStockArr);
        if($status){
            return back()->with('success','Product Successfully updated');
        }
        else{
            return back()->with('error','Please try again!!');
        }
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $status = $product->delete();
        if($status){
            request()->session()->flash('success','Product successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('product.index');
    }

    public function remove_product_image(Request $request)
    {
        $p = ProductImage::findOrFail($request->image_id);
        $file = 'products/images/'.$p->image;
        if(File::exists(public_path($file))){
            File::delete(public_path($file));
        }
        $p->delete();
        return ['status'=>'success'];
    }
}