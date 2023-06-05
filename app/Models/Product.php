<?php

namespace App\Models;

use App\ChoiceModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\Size;
use App\StoreModal;
use App\Models\Color;


class Product extends Model
{
    protected $guarded = [];
    //protected $fillable=['title','slug','summary','description','cat_id','child_cat_id','price','brand_id','discount','status','photo','size','stock','is_featured','condition'];

    public function cat_info(){
        return $this->hasOne('App\Models\Category','id','cat_id');
    }
    public function sub_cat_info(){
        return $this->hasOne('App\Models\Category','id','child_cat_id');
    }
    public static function getAllProduct(){
        return Product::with(['cat_info','sub_cat_info'])->orderBy('id','desc')->paginate(10);
    }
    public function rel_prods(){
        return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('status','active')->orderBy('id','DESC')->limit(8);
    }
    public function getReview(){
        return $this->hasMany('App\Models\ProductReview','product_id','id')->with('user_info')->where('status','active')->orderBy('id','DESC');
    }
    // public static function getProductBySlug($slug){
    //     return Product::with(['cat_info','rel_prods','getReview'])->where('slug',$slug)->first();
    // }
    public static function countActiveProduct(){
        $data = Product::where('status','active')->where('store_id',auth()->user()->store_id)->count();
        if($data){
            return $data;
        }
        return 0;
    }

    public function carts(){
        return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class,'product_id','id')->whereNotNull('cart_id');
    }

    public function wishlist(){
        return $this->hasMany(Wishlist::class);
    }

    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class, 'product_id', 'id');
    }

    public function store()
    {
        return $this->hasOne(StoreModal::class,'id','store_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productStock()
    {
        return $this->hasMany(ProductStock::class); //->selectRaw('sum(stock) as stock_total, color_id, size_id, product_id')->groupBy('product_id', 'color_id', 'size_id');
    }

    // public function sizes()
    // {
    //     return $this->belongsToMany(Size::class, 'product_sizes');
    // }

    // public function colors()
    // {
    //     return $this->hasMany(Color::class);
    // }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function sub_category(){
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    }

    public function brand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

}
