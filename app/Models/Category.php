<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function parent_info(){
        return $this->hasOne('App\Models\Category','id','parent_id');
    }
    
    public static function shiftChild($cat_id){
        return Category::whereIn('id',$cat_id)->update(['is_parent'=>1]);
    }
    public static function getChildByParentID($id){
        return Category::where('parent_id',$id)->orderBy('id','ASC')->pluck('title','id');
    }

    public function child_cat(){
        return $this->hasMany('App\Models\Category','parent_id','id')->where('status','active');
    }

    public function products(){
        return $this->hasMany(Product::class)->where('status','active');
    }
    public function sub_products(){
        return $this->hasMany('App\Models\Product','child_cat_id','id')->where('status','active');
    }

    public static function getProductBySubCat($slug){
        // return $slug;
        return Category::with('sub_products')->where('slug',$slug)->first();
    }
    public static function countActiveCategory(){
        $data=Category::where('status','active')->where('store_id',auth()->user()->store_id)->count();
        if($data){
            return $data;
        }
        return 0;
    }

    public function sub_category(){
        return $this->hasMany('App\Models\Category', 'parent_id','id')->where('status','active');
    }


    public function sub_categories(){
        return $this->hasMany(SubCategory::class);
    }
    public function product(){
        return $this->hasMany(Product::class);
    }

}
